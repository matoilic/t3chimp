<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Mato Ilic <info@matoilic.ch>
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

class Tx_T3chimp_Service_MailChimp implements t3lib_Singleton {
    const ACTION_UNSUBSCRIBE = -1;
    const ACTION_SUBSCRIBE = 1;
    const ACTION_UPDATE = 2;

    /**
     * @var Tx_T3chimp_MailChimp_Api
     */
    protected $api;

    /**
     * @var array
     */
    protected static $exceptions = array(
        211 => 'ListInvalidOption',
        214 => 'ListAlreadySubscribed',
        215 => 'ListNotSubscribed',
        230 => 'EmailAlreadySubscribed',
        231 => 'EmailAlreadyUnsubscribed',
        232 => 'EmailNotExists',
        502 => 'InvalidEmail'
    );

    /**
     * @var string
     */
    protected static $exceptionNamespace = 'Tx_T3chimp_Service_MailChimp_';

    /**
     * @var Tx_Extbase_Object_ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var Tx_T3chimp_Provider_Settings
     */
    protected $settingsProvider;

    /**
     * TODO make sending of welcome message configurable
     * @param string $listId
     * @param array $fieldValues
     * @param array $interestGroupings
     * @param bool $doubleOptIn
     * @param string $emailType
     * @param bool $sendWelcomeEmail
     */
    public function addSubscriber($listId, $fieldValues, $interestGroupings, $doubleOptIn = true, $emailType = 'html', $sendWelcomeEmail = false) {
        $data = $this->prepareFieldValues($fieldValues, $interestGroupings);

        $this->api->listSubscribe($listId, $data['email'], $data['mergeVars'], $emailType, $doubleOptIn, false, true, $sendWelcomeEmail);
        $this->checkApi();
    }

    /**
     * @param string $listId
     * @param array $subscribers
     * @param bool $doubleOptIn
     * @param string $emailType
     */
    public function addSubscribers($listId, $subscribers, $doubleOptIn = false, $emailType = 'html') {
        for($i = 0, $n = count($subscribers); $i < $n; $i++) {
            $subscribers[$i]['EMAIL_TYPE'] = $emailType;
        }

        $response = $this->api->listBatchSubscribe($listId, $subscribers, $doubleOptIn, true, true);
        $this->logResponseErrors($response);

        $this->checkApi();
    }

    protected function checkApi() {
        if(!empty($this->api->errorCode)) {
            $this->throwException($this->api->errorCode, $this->api->errorMessage);
        }
    }

    /**
     * @param string $listId
     * @return string
     */
    protected function getCachePath($listId) {
        return PATH_site . 'typo3temp/tx_t3chimp/' . str_replace(array('/', '\\', '..'), '', $listId);
    }

    /**
     * @param int $listId
     * @return array
     */
    public function getFieldsFor($listId) {
        $fields = $this->api->listMergeVars($listId);
        $this->checkApi();

        return $fields;
    }

    /**
     * @param string $email if passed, the form will be prefilled with the subscriber's current profile data
     * @return Tx_T3chimp_MailChimp_Form
     */
    public function getForm($email = null) {
        $form = $this->getFormFor($this->settingsProvider->get('subscriptionList'));

        if($email != null) {
            $data = $this->getSubscriptionInfo($email);

            if($data != NULL) {
                foreach($form->getFields() as $field) {
                    $field->setApiValue($data[$field->getTag()]);
                }
            }
        }

        return $form;
    }

    /**
     * @param string $listId
     * @return Tx_T3chimp_MailChimp_Form
     */
    public function getFormFor($listId) {
        $form = $this->getFormFromCache($listId . '.mc');
        if($form !== null) {
            return $form;
        }

        $fields = $this->getFieldsFor($listId);
        try {
            $interestGroupings = $this->getInterestGroupingsFor($listId);
        } catch(Tx_T3chimp_Service_MailChimp_ListInvalidOptionException $ex) { //if interest groups are not enabled
            $interestGroupings = array();
        }

        if(TYPO3_version < '6.1.0') {
            $form = $this->objectManager->create('Tx_T3chimp_MailChimp_Form', $fields, $listId);
        } else {
            $form = $this->objectManager->get('Tx_T3chimp_MailChimp_Form', $fields, $listId);
        }
        $form->setInterestGroupings($interestGroupings);

        $this->writeToCache($form);

        return $form;
    }

