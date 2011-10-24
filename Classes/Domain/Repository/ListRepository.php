<?php

class Tx_T3chimp_Domain_Repository_ListRepository {
    private $api;

    public function __construct() {
        $this->api = new MCAPI(T3CHIMP_API_KEY);
    }

    private function checkApi() {
        if($this->api->errorCode) {
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
}
