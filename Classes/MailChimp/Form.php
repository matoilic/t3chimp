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

class Tx_T3chimp_MailChimp_Form {
    /**
     * @var string
     */
    protected static $fieldNamespace = 'Tx_T3chimp_MailChimp_Field_';

    /**
     * @var array
     */
    protected $fieldDefinitions;

    /**
     * @var array
     */
    protected $hiddenFields = array();

    /**
     * @var array
     */
    protected $interestGroupings = array();

    /**
     * @var bool
     */
    protected $isBound = FALSE;

    /**
     * @var string
     */
    protected $listId;

    /**
     * @var Tx_Extbase_Object_ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $publicFields = array();

    /**
     * @var array
     */
    protected static $supportedTypes = array(
        'email',
        'dropdown',
        'radio',
        'text',
        'number',
        'zip',
        'phone',
        'url',
        'date',
        'imageurl',
        'address',
        'birthday'
    );

    /**
     * @param array $fieldDefinitions
     * @param string $listId
     */
    public function __construct(array $fieldDefinitions, $listId) {
        $this->fieldDefinitions = $fieldDefinitions;
        $this->listId = $listId;
    }

    public function bindRequest(Tx_Extbase_MVC_RequestInterface $request) {
        foreach($this->getFields() as $field) {
            $field->bindRequest($request);
        }

        $this->isBound = TRUE;
    }

    /**
     * @param bool $includeHidden whether or not to return hidden fields too
     * @return array
     */
    public function getFields($includeHidden = FALSE) {
        if(!$includeHidden) {
            return $this->publicFields;
        }

        return array_merge($this->publicFields, $this->hiddenFields);
    }

    /**
     * @param string $name
     * @return Tx_T3chimp_MailChimp_Field|NULL
     */
    public function getField($name) {
        foreach($this->getFields(TRUE) as $field) {
            if($field->getName() == $name) {
                return $field;
            }
        }

        return NULL;
    }

    /**
     * @return string
     */
    public function getListId() {
        return $this->listId;
    }

    protected function initializeActionField() {
        $class = self::$fieldNamespace . 'Action';
        $this->publicFields[] = new $class(array(), $this);
    }

    /**
     * @param array $fieldDefinition
     */
    protected function initializeField(array $fieldDefinition) {
        $type = $fieldDefinition['field_type'];
        if(in_array($type, self::$supportedTypes)) {
            $class = self::$fieldNamespace . ucfirst($type);
            if(TYPO3_version < '6.1.0') {
                $field = $this->objectManager->create($class, $fieldDefinition, $this);
            } else {
                $field = $this->objectManager->get($class, $fieldDefinition, $this);
            }

            if($fieldDefinition['public']) {
                $this->publicFields[] = $field;
            } else {
                $this->hiddenFields[] = $field;
            }
        } else {
            trigger_error('Tx_T3chimp_MailChimp_Form: unsupported type ' . $type, E_WARNING);
        }
    }

    /**
     * @param array $fieldDefinitions
     */
    protected function initializeFields(array $fieldDefinitions) {
        $this->initializeActionField();

        foreach($fieldDefinitions as $fieldDefinition) {
            $this->initializeField($fieldDefinition);
        }
    }

    /**
     * @param Tx_Extbase_Object_ObjectManager $objectManager
     */
    public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
        $this->initializeFields($this->fieldDefinitions);
    }

    /**
     * @return bool
     */
    public function getIsBound() {
        return $this->isBound;
    }

    /**
     * @return bool
     * @throws Tx_T3chimp_MailChimp_Exception
     */
    public function isValid() {
        if(!$this->isBound) {
            throw new Tx_T3chimp_MailChimp_Exception('Can not validate an unbound form');
        }

        foreach($this->getFields(TRUE) as $field) {
            if(!$field->getIsValid()) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * @param array $groupings
     */
    public function setInterestGroupings(array $groupings) {
        foreach($groupings as $grouping) {
            $definition = array(
                'choices' => $grouping['groups'],
                'tag' => $grouping['name'],
                'name' => $grouping['name'],
                'groupingId' => $grouping['id'],
                'form_field' => $grouping['form_field']
            );
            $this->publicFields[] = new Tx_T3chimp_MailChimp_Field_InterestGrouping($definition, $this);
        }
    }
}
