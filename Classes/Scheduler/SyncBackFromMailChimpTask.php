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

class Tx_T3chimp_Scheduler_SyncBackFromMailChimpTask extends Tx_T3chimp_Scheduler_Base {
    /**
     * @var string
     */
    private $emailField;

    /**
     * @var string
     */
    private $listId;

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
        parent::execute();

        try {
            $subscribers = $this->retrieveSubscribers($this->listId);

            foreach($subscribers as $subscriber) {
                $this->userRepo->updateNewsletterFlag($this->emailField, $subscriber['email'], 1);
            }
        } catch (Exception $e) {
            t3lib_div::sysLog($e->getMessage(), 't3chimp', 3);
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getEmailField() {
        return $this->emailField;
    }

    /**
     * @return string
     */
    public function getListId() {
        return $this->listId;
    }

    /**
     * @param string $emailField
     */
    public function setEmailField($emailField) {
        $this->emailField = $emailField;
    }

    /**
     * @param string $listId
     */
    public function setListId($listId) {
        $this->listId = $listId;
    }
}
