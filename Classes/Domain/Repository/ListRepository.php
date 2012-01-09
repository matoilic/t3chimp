<?php

class Tx_T3chimp_Domain_Repository_ListRepository {
    private $api;

    public function __construct() {
        $this->api = new MCAPI(T3CHIMP_API_KEY);
    }

    public function addSubscriber($listId, $fieldValues) {
        $mergeVars = array();
        $email = '';

        foreach($fieldValues as $field) {
            if($field['tag'] != 'EMAIL') {
                $mergeVars[$field['tag']] = $field['value'];
            } else {
                $email = $field['value'];
            }
        }

        $this->api->listSubscribe($listId, $email, $mergeVars, 'html', false, true, true, true);
        $this->checkApi();
    }

    private function checkApi($ignoreCode = false) {
        $errorCode = $this->api->errorCode;
        if($errorCode != '' && !in_array($errorCode, $ignoreCode)) {
            throw new Exception('Mailchimp error: ' . $this->api->errorMessage . '(' . $this->api->errorCode . ')');
        }
    }

    public function getFieldsFor($listId) {
        $fields = $this->api->listMergeVars($listId);
        $this->checkApi();

        return $fields;
    }

    public function getFlexFormValues($config) {
        $result = $this->api->lists();
        $this->checkApi();

        foreach($result['data'] as $list) {
            $config['items'][] = array($list['name'], $list['id']);
        }

        return $config;
    }

    public function removeSubscriber($listId, $email) {
        $this->api->listUnsubscribe($listId, $email);
        $this->checkApi(array(215, 232));
    }
}
