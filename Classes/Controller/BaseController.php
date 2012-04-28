<?php
    abstract class Tx_T3chimp_Controller_BaseController extends Tx_Extbase_MVC_Controller_ActionController {
        const EXTKEY = 't3chimp';

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

        public function initializeAction() {
            parent::initializeAction();

            $actionAnnotations = $this->reflectionService->getMethodTagsValues(get_class($this), $this->actionMethodName);

            if(!isset($actionAnnotations['NotCsrfProtected'])) {
                $submittedToken = '';
                if($this->request->hasArgument('csrf-token')) {
                    $submittedToken = $this->request->getArgument('csrf-token');
                } else if(isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
                    $submittedToken = $_SERVER['HTTP_X_CSRF_TOKEN'];
                }

                if($submittedToken !== $this->initializeCsrfToken()) {
                    throw new Exception('t3chimp: invalid CRSF token');
                }
            }

            $this->mergeSettings();

            $this->response->addAdditionalHeaderData('<meta name="t3chimp:lang" content="' . $GLOBALS['TSFE']->sys_language_uid . '" />');
            $this->response->addAdditionalHeaderData('<meta name="t3chimp:lang-iso" content="' . $GLOBALS['TSFE']->sys_language_isocode . '" />');
            $this->response->addAdditionalHeaderData('<meta name="t3chimp:csrf-token" content="' . $this->initializeCsrfToken() . '" />');
        }

        /**
         * @return string
         */
        private function initializeCsrfToken() {
            if($_SESSION['t3chimp:csrfToken'] === null) {
                $_SESSION['t3chimp:csrfToken'] = md5(rand() . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
            }

            return $_SESSION['t3chimp:csrfToken'];
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