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

use MatoIlic\T3Chimp\MailChimp\MailChimpApi;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;

class FlexFormValues {
    /**
     * @var MailChimpApi
     */
    private $api;

    protected function initialize($extKey) {
        $setup = $this->getTypoScriptSetup();

        $setup = $setup['plugin.']['tx_' . $extKey . '.'];
        $tsConfig = BackendUtility::getPagesTSconfig($this->getCurrentPageId());
        $tsConfig = $tsConfig['plugin.']['tx_' . $extKey . '.'];

        if($setup['settings.']['apiKey'] && $setup['settings.']['apiKey'][0] != '{') {
            $apiKey = $setup['settings.']['apiKey'];
        } else if($tsConfig['settings.']['apiKey'] && $tsConfig['settings.']['apiKey'][0] != '{') {
            $apiKey = $tsConfig['settings.']['apiKey'];
        } else {
            $globals = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);
            $apiKey = $globals['apiKey'];
        }

        $this->api = new MailChimpApi($apiKey);
    }

    /**
     * Gets the TypoScript setup of the current page.
     * This code is taken from the extbase core and slightly modified (TYPO3 6.1.10).
     *
     * @see http://api.typo3.org/typo3cms/61/html/class_t_y_p_o3_1_1_c_m_s_1_1_extbase_1_1_configuration_1_1_abstract_configuration_manager.html#a53db9b74f2a65ef2ddbddbc782937fca
     * @return array
     */
    protected function getTypoScriptSetup() {
		$pageId = $this->getCurrentPageId();

		$template = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\TemplateService');
		// do not log time-performance information
		$template->tt_track = 0;
		// Explicitly trigger processing of extension static files
		$template->setProcessExtensionStatics(TRUE);
		$template->init();
		// Get the root line
		$rootLine = array();
		if ($pageId > 0) {
			$sysPage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
			// Get the rootline for the current page
			$rootLine = $sysPage->getRootLine($pageId, '', TRUE);
		}
		// This generates the constants/config + hierarchy info for the template.
		$template->runThroughTemplates($rootLine, 0);
		$template->generateConfig();

		return $template->setup;
    }

    protected function getCurrentPageId() {
        $pageId = (integer)GeneralUtility::_GP('id');
        if ($pageId > 0) {
            return $pageId;
        }

        // Get current page id when editing a content element in the backend.
        // &edit[tt_content][1486,]=edit
        $edit = GeneralUtility::_GP('edit');
        if (is_array($edit) && isset($edit['tt_content'])){
        	$contentElementUids = array_shift(array_keys($edit['tt_content']));
			if ($edit['tt_content'][$contentElementUids] === 'new'){
				return $contentElementUids;
			}
	        $contentElementUidsList = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $contentElementUids, TRUE);
	        $pageRecords = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('pid', 'tt_content', 'uid IN(' . implode(',', $contentElementUidsList) . ')', '', '', '1');
	        if (count($pageRecords)){
		        return $pageRecords[0]['pid'];
	        }
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

        return 0;
    }

    /**
     * @param array $config
     * @return array
     */
    public function getLists($config) {
        $listType = explode('_', $config['row']['list_type']);
        $this->initialize($listType[0]);
        $result = $this->api->lists->getList();

        foreach($result['data'] as $list) {
            $config['items'][] = array($list['name'], $list['id']);
        }

        return $config;
    }
}
