<?php

class SettingsProvider implements t3lib_Singleton {
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
     * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $manager
     */
    public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $manager) {
        global $_EXTKEY;
        $this->settings = $manager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $global = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
        $global = $this->cleanSettingKeys($global);
        $this->settings = array_merge($this->settings, $global);
    }
}
