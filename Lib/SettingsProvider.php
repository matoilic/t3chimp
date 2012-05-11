<?php

class SettingsProvider implements t3lib_Singleton {
    /**
     * @var Tx_T3chimp_Session_Provider
     */
    private $session;

    /**
     * @var array
     */
    private $settings = array();

    /**
     * @param mixed $settings
     * @return array
     */
    private function cleanSettingKeys($settings) {
        if(!is_array($settings)) {
            return $settings;
        }

        $cleanedSettings = array();
        foreach($settings as $key => $value) {
            if(substr($key, -1) == '.') {
                $key = substr($key, 0, strlen($key) - 1);
            }

            $cleanedSettings[$key] = $this->cleanSettingKeys($value);
        }

        return $cleanedSettings;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key) {
        return $this->settings[$key];
    }

    /**
     * @return array
     */
    public function getAll() {
        return $this->settings;
    }

    /**
     * @param Tx_Extbase_Object_ObjectManager $manager
     */
    public function injectObjectManager(Tx_Extbase_Object_ObjectManager $manager) {
        $this->injectSessionProvider($manager->get('Tx_T3chimp_Session_Provider'));
        $this->injectConfigurationManager($manager->get('Tx_Extbase_Configuration_ConfigurationManagerInterface'));
    }

    /**
     * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $manager
     */
    private function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $manager) {
        $this->settings = $manager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);

        //read session stored settings for ajax requests
        if(count($this->settings) == 0 && $this->session->settings != null) {
            $this->settings = $this->session->settings;
        } else {
            $this->session->settings = $this->settings;
        }

        $global = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3chimp']);
        $global = $this->cleanSettingKeys($global);
        $this->settings = array_merge($this->settings, $global);
    }

    /**
     * @param Tx_T3chimp_Session_Provider $provider
     */
    private function injectSessionProvider(Tx_T3chimp_Session_Provider $provider) {
        $this->session = $provider;
    }
}
