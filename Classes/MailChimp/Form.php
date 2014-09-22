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

namespace MatoIlic\T3Chimp\MailChimp;

use MatoIlic\T3Chimp\MailChimp\Field;
use MatoIlic\T3Chimp\Provider\Session;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * @api
 * @package MatoIlic\T3Chimp\MailChimp
 */
class Form {
    const MIN_SUBMISSION_TIME = 4000;

    protected $controlFields = array(
        'cc' => '',
        'ccts' => '',
        'cchp' => ''
    );

    /**
     * @var bool
     */
    protected $disableCaptcha = false;

    /**
     * @var string
     */
    protected static $fieldNamespace = '\\MatoIlic\\T3Chimp\\MailChimp\\Field\\';

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
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $publicFields = array();

    /**
     * @var Session
     */
    private $session;

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

    /**
     * Adds the given Field to the form.
     *
     * @param Field $field
     */
    public function addField(Field $field) {
        if($field->getIsHidden()) {
            $this->hiddenFields[] = $field;
        } else {
            $this->publicFields[] = $field;
        }
    }

    /**
     * Reads the submitted values from the request and assigns them
     * to the appropriate fields.
     *
     * @param RequestInterface $request
     */
    public function bindRequest(RequestInterface $request) {
        foreach($this->controlFields as $key => $value) {
            $this->controlFields[$key] = $request->getArgument($key);
        }

        foreach($this->getFields() as $field) {
            $field->bindRequest($request);
        }

        $this->isBound = TRUE;
    }

    /**
     * @return string
     */
    public function getCaptchaCode() {
        return $this->session->cc;
    }

    public function getDisableCaptcha() {
        return $this->disableCaptcha;
    }

    /**
     * Returns the forms fields. By default hidden field are not returned, only
     * when $includeHidden is set to true.
     *
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
     * Returns the field with the given name. Returns NULL if no field with
     * the given name could be found.
     *
     * @param string $name
     * @return Field|NULL
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
     * Returns the ID of the subscriber list the form represents.
     *
     * @return string
     */
    public function getListId() {
        return $this->listId;
    }

    protected function initializeActionField() {
        $class = self::$fieldNamespace . 'Action';
        $this->publicFields[] = new $class(array(), $this);
    }

    private function initializeCaptcha() {
        if(!isset($this->session->cc)) {
            $this->session->cc = md5(rand());
        }
    }

    /**
     * @param array $fieldDefinition
     */
    protected function initializeField(array $fieldDefinition) {
        $type = $fieldDefinition['field_type'];
        if(in_array($type, self::$supportedTypes)) {
            $class = self::$fieldNamespace . ucfirst($type);
            $field = $this->objectManager->get($class, $fieldDefinition, $this);

            if($fieldDefinition['public']) {
                $this->publicFields[] = $field;
            } else {
                $this->hiddenFields[] = $field;
            }
        } else {
            trigger_error('MatoIlic\\T3Chimp\\MailChimp\\Form: unsupported type ' . $type, E_WARNING);
        }
    }

    /**
     * @param array $fieldDefinitions
     */
    protected function initializeFields(array $fieldDefinitions) {
        $this->initializeActionField();
        $this->initializeCaptcha();

        foreach($fieldDefinitions as $fieldDefinition) {
            $this->initializeField($fieldDefinition);
        }
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function injectObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
        $this->session = $objectManager->get('MatoIlic\\T3Chimp\\Provider\\Session');
        $this->initializeFields($this->fieldDefinitions);
    }

    /**
     * Returns TRUE if the for was bound to a request, FALSE otherwise.
     *
     * @return bool
     */
    public function getIsBound() {
        return $this->isBound;
    }

    /**
     * Returns TRUE if all fields of the form are valid, FALSE otherwise.
     *
     * @return bool
     * @throws \MatoIlic\T3Chimp\MailChimp\MailChimpException if the form was not
     * previously bound to a request.
     */
    public function isValid() {
        if(!$this->isBound) {
            throw new MailChimpException('Can not validate an unbound form');
        }

        if(!$this->getDisableCaptcha()) {
            $timePassed = (integer)$this->controlFields['ccts'];
            $captchaField = $this->controlFields['cc'];
            $honeypotField = $this->controlFields['cchp'];

            if (strlen($honeypotField) > 0 || $captchaField != $this->getCaptchaCode() || $timePassed < self::MIN_SUBMISSION_TIME) {
                return FALSE;
            }
        }

        if($this->getField('FORM_ACTION')->getValue() == 'subscribe') {
            foreach($this->getFields(TRUE) as $field) {
                if(!$field->getIsValid()) {
                    return FALSE;
                }
            }

            return TRUE;
        }

        return $this->getField('EMAIL')->getIsValid();
    }

    /**
     * Disables the validation of the hidden CAPTCHA.
     *
     * @param $disable
     */
    public function setDisableCaptcha($disable) {
        $this->disableCaptcha = $disable;
    }

    /**
     * Creates and adds a field for an interest grouping.
     *
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
            $this->publicFields[] = new Field\InterestGrouping($definition, $this);
        }
    }
}
