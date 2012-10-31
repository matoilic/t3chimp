<?php

class Tx_T3chimp_Provider_FlexFormValues {
    /**
     * @var MCAPI
     */
    private $api;

    public function __construct() {
        $globals = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3chimp']);
        $this->api = new Tx_T3chimp_MailChimp_Api($globals['apiKey']);
    }

    /**
     * @param array $config
     * @return array
     */
    public function getLists($config) {
        $result = $this->api->lists();

        foreach($result['data'] as $list) {
            $config['items'][] = array($list['name'], $list['id']);
        }

        return $config;
    }
}