    /**
     * @param $listId
     * @return Tx_T3chimp_MailChimp_Form|null
     */
    protected function getFormFromCache($listId) {
        if($this->settingsProvider->getIsCacheDisabled()) {
            return null;
        }

        $file = $this->getCachePath($listId . '.mc');

        if(file_exists($file)) {
            return unserialize(file_get_contents($file));
        }

        return null;
    }

    /**
     * @param int $listId
     * @return array
     */
    public function getInterestGroupingsFor($listId) {
        try {
            $groups = $this->api->listInterestGroupings($listId);
            $this->checkApi();
        } catch(Tx_T3chimp_Service_MailChimp_ListInvalidOptionException $ex) { //if interest groups are not enabled
            $groups = array();
        }

        return ($groups == null) ? array() : $groups;
    }

    /**
     * @return array
     */
    public function getLists() {
        $lists = $this->api->lists();
        $this->checkApi();

        return $lists['data'];
    }

    /**
     * @param string $listId
     * @return array
     */
    public function getSubscribersFor($listId) {
        $subscribers = array();

        $page = 0;
        $limit = 15000;
        do {
            $response = $this->api->listMembers($listId, 'subscribed', null, $page, $limit);
            $this->checkApi();
            $page++;
            $subscribers = array_merge($subscribers, $response['data']);
        } while(count($subscribers) < $response['total']);

        return $subscribers;
    }

    public function getSubscriptionInfo($email) {
        $info = $this->api->listMemberInfo($this->settingsProvider->get('subscriptionList'), array($email));
        $this->checkApi();

        if(count($info['data']) == 0) {
            return array();
        }

        $mergeVars = $info['data'][0]['merges'];

        if(array_key_exists('GROUPINGS', $mergeVars)) {
            foreach($mergeVars['GROUPINGS'] as $grouping) {
                $mergeVars[$grouping['name']] = $grouping['groups'];
            }
        }

        return $mergeVars;
    }

    public function initialize() {
        $this->settingsProvider->initialize();
        $this->api = new Tx_T3chimp_MailChimp_Api($this->settingsProvider->getApiKey(), $this->settingsProvider->get('secureConnection'));
    }

    /**
     * @param Tx_Extbase_Object_ObjectManager $objectManager
     */
    public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    /**
     * @param Tx_T3chimp_Provider_Settings $provider
     */
    public function injectSettingsProvider(Tx_T3chimp_Provider_Settings $provider) {
        $this->settingsProvider = $provider;
    }

    /**
     * @param array $response
     */
    protected function logResponseErrors($response) {
        foreach($response['errors'] as $error) {
            $message = 'T3Chimp: Error(' . $error['code'] . ') => ' . $error['message'];
            t3lib_div::sysLog($message, 't3chimp', 1);
        }
    }

    /**
     * @param array $fieldValues
     * @param array $interestGroupings
     * @return array
     */
    public function prepareFieldValues($fieldValues, $interestGroupings) {
        $mergeVars = array();
        $email = '';

        foreach($fieldValues as $field) {
            if($field['tag'] != 'EMAIL') {
                $mergeVars[$field['tag']] = $field['value'];
            } else {
                $email = $field['value'];
            }
        }

        $mergeVars['GROUPINGS'] = $interestGroupings;

        return array('email' => $email, 'mergeVars' => $mergeVars);
    }

    /**
     * @param int $listId
     * @param string $email
     */
    public function removeSubscriber($listId, $email) {
        $this->api->listUnsubscribe($listId, $email);
        $this->checkApi();
    }

