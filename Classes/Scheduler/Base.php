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

namespace MatoIlic\T3Chimp\Scheduler;

use MatoIlic\T3Chimp\Domain\Repository\FrontendUserRepository;
use MatoIlic\T3Chimp\Service\MailChimp;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Reflection\ReflectionService;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

abstract class Base extends AbstractTask {
    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @var array
     */
    protected $extConf;

    /**
     * @var MailChimp
     */
    protected $mailChimp;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var FrontendUserRepository
     */
    protected $userRepo;

    /**
     * @return bool
     */
    protected function debuggingEnabled() {
        return $this->extConf['debug'];
    }

    /**
     * This is the main method that is called when a task is executed
     * Note that there is no error handling, errors and failures are expected
     * to be handled and logged by the client implementations.
     * Should return TRUE on successful execution, FALSE on error.
     *
     * @return boolean Returns TRUE on successful execution, FALSE on error
     */
    public function execute() {
        $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3chimp']);

        /** @var ObjectManager $objectManager */
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $this->mailChimp = $this->objectManager->get('MatoIlic\\T3Chimp\\Service\\MailChimp');
        $this->userRepo = $this->objectManager->get('MatoIlic\\T3Chimp\\Domain\\Repository\\FrontendUserRepository');

        $this->configurationManager->setConfiguration(array('extensionName' => 'T3chimp'));
        $typoScriptSetup = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        if (isset($typoScriptSetup['config.']['tx_extbase.']['objects.'])) {
            $objectContainer = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\Container\\Container');
            foreach ($typoScriptSetup['config.']['tx_extbase.']['objects.'] as $classNameWithDot => $classConfiguration) {
                if (isset($classConfiguration['className'])) {
                    $originalClassName = rtrim($classNameWithDot, '.');
                    $objectContainer->registerImplementation($originalClassName, $classConfiguration['className']);
                }
            }
        }

        /** @var ReflectionService $reflectionService */
        $reflectionService = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Reflection\\ReflectionService');

        if(TYPO3_version < '7.1.0') {
            $reflectionService->setDataCache($GLOBALS['typo3CacheManager']->getCache('extbase_reflection'));
        } else {
            $cacheManager = $this->objectManager->get('TYPO3\\CMS\\Core\\Cache\\CacheManager');
            $reflectionService->setDataCache($cacheManager->getCache('extbase_reflection'));
        }

        if (!$reflectionService->isInitialized()) {
            $reflectionService->initialize();
        }

        $this->mailChimp->initialize();

        $state = $this->executeTask();

        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $reflectionService->shutdown();

        return $state;
    }

    /**
     * @return boolean Returns TRUE on successful execution, FALSE on error
     */
    public abstract function executeTask();

    /**
     * @param string $listId
     * @return array
     */
    protected function retrieveSubscribers($listId) {
        $subscribers = array();
        foreach($this->mailChimp->getSubscribersFor($listId) as $subscriber) {
            $subscribers[$subscriber['email']] = $subscriber;
        }

        return $subscribers;
    }

    /**
     * @param $key the key for the label
     * @param NULL|array $arguments
     * @param string $default
     * @return string
     */
    protected function translate($key, $arguments = NULL, $default = 'MISSING TRANSLATION') {
        $value = LocalizationUtility::translate($key, 'T3chimp', $arguments);

        return ($value != NULL) ? $value : $default;
    }
}
