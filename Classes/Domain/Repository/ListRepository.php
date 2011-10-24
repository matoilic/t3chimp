<?php

class Tx_T3chimp_Domain_Repository_ListRepository {
    public function getFlexFormValues($config) {
        $api = new MCAPI(T3CHIMP_API_KEY);
        $result = $api->lists();

        foreach($result['data'] as $list) {
            $config['items'][] = array($list['name'], $list['id']);
        }

        return $config;
    }
}
