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

namespace MatoIlic\T3Chimp\MailChimp\Field;

use MatoIlic\T3Chimp\MailChimp\Field;
use MatoIlic\T3Chimp\MailChimp\Form;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;

/**
 * @api
 * @package MatoIlic\T3Chimp\MailChimp\Field
 */
abstract class AbstractField implements Field {
    /**
     * @var array
     */
    protected $definition;

    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var bool
     */
    protected $isValidated = FALSE;

    /**
     * @var mixed
     */
    protected $value = NULL;

    /**
     * @param array $definition
     * @param Form $form
     */
    public function __construct(array $definition, Form $form) {
        $this->definition = $definition;
        $this->form = $form;
    }

    public function addError($message) {
        $this->errors[] = $message;
    }

    public function bindRequest(RequestInterface $request) {
        if($request->hasArgument($this->getName())) {
            $this->setValue($request->getArgument($this->getName()));
        }
    }

    public function setApiValue($value) {
        $this->setValue($value);
    }

    /**
     * @return mixed
     */
    public function getApiValue() {
        return $this->getValue();
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
    public function getIsActionField() {
        return FALSE;
    }

    /**
     * @return bool
     */
    public function getIsEmailFormatField() {
        return FALSE;
    }

    /**
     * @return bool
     */
    public function getIsEmpty() {
        $value = $this->getValue();
        return empty($value);
    }

    /**
     * @return bool
     */
    public function getIsHidden() {
        return !$this->definition['public'];
    }

    /**
     * @return bool
     */
    public function getIsInterestGroup() {
        return FALSE;
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
        if(!$this->isValidated) {
            $this->validate();
        }

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
        $tmp = explode('\\', get_class($this));
        $fieldName = $tmp[count($tmp) - 1];

        return $fieldName . 'Field';
    }

    /**
     * @return string
     */
    public function getTranslationKey() {
        return strtolower($this->getTag());
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return (!empty($this->value)) ? $this->value : $this->getDefaultValue();
    }

    protected function resetValidation() {
        $this->errors = array();
        $this->isValidated = FALSE;
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
        $this->isValidated = TRUE;
        $value = $this->getValue();
        if($this->getIsRequired() && empty($value)) {
            $this->errors[] = 'error_required';
        }
    }
}
