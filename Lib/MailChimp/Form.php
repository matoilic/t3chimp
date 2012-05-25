<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Mato Ilic <info@matoilic.ch>
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

class MailChimp_Form {
    /**
     * @var string
     */
    protected static $fieldNamespace = 'MailChimp_Field_';

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @var array
     */
    protected $interestGroupings = array();

    /**
     * @var bool
     */
    protected $isBound = false;

    /**
     * @var string
     */
    private $listId;

    /**
     * @var array
     */
    protected static $supportedTypes = array(
        'email',
        'dropdown',
        'radio',
        'text',
        'number'
    );

    /**
     * @param array $fieldDefinitions
     * @param string $listId
     */
    public function __construct(array $fieldDefinitions, $listId) {
        $this->listId = $listId;
        $this->initializeFields($fieldDefinitions);
    }

    public function bindRequest(Tx_Extbase_MVC_Request $request) {
        foreach($this->getFields() as $field) {
            if($request->hasArgument($field->getName())) {
                $field->setValue($request->getArgument($field->getName()));
            }
        }

        $this->isBound = true;
    }

    /**
     * @return array
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * @param string $name
     * @return MailChimp_Field|null
     */
    public function getField($name) {
        foreach($this->getFields() as $field) {
            if($field->getName() == $name) {
                return $field;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getListId() {
        return $this->listId;
    }

    /**
     * @param array $fieldDefinitions
     */
    protected function initializeFields(array $fieldDefinitions) {
        $class = self::$fieldNamespace . 'Action';
        $this->fields[] = new $class(array(), $this);

        foreach($fieldDefinitions as $fieldDefinition) {
            $type = $fieldDefinition['field_type'];
            if(in_array($type, self::$supportedTypes)) {
                $class = self::$fieldNamespace . ucfirst($type);
                $this->fields[] = new $class($fieldDefinition, $this);
            } else {
                trigger_error('MailChimp_Form: unsupported type ' . $type, E_WARNING);
            }
        }
    }

    /**
     * @return bool
     */
    public function getIsBound() {
        return $this->isBound;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isValid() {
        if(!$this->isBound) {
            throw new Exception('Can not validate a unbound form');
        }

        foreach($this->getFields() as $field) {
            if(!$field->getIsValid()) {
                return false;
            }
        }

        return true;
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
                'groupingId' => $grouping['id']
            );
            $this->fields[] = new MailChimp_Field_InterestGrouping($definition, $this);
        }
    }
}
