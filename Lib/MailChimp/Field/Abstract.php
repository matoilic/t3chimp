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

abstract class MailChimp_Field_Abstract implements MailChimp_Field {
    /**
     * @var array
     */
    protected $definition;

    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var MailChimp_Form
     */
    protected $form;

    /**
     * @var bool
     */
    protected $isValidated = false;

    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * @param array $definition
     * @param MailChimp_Form $form
     */
    public function __construct(array $definition, MailChimp_Form $form) {
        $this->definition = $definition;
        $this->form = $form;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue() {
        return $this->definition['default'];
    }

    /**
     * @return array
     */
    public function getErrors() {
        if(!$this->form->getIsBound()) {
            return array();
        }

        if(!$this->isValidated) {
            $this->validate();
        }

        return $this->errors;
    }

    /**
     * @return string
     */
    public function getId() {
        return 'tx_t3chimp_' . strtolower($this->getTag());
    }

    /**
     * @return bool
     */
    public function getIsEmpty() {
        $value = $this->getValue();
        return empty($value);
    }

    /**
     * @return boolean
     */
    public function getIsRequired() {
        return $this->definition['req'];
    }

    /**
     * @return bool
     */
    public function getIsValid() {
        return count($this->getErrors()) == 0;
    }

    /**
     * @return string
     */
    public function getLabel() {
        return $this->definition['name'];
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->getTag();
    }

    /**
     * @return string
     */
    public function getTag() {
        return $this->definition['tag'];
    }

    /**
     * @return string
     */
    public function getTemplate() {
        $tmp = explode('_', get_class($this));
        $fieldName = $tmp[count($tmp) - 1];

        return $fieldName . 'Field';
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return (!empty($this->value)) ? $this->value : $this->getDefaultValue();
    }

    protected function resetValidation() {
        $this->errors = array();
        $this->isValidated = false;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = trim($value);
        $this->resetValidation();
    }

    /**
     * @return void
     */
    protected function validate() {
        $this->isValidated = true;
        $value = $this->getValue();
        if($this->getIsRequired() && empty($value)) {
            $this->errors[] = 't3chimp.error.required';
        }
    }
}
