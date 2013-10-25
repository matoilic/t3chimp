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

class Tx_T3chimp_Scheduler_SyncBackFromMailChimpFieldProvider implements tx_scheduler_AdditionalFieldProvider {
    /**
     * @var Tx_T3chimp_Service_MailChimp
     */
    private $mailChimp;

    public function __construct() {
        /** @var Tx_Extbase_Object_ObjectManager $objectManager */
        $objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
        $this->mailChimp = $objectManager->get('Tx_T3chimp_Service_MailChimp');
        $this->mailChimp->initialize();
    }

    /**
     * Gets additional fields to render in the form to add/edit a task
     *
     * @param array $taskInfo Values of the fields from the add/edit task form
     * @param Tx_T3chimp_Scheduler_SyncBackFromMailChimpTask $task The task object being eddited. Null when adding a task!
     * @param tx_scheduler_Module $schedulerModule Reference to the scheduler backend module
     * @return array A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' => '', 'cshKey' => '', 'cshLabel' => ''))
     */
    public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $schedulerModule) {
        $codeListId = '<select name="tx_scheduler[listId]">';

        foreach($this->mailChimp->getLists() as $list) {
            $selected = ($task != null && $list['id'] == $task->getListId()) ? ' selected="selected"' : '';
            $codeListId .= '<option value="' . $list['id'] . '"' . $selected . '>' . htmlentities($list['name']) . '</option>';
        }

        $codeListId .= '</select>';

        $codeMailField = '<select name="tx_scheduler[emailField]">';

        foreach($GLOBALS['TCA']['fe_users']['columns'] as $column => $config) {
            $label = $GLOBALS['LANG']->sL($config['label']);
            if(strlen($label) == 0) {
                $label = $column;
            } else {
                $label = substr($label, 0, strlen($label) - 1);
            }

            $selected = ($task != null && $column == $task->getEmailField()) ? ' selected="selected"' : '';
            $codeMailField .= '<option value="' . $column . '"' . $selected . '>' . $label . ' (' . $column . ')</option>';
        }

        $codeMailField .= '</select>';

        return array(
            'listId' => array(
                'code' => $codeListId,
                'label' => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncBackFromMailChimpTask.label.listId'
            ),

            'emailField' => array(
                'code' => $codeMailField,
                'label' => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncBackFromMailChimpTask.label.emailField'
            )
        );
    }

    /**
     * Takes care of saving the additional fields' values in the task's object
     *
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param tx_scheduler_Task $task Reference to the scheduler backend module
     * @return void
     */
    public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {
        /** @var Tx_T3chimp_Scheduler_SyncBackFromMailChimpTask $task */
        $task->setListId($submittedData['listId']);
        $task->setEmailField($submittedData['emailField']);
    }

    /**
     * Validates the additional fields' values
     *
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param tx_scheduler_Module $schedulerModule Reference to the scheduler backend module
     * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $schedulerModule) {
        return true;
    }
}
