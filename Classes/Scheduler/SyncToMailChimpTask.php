<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Mato Ilic <info@matoilic.ch>
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

namespace MatoIlic\T3Chimp\Scheduler;

use MatoIlic\T3Chimp\Domain\Model\FrontendUser;
use MatoIlic\T3Chimp\MailChimp\Field;
use MatoIlic\T3Chimp\MailChimp\Form;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SyncToMailChimpTask extends Base {
    /**
     * @var string
     */
    private $listId;

    /**
     * @var array
     */
    private $mappings = array();

    /**
     * @param array $users
     * @param array $interestGroupings
     */
    private function addSubscribedUsers(array $users, array $interestGroupings) {
        $fieldDefinitions = $this->mailChimp->getFieldsFor($this->listId);
        /** @var Form $form */
        $form = $this->objectManager->get('MatoIlic\\T3Chimp\\MailChimp\\Form', $fieldDefinitions, $this->listId);
        $form->setInterestGroupings($interestGroupings);
        $form->setDisableCaptcha(TRUE);

        $groupingFields = array();
        foreach($interestGroupings as $grouping) {
            $groupingFields[] = $grouping['name'];
        }

        $usersToSubscribe = array();
        foreach($users as $user) {
            $form->bindRequest($this->createRequest($user, $groupingFields));

            if($form->isValid()) {
                $usersToSubscribe[] = $this->createSubscriber($form);
            } else {
                $this->logInvalidSubscription($form);
            }
        }

        if(count($usersToSubscribe) > 0) {
            if($this->debuggingEnabled()) var_dump($usersToSubscribe);
            $this->mailChimp->addSubscribers($this->listId, $usersToSubscribe);
        }

        unset($usersToSubscribe);
    }

    /**
     * @param FrontendUser $user
     * @param array $groupingFields
     * @return Request
     */
    private function createRequest($user, array $groupingFields) {
        $request = $this->objectManager->get('MatoIlic\\T3Chimp\\Scheduler\\Request');

        $subscriber = array();
        foreach($this->mappings as $tag => $dbField) {
            if(!strpos($tag, '.')) {
                $subscriber[$tag] = (strlen($dbField) > 0) ? $user[$dbField] : '';
                if(in_array($tag, $groupingFields)) {
                    $values = array();
                    foreach(explode(';', $subscriber[$tag]) as $value) {
                        $value = trim($value);
                        if(strlen($value) > 0) {
                            $values[] = $value;
                        }
                    }
                    $subscriber[$tag] = $values;
                }
            } else { //map multi-part fields, e.g. address fields
                $tag = explode('.', $tag);
                if(!array_key_exists($tag[0], $subscriber)) {
                    $subscriber[$tag[0]] = array();
                }

                $subscriber[$tag[0]][strtolower($tag[1])] = (strlen($dbField) > 0) ? $user[$dbField] : '';
            }
        }

        $request->setArguments($subscriber);

        return $request;
    }

    /**
     * @param Form $form
     * @return array
     */
    private function createSubscriber($form) {
        list($fieldValues, $groupings) = $this->mailChimp->separateForm($form);

        $preparedValues = $this->mailChimp->prepareFieldValues($fieldValues, $groupings);
        $subscriber = array(
            'MERGE_VARS' => $preparedValues['mergeVars'],
            'EMAIL' => array('email' => $preparedValues['email'])
        );

        return $subscriber;
    }

    /**
     * @return boolean Returns TRUE on successful execution, FALSE on error
     */
    public function executeTask() {
        $users = $this->retrieveUsers();
        $groupings = $this->mailChimp->getInterestGroupingsFor($this->listId);

        try {
            $this->removeUnsubscribedUsers($users);
            $this->addSubscribedUsers($users, $groupings);
        } catch(Exception $e) {
            $GLOBALS['BE_USER']->writeLog(4, 0, 1, 0, '[t3chimp]: ' . $e->getMessage());
            $GLOBALS['BE_USER']->writeLog(4, 0, 1, 0, '[t3chimp]: ' . $e->getTraceAsString());

            return FALSE;
        }

        return TRUE;
    }

    /**
     * @return string
     */
    public function getListId() {
        return $this->listId;
    }

    /**
     * @return array
     */
    public function getMappings() {
        return $this->mappings;
    }

    /**
     * @param Form $form
     */
    private function logInvalidSubscription($form) {
        $error = 'Could not synchronize user ' . $form->getField('EMAIL')->getValue() . ":\n";
        /** @var Field $field */
        foreach($form->getFields(TRUE) as $field) {
            foreach($field->getErrors() as $error) {
                $error .= $field->getName() . ': ' . $this->translate($error) . "\n";
            }
        }

        GeneralUtility::sysLog($error, 't3chimp', 2);
    }

    /**
     * @param array $users
     */
    private function removeUnsubscribedUsers(array $users) {
        $subscribers = $this->retrieveSubscribers($this->listId);

        $usersToUnsubscribe = array();
        foreach($subscribers as $subscriber) {
            $email = $subscriber['email'];
            if(!array_key_exists($email, $users) || !$users[$email]['subscribed_to_newsletter']) {
                $usersToUnsubscribe[] = array('email' => $email);
            }
        }

        if(count($usersToUnsubscribe) > 0) {
            if($this->debuggingEnabled()) var_dump($usersToUnsubscribe);
            $this->mailChimp->removeSubscribers($this->listId, $usersToUnsubscribe, TRUE);
        }
    }

    /**
     * @return array
     */
    private function retrieveUsers() {
        $users = array();
        foreach($this->userRepo->findSubscribedUsers() as $user) {
            $email = $user[$this->mappings['EMAIL']];
            $users[$email] = $user;
        }

        return $users;
    }

    /**
     * @param string $listId
     */
    public function setListId($listId) {
        $this->listId = $listId;
    }

    /**
     * @param array $mappings
     */
    public function setMappings(array $mappings) {
        $this->mappings = $mappings;
    }
}
