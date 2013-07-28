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

class Tx_T3chimp_Scheduler_SyncToMailChimpFieldProvider implements tx_scheduler_AdditionalFieldProvider {
    /**
     * @var string
     */
    private $fieldOptions;

    /**
     * @var Tx_T3chimp_Service_MailChimp
     */
    private $mailChimp;

    public function __construct() {
        /** @var Tx_Extbase_Object_ObjectManager $objectManager */
        $objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
        $this->mailChimp = $objectManager->get('Tx_T3chimp_Service_MailChimp');
    }

    private function createAddressField($fieldDefinition, $values) {
        $tag = $fieldDefinition['tag'];

        $code = '<strong>' . $fieldDefinition['name'] . '</strong><br />';

        $name = $tag . '.addr1';
        $code .= $GLOBALS['LANG']->sL('LLL:EXT:t3chimp/Resources/Private/Language/locallang.xml:t3chimp.address.line1') . '<br>';
        $code .= $this->createFieldSelection($name, $values[$name]) . '<br>';

        $name = $tag . '.addr2';
        $code .= $GLOBALS['LANG']->sL('LLL:EXT:t3chimp/Resources/Private/Language/locallang.xml:t3chimp.address.line2') . '<br>';
        $code .= $this->createFieldSelection($name, $values[$name]) . '<br>';

        $name = $tag . '.city';
        $code .= $GLOBALS['LANG']->sL('LLL:EXT:t3chimp/Resources/Private/Language/locallang.xml:t3chimp.address.city') . '<br>';
        $code .= $this->createFieldSelection($name, $values[$name]) . '<br>';

        $name = $tag . '.state';
        $code .= $GLOBALS['LANG']->sL('LLL:EXT:t3chimp/Resources/Private/Language/locallang.xml:t3chimp.address.state') . '<br>';
        $code .= $this->createFieldSelection($name, $values[$name]) . '<br>';

        $name = $tag . '.zip';
        $code .= $GLOBALS['LANG']->sL('LLL:EXT:t3chimp/Resources/Private/Language/locallang.xml:t3chimp.address.zipCode') . '<br>';
        $code .= $this->createFieldSelection($name, $values[$name]) . '<br>';

        $name = $tag . '.country';
        $code .= $GLOBALS['LANG']->sL('LLL:EXT:t3chimp/Resources/Private/Language/locallang.xml:t3chimp.address.country') . '<br>';
        $code .= $this->createFieldSelection($name, $values[$name]) . '<br>';

        return $code;
    }

    /**
     * @return string
     */
    private function createFieldOptions() {
        if($this->fieldOptions == null) {
            $this->fieldOptions = '<option value=""></option>';
            foreach($GLOBALS['TCA']['fe_users']['columns'] as $column => $config) {
                $label = $GLOBALS['LANG']->sL($config['label']);
                if(strlen($label) == 0) {
                    $label = $column;
                } else {
                    $label = substr($label, 0, strlen($label) - 1);
                }

                $this->fieldOptions .= '<option value="' . $column . '">' . $label . ' (' . $column . ')</option>';
            }
        }

        return $this->fieldOptions;
    }

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    private function createFieldSelection($name, $value) {
        $code = '<select name="tx_scheduler[mappings][' . $name . ']">';

        if(strlen($value) > 0) {
            $value = 'value="' . $value . '"';
            $code .= str_replace(
                $value,
                $value . ' selected="selected"',
                $this->createFieldOptions()
            );
        } else {
            $code .= $this->createFieldOptions();
        }

        return $code . '</select>';
    }

    private function createGroupingField($grouping, $value) {
        $code = '<strong>' . $grouping['name'] . '</strong><br />';
        $code .= $this->createFieldSelection(
            $grouping['name'],
            $value
        );

        return $code;
    }

    /**
     * @param string $value
     * @return string
     */
    private function createListSelection($value) {
        $code = '<select name="tx_scheduler[listId]" id="listId">';
        $code .= '<option value=""></option>';

        foreach($this->mailChimp->getLists() as $list) {
            $selected = ($list['id'] == $value) ? ' selected="selected"' : '';
            $code .= '<option value="' . $list['id'] . '"' . $selected . '>' . htmlentities($list['name']) . '</option>';
        }

        $code .= '</select>';
        $code .= "<script type='text/javascript'>
            $('listId').observe('change', function() {
                alert('You need to save and reopen the task to continue with the configuration');
            });
        </script>";

        return $code;
    }

    /**
     * @param array $fieldDefinition
     * @param string $value
     * @return string
     */
    private function createSimpleField($fieldDefinition, $value) {
        $code = '<strong>' . $fieldDefinition['name'] . '</strong><br />';
        $code .= $this->createFieldSelection(
            $fieldDefinition['tag'],
            $value
        );

        return $code;
    }

    /**
     * Gets additional fields to render in the form to add/edit a task
     *
     * @param array $taskInfo Values of the fields from the add/edit task form
     * @param Tx_T3chimp_Scheduler_SyncToMailChimpTask $task The task object being edited. Null when adding a task!
     * @param tx_scheduler_Module $schedulerModule Reference to the scheduler backend module
     * @return array A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' => '', 'cshKey' => '', 'cshLabel' => ''))
     */
    public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $schedulerModule) {
        $fields = array();
        $listId = ($task != null) ? $task->getListId() : null;

        $fields['listId'] = array(
            'code' => $this->createListSelection($listId),
            'label' => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncToMailChimpTask.label.listId'
        );


        if($task != null && strlen($task->getListId()) > 0) {
            $code = '';

            $fieldDefinitions = $this->mailChimp->getFieldsFor($task->getListId());
            $existingMappings = $task->getMappings();

            foreach($fieldDefinitions as $fieldDefinition) {
                if($fieldDefinition['field_type'] != 'address') {
                    $code .= $this->createSimpleField($fieldDefinition, $existingMappings[$fieldDefinition['tag']]);
                } else {
                    $code .= $this->createAddressField($fieldDefinition, $existingMappings);
                }

                $code .= '<br />';
            }

            $groupings = $this->mailChimp->getInterestGroupingsFor($task->getListId());
            foreach($groupings as $grouping) {
                $code .= $this->createGroupingField($grouping, $existingMappings[$grouping['name']]);
                $code .= '<br />';
            }

            $fields['mappings'] = array(
                'code' => $code,
                'label' => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncToMailChimpTask.label.mappings'
            );
        }

        return $fields;
    }

    /**
     * Takes care of saving the additional fields' values in the task's object
     *
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param tx_scheduler_Task $task Reference to the scheduler backend module
     * @return void
     */
    public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {
        /** @var Tx_T3chimp_Scheduler_SyncToMailChimpTask $task */
        $task->setListId($submittedData['listId']);
        t3lib_div::devLog('T3Chimp List ID ' . $submittedData['listId'], 't3chimp');

        if(array_key_exists('mappings', $submittedData)) {
            $task->setMappings($submittedData['mappings']);
            t3lib_div::devLog('T3Chimp List ID ' . print_r($submittedData['mappings'], true), 't3chimp');
        }
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
