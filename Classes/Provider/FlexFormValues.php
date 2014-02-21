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

use MatoIlic\T3Chimp\MailChimp\Api;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;

class FlexFormValues {
    /**
     * @var Api
     */
    private $api;

    protected function initialize($extKey) {
        /** @var BackendConfigurationManager $config */
        $config = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\BackendConfigurationManager');
        $setup = $config->getTypoScriptSetup();
        $setup = $setup['plugin.']['tx_' . $extKey . '.'];
        $tsConfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->getCurrentPageId());
        $tsConfig = $tsConfig['plugin.']['tx_' . $extKey . '.'];

        if(TYPO3_version >= '6.0.0' && $setup['settings.']['apiKey'] && $setup['settings.']['apiKey'][0] != '{') {
            $apiKey = $setup['settings.']['apiKey'];
        } else if($tsConfig['settings.']['apiKey'] && $tsConfig['settings.']['apiKey'][0] != '{') {
            $apiKey = $tsConfig['settings.']['apiKey'];
        } else {
            $globals = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);
            $apiKey = $globals['apiKey'];
        }

        $this->api = new Api($apiKey);
    }

    protected function getCurrentPageId() {
        $pageId = (integer)GeneralUtility::_GP('id');
        if ($pageId > 0) {
            return $pageId;
        }

        // get current site root
        $rootPages = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid', 'pages', 'deleted=0 AND hidden=0 AND is_siteroot=1', '', '', '1');
        if (count($rootPages) > 0) {
            return $rootPages[0]['uid'];
        }

        // get root template
        $rootTemplates = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('pid', 'sys_template', 'deleted=0 AND hidden=0 AND root=1', '', '', '1');
        if (count($rootTemplates) > 0) {
            return $rootTemplates[0]['pid'];
        }

        // fallback
        return 0;
    }

    /**
     * @param array $config
     * @return array
     */
    public function getLists($config) {
        $listType = explode('_', $config['row']['list_type']);
        $this->initialize($listType[0]);
        $result = $this->api->lists();

        foreach($result['data'] as $list) {
            $config['items'][] = array($list['name'], $list['id']);
        }

        return $config;
    }
}
