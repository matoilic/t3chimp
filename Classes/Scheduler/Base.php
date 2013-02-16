<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Mato Ilic <info@matoilic.ch>
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

abstract class Tx_T3chimp_Scheduler_Base extends Tx_Scheduler_Task {
    /**
     * @var array
     */
    protected $extConf;

    /**
     * @var Tx_T3chimp_Service_MailChimp
     */
    protected $mailChimp;

    /**
     * @var Tx_Extbase_Object_ObjectManager
     */
    protected $objectManager;

    /**
     * @var Tx_T3chimp_Domain_Repository_FrontendUserRepository
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
     * It MUST be implemented by all classes inheriting from this one
     * Note that there is no error handling, errors and failures are expected
     * to be handled and logged by the client implementations.
     * Should return TRUE on successful execution, FALSE on error.
     *
     * @return boolean Returns TRUE on successful execution, FALSE on error
     */
    public function execute() {
        $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3chimp']);

        /** @var Tx_Extbase_Object_ObjectManager $objectManager */
        $this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
        $this->mailChimp = $this->objectManager->get('Tx_T3chimp_Service_MailChimp');
        $this->userRepo = $this->objectManager->get('Tx_T3chimp_Domain_Repository_FrontendUserRepository');
    }

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
     * @param null|array $arguments
     * @param string $default
     * @return string
     */
    protected function translate($key, $arguments = null, $default = 'MISSING TRANSLATION') {
        $value = Tx_Extbase_Utility_Localization::translate($key, 'T3chimp', $arguments);

        return ($value != NULL) ? $value : $default;
    }
}
