<?php
    abstract class Tx_T3chimp_Controller_BaseController extends Tx_Extbase_MVC_Controller_ActionController {
        protected $currentLanguageId = 0;
        const EXTKEY = 't3chimp';
        protected $isLoggedIn = false;

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

        protected function isInUserGroup($group) {
            if(!$this->isLoggedIn) {
                return false;
            }

            return in_array($group, $GLOBALS['TSFE']->fe_user->groupData['title']);
        }

        public function initializeAction() {
            parent::initializeAction();
            $this->mergeSettings();
            $this->currentLanguageId = $GLOBALS['TSFE']->sys_language_uid;
            $this->isLoggedIn = ($GLOBALS['TSFE']->fe_user->user != null);
            if($this->isLoggedIn) {
                $GLOBALS['TSFE']->fe_user->fetchGroupData();
            }

            $this->response->addAdditionalHeaderData('<meta name="lang" content="' . $this->currentLanguageId . '" />');
        }

        public function initializeView($view) {
            parent::initializeView($view);
        }

        private function mergeSettings() {
            $global = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][self::EXTKEY]);
            $global = $this->cleanSettingKeys($global);
            $this->settings = array_merge($this->settings, $global);
        }

        protected function translate($key) {
            return Tx_Extbase_Utility_Localization::translate($key, $this->extensionName);
        }
    }