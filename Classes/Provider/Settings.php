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

namespace MatoIlic\T3Chimp\Provider;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class Settings {
    /**
     * @var ConfigurationManagerInterface
     */
    private $configurationManager;

    /**
     * @var string
     */
    private $extKey;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var array
     */
    private $settings;

    /**
     * @var array
     */
    private static $settingsCache = array();

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

    public function getApiKey() {
        // check if there is a site specific api key
        if(TYPO3_version >= '6.0.0' && $this->settings['settings']['apiKey'] && $this->settings['settings']['apiKey'][0] != '{') {
            return $this->settings['settings']['apiKey'];
        }

        $tsConfig = BackendUtility::getPagesTSconfig($GLOBALS['TSFE']->id);
        $tsConfig = $tsConfig['plugin.']['tx_' . $this->extKey . '.'];
        if($tsConfig['settings.']['apiKey'] && $tsConfig['settings.']['apiKey'][0] != '{') {
            return $tsConfig['settings.']['apiKey'];
        }

        // global api key
        return $this->settings['apiKey'];
    }

    /**
     * @return string
     */
    public function getExtKey() {
        return $this->extKey;
    }

    /**
     * @return bool
     */
    public function getIsCacheDisabled() {
        $config = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

        return array_key_exists('no_cache', $config['config.']) && $config['config.']['no_cache'] == '1';
    }

    public function initialize() {
        $listType = explode('_', $this->configurationManager->getContentObject()->data['list_type']);
        if(strlen($listType[0]) > 0) {
            $this->extKey = $listType[0];
        } else { //initialized via typoscript USER_INT
            $config = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
            $this->extKey = array_key_exists('extensionName', $config) ? $config['extensionName'] : 't3chimp';
        }

        $this->extKey = strtolower($this->extKey);
        $this->loadConfiguration();
    }

    /**
     * @param ObjectManager $manager
     */
    public function injectObjectManager(ObjectManager $manager) {
        $this->injectSessionProvider($manager->get('MatoIlic\\T3Chimp\\Provider\\Session'));
        $this->injectConfigurationManager($manager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'));
        $this->initialize();
    }

    /**
     * @param ConfigurationManagerInterface $manager
     */
    private function injectConfigurationManager(ConfigurationManagerInterface $manager) {
        $this->configurationManager = $manager;
        $this->loadConfiguration();
    }

    /**
     * @param Session $provider
     */
    private function injectSessionProvider(Session $provider) {
        $this->session = $provider;
    }

    private function loadConfiguration() {
        if(!array_key_exists($this->extKey, self::$settingsCache)) {
            $this->settings = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
            if($this->settings == NULL) {
                $this->settings = array();
            }

            //read session stored settings for ajax requests
            $this->session->setContext($this->extKey);
            if(array_key_exists('type', $_GET) && $this->session->settings != null) {
                $this->settings = $this->session->settings;
            } else {
                $this->session->settings = $this->settings;
            }

            $this->settings = array_merge($this->settings, $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK));
            $global = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);

            if(is_array($global)) {
                $global = $this->cleanSettingKeys($global);
                self::$settingsCache[$this->extKey] = array_merge($this->settings, $global);
            } else {
                self::$settingsCache[$this->extKey] = $this->settings;
            }
        }

        $this->settings = self::$settingsCache[$this->extKey];
    }
}
