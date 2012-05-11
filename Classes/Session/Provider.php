<?php

class Tx_T3chimp_Session_Provider implements t3lib_Singleton {
    const KEY = 'tx_t3chimp';

    /**
     * @var tslib_feUserAuth
     */
    private $feUser;

    /**
     * @var array
     */
    private $sessionData = array();

    public function __construct() {
        //hold a reference to the fe_user object so the destructor has guaranteed access to it
        $this->feUser = $GLOBALS['TSFE']->fe_user;
        $data = $this->feUser->getKey('ses', self::KEY);

        if($data != null) {
            $this->sessionData = unserialize($data);
        }
    }

    public function __destruct() {
        $this->feUser->setKey('ses', self::KEY, serialize($this->sessionData));
        $this->feUser->storeSessionData();
    }

    public function __get($key) {
        return $this->sessionData[$key];
    }

    public function __isset($key) {
        return isset($this->sessionData[$key]);
    }

    public function __set($key, $value) {
        $this->sessionData[$key] = $value;
    }

    public function __unset($key) {
        unset($this->sessionData[$key]);
    }
}