    /**
     * @param int $listId
     * @param array $emails
     * @param bool $delete
     * @param bool $sendGoodbye
     * @param bool $sendNotification
     */
    public function removeSubscribers($listId, $emails, $delete = FALSE, $sendGoodbye = FALSE, $sendNotification = FALSE) {
        $response = $this->api->listBatchUnsubscribe($listId, $emails, $delete, $sendGoodbye, $sendNotification);
        $this->logResponseErrors($response);

        $this->checkApi();
    }

    /**
     * @param Tx_T3chimp_MailChimp_Form $form
     * @return array returns field values at index 0 and interest groupings at index 1
     */
    public function separateForm(Tx_T3chimp_MailChimp_Form $form) {
        $fieldValues = array();
        $selectedGroupings = array();

        foreach($form->getFields(true) as $field) {
            if($field->getIsActionField()) {
                continue;
            } elseif($field->getIsInterestGroup()) {
                $selectedGroupings[] = array(
                    'id' => $field->getGroupingId(),
                    'groups' => $field->getApiValue()
                );
            } else {
                $fieldValues[] = array(
                    'tag' => $field->getTag(),
                    'value' => $field->getApiValue()
                );
            }
        }

        return array($fieldValues, $selectedGroupings);
    }

    /**
     * @param Tx_T3chimp_MailChimp_Form $form
     * @return int the performed action
     */
    public function saveForm(Tx_T3chimp_MailChimp_Form $form) {
        if($form->getField('FORM_ACTION')->getValue() == 'subscribe') {
            list($fieldValues, $selectedGroupings) = $this->separateForm($form);

            try {
                $this->addSubscriber(
                    $form->getListId(),
                    $fieldValues,
                    $selectedGroupings,
                    $this->settingsProvider->get('doubleOptIn'),
                    'html',
                    !$this->settingsProvider->get('disableWelcomeEmail')
                );

                $action = self::ACTION_SUBSCRIBE;
            } catch(Tx_T3chimp_Service_MailChimp_AlreadySubscribedException $ex) {
                $this->updateSubscriber(
                    $form->getListId(),
                    $fieldValues,
                    $selectedGroupings
                );

                $action = self::ACTION_UPDATE;
            }

        } else {
            $this->removeSubscriber($form->getListId(), $form->getField('EMAIL')->getApiValue());
            $action = self::ACTION_UNSUBSCRIBE;
        }

        return $action;
    }

    /**
     * @param int $errorCode
     * @param string $errorMessage
     * @throws Tx_T3chimp_Service_MailChimp_Exception
     */
    protected function throwException($errorCode, $errorMessage) {
        $exceptionClass = self::$exceptionNamespace;
        if(array_key_exists($errorCode, self::$exceptions)) {
            $exceptionClass .= self::$exceptions[$errorCode];
        }
        $exceptionClass .= "Exception";

        throw new $exceptionClass("MailChimp error: $errorMessage ($errorCode)", $errorCode);
    }

    /**
     * @param Tx_T3chimp_MailChimp_Form $form
     */
    protected function writeToCache(Tx_T3chimp_MailChimp_Form $form) {
        if($this->settingsProvider->getIsCacheDisabled()) {
            return;
        }

        $cachePath = $this->getCachePath('');
        if(!file_exists($cachePath)) {
            mkdir($cachePath, 0777, true);
            file_put_contents($this->getCachePath('index.html'), '');
        }

        $file = $this->getCachePath($form->getListId() . '.mc');
        file_put_contents($file, serialize($form));
    }

    /**
     * @param string $listId
     * @param array $fieldValues
     * @param array $interestGroupings
     * @param string $emailType
     */
    public function updateSubscriber($listId, $fieldValues, $interestGroupings, $emailType = 'html') {
        $data = $this->prepareFieldValues($fieldValues, $interestGroupings);

        $this->api->listUpdateMember($listId, $data['email'], $data['mergeVars'], $emailType, true);
        $this->checkApi();
    }
}
