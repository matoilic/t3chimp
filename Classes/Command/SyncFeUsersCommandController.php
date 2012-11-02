<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Mato Ilic <info@matoilic.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class Tx_T3chimp_Command_SyncFeUsersCommandController extends Tx_Extbase_MVC_Controller_CommandController {
    /**
     * @var Tx_T3chimp_Service_MailChimp
     */
    private $mailChimp;

    /**
     * @var Tx_T3chimp_Domain_Repository_FrontendUserRepository
     */
    private $userRepo;

    /**
     * @param Tx_T3chimp_Domain_Repository_FrontendUserRepository $repo
     */
    public function injectFrontendUserRepository(Tx_T3chimp_Domain_Repository_FrontendUserRepository $repo) {
        $this->userRepo = $repo;
    }

    /**
     * @param Tx_T3chimp_Service_MailChimp $service
     */
    public function injectMailChimpService(Tx_T3chimp_Service_MailChimp $service) {
        $this->mailChimp = $service;
    }

    /**
     * @param string $listId
     * @return array
     */
    public function retrieveSubscribers($listId) {
        $subscribers = array();
        foreach($this->mailChimp->getSubscribersFor($listId) as $subscriber) {
            $subscribers[$subscriber['email']] = $subscriber;
        }

        return $subscribers;
    }

    /**
     * @param array $mappings
     * @return array
     */
    private function retrieveUsers($mappings) {
        $users = array();
        foreach($this->userRepo->findSubscribedUsers() as $user) {
            $email = $user[$mappings['EMAIL']];
            $users[$email] = $user;
        }

        return $users;
    }

    /**
     * @param string $mappingsString
     * @return array
     */
    private function splitMappings($mappingsString) {
        $mappings = array();
        foreach(explode(',', $mappingsString) as $mapping) {
            $mapping = explode('=', $mapping);
            $mappings[strtoupper(trim($mapping[0]))] = trim($mapping[1]);
        }

        return $mappings;
    }

    /**
     * @param string $listId the id of the list the users should be subscribed to
     * @param string $mappings the field mappings
     */
    public function syncFeUsersCommand($listId, $mappings) {
        $fieldDefinitions = $this->mailChimp->getFieldsFor($listId);
        /** @var Tx_T3chimp_MailChimp_Form $form */
        $form = $this->objectManager->create('Tx_T3chimp_MailChimp_Form', $fieldDefinitions, $listId);
        $request = new Tx_T3chimp_Command_Request();
        $mappings = $this->splitMappings($mappings);
        $users = $this->retrieveUsers($mappings);
        $subscribers = $this->retrieveSubscribers($listId);

        $usersToUnsubscribe = array();
        foreach($subscribers as $subscriber) {
            $email = $subscriber['email'];
            if(!array_key_exists($email, $users) || !$users[$email]['subscribed_to_newsletter']) {
                $usersToUnsubscribe[] = $email;
            }
        }

        if(count($usersToUnsubscribe) > 0) {
            var_dump($usersToUnsubscribe);
            $this->mailChimp->removeSubscribers($listId, $usersToUnsubscribe, TRUE);
        }

        unset($usersToUnsubscribe);

        $usersToSubscribe = array();
        foreach($users as $user) {
            $subscriber = array();
            foreach($mappings as $tag => $dbField) {
                if(!strpos($tag, '.')) {
                    $subscriber[$tag] = $user[$dbField];
                } else { //map multi-part fields, e.g. address fields
                    $tag = explode('.', $tag);
                    if(!array_key_exists($tag[0], $subscriber)) {
                        $subscriber[$tag[0]] = array();
                    }

                    $subscriber[$tag[0]][strtolower($tag[1])] = $user[$dbField];
                }
            }

            $request->setArguments($subscriber);
            $form->bindRequest($request);

            if($form->isValid()) {
                $subscriber = array();
                foreach($form->getFields() as $field) {
                    if(!($field instanceof Tx_T3chimp_MailChimp_Field_Action || $field instanceof Tx_T3chimp_MailChimp_Field_InterestGrouping)) {
                        $subscriber[$field->getTag()] = $field->getApiValue();
                    }
                }
                $usersToSubscribe[] = $subscriber;
            } else {
                //TODO log validation errors
            }
        }

        if(count($usersToSubscribe) > 0) {
            var_dump($usersToSubscribe);
            $this->mailChimp->addSubscribers($listId, $usersToSubscribe);
        }

        unset($usersToSubscribe);
    }
}
