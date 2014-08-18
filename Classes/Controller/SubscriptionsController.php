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

namespace MatoIlic\T3Chimp\Controller;

use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Error;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\InvalidEmail;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\ListNotSubscribed;
use MatoIlic\T3Chimp\Provider\Settings;
use MatoIlic\T3Chimp\Service\MailChimp;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class SubscriptionsController extends ActionController {
    /**
     * @var MailChimp
     */
    private $mailChimpService;

    /**
     * @return void
     */
    public function indexAction() {
        if($this->settings['debug']) {
            echo '<!--';
            var_dump($this->mailChimpService->getFieldsFor($this->settings['subscriptionList']));
            echo "\n------------------------\n";
            var_dump($this->mailChimpService->getInterestGroupingsFor($this->settings['subscriptionList']));
            echo '-->';
        }

        $contentData = $this->configurationManager->getContentObject()->data;
        $this->view->assign('contentId', $contentData['uid']);
        $this->view->assign('contentData', $contentData);
        $this->view->assign('language', $GLOBALS['TSFE']->sys_language_uid);
        $this->view->assign('languageIso', strtolower($GLOBALS['TSFE']->sys_language_isocode));
        $this->view->assign('pageId', $GLOBALS['TSFE']->id);
        $this->view->assign('form', $this->mailChimpService->getForm());
        $this->view->assign('pageType', $this->getPageType());
    }

    protected function initializeAction() {
        $this->mailChimpService->initialize();
        parent::initializeAction();
    }


    public function editAction() {
        if($this->settings['debug']) {
            echo '<!--';
            var_dump($this->mailChimpService->getSubscriptionInfo($this->request->getArgument('email')));
            echo '-->';
        }

        $form = $this->mailChimpService->getForm($this->request->getArgument('email'));

        $this->view->assign('language', $GLOBALS['TSFE']->sys_language_uid);
        $this->view->assign('languageIso', strtolower($GLOBALS['TSFE']->sys_language_isocode));
        $this->view->assign('pageId', $GLOBALS['TSFE']->id);
        $this->view->assign('form', $form);
        $this->view->assign('pageType', $this->getPageType());
    }

    protected function getPageType() {
        return '1296728024';
    }

    /**
     * @param ConfigurationManager $configurationManager
     */
    public function injectConfigurationManager(ConfigurationManager $configurationManager) {
        $this->configurationManager = $configurationManager;
    }


    /**
     * @param MailChimp $service
     */
    public function injectMailChimpService(MailChimp $service) {
        $this->mailChimpService = $service;
    }

    /**
     * @param Settings $provider
     */
    public function injectSettingsProvider(Settings $provider) {
        $provider->initialize($this->extensionName);
        $this->settings = $provider->getAll();
    }

    /*
     * @return void
     */
    public function processAction() {
        $form = $this->mailChimpService->getFormFor(
            $this->request->getArgument('list'),
            $this->request->hasArgument('email_type')
        );
        $form->bindRequest($this->request);

        if($form->isValid()) {
            $success = FALSE;

            try {
                $performedAction = $this->mailChimpService->saveForm($form);

                if($performedAction == MailChimp::ACTION_SUBSCRIBE) {
                    if($this->settings['doubleOptIn']) {
                        $message = $this->translate('form_almostSubscribed');
                    } else {
                        $message = $this->translate('form_subscribed');
                    }
                } else if($performedAction == MailChimp::ACTION_UPDATE) {
                    $message = $this->translate('form_updated');
                } else {
                    $message = $this->translate('form_unsubscribed');
                }

                $success = TRUE;
            } catch(InvalidEmail $ex) {
                $message = $this->translate('exception_invalidEmail');
            } catch(ListNotSubscribed $ex) {
                $message = $this->translate('exception_notSubscribed');
            } catch(Error $ex) {
                $message = $ex->getMessage();
            }

            return json_encode(array('html' => $message, 'success' => $success), JSON_HEX_TAG | JSON_HEX_QUOT);
        }

        $this->view->assign('form', $form);

        return json_encode(array('html' => $this->view->render(), 'success' => FALSE), JSON_HEX_TAG | JSON_HEX_QUOT);
    }

    /**
     * @param $key the key for the label
     * @param NULL|array $arguments
     * @param string $default
     * @return string
     */
    protected function translate($key, $arguments = NULL, $default = 'MISSING TRANSLATION') {
        $extensionName = $this->request->getControllerExtensionName();

        $value = LocalizationUtility::translate($key, $extensionName, $arguments);
        if($value != NULL) {
            return $value;
        }

        $value = LocalizationUtility::translate($key, 't3chimp', $arguments);

        return ($value != NULL) ? $value : $default;
    }
}
