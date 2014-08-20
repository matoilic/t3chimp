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

/**
 * @api
 * @package MatoIlic\T3Chimp\MailChimp
 */
interface Field {
    /**
     * Adds a error message to the field and thus marks it as invalid.
     *
     * @param string $message
     * @return void
     */
    public function addError($message);

    /**
     * Returns the fields value in the format that is required to pass it
     * to the MailChimp API.
     *
     * @return mixed
     */
    public function getApiValue();

    /**
     * Returns the default value of the field.
     *
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * Returns all errors that have been found during
     * validation.
     *
     * @return array
     */
    public function getErrors();

    /**
     * Returns the ID of the field that is used as the ID
     * of the HTML input field.
     *
     * @return string
     */
    public function getId();

    /**
     * Returns TRUE if this is the action field (subscribe / unsubscribe).
     *
     * @return bool
     */
    public function getIsActionField();

    /**
     * Returns TRUE if this is the email format field (HTML / text).
     *
     * @return bool
     */
    public function getIsEmailFormatField();

    /**
     * Returns TRUE if no or an empty value has been set for this field.
     *
     * @return bool
     */
    public function getIsEmpty();

    /**
     * Returns TRUE if this is a hidden field.
     *
     * @return bool
     */
    public function getIsHidden();

    /**
     * Returns TRUE if this is a interest groupings field. These kind of fields
     * are treated specially when communicating to the MailChimp API.
     *
     * @return bool
     */
    public function getIsInterestGroup();

    /**
     * Returns TRUE if this is a required field.
     *
     * @return boolean
     */
    public function getIsRequired();

    /**
     * Returns TRUE if the field has a valid value.
     *
     * @return boolean
     */
    public function getIsValid();

    /**
     * Returns the fields label as defined in the MailChimp backend.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Returns the name of the field that is used as the name
     * of the HTML input field.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the merge tag used by the MailChimp API to
     * identify the field.
     *
     * @return string
     */
    public function getTag();

    /**
     * Returns the template used to render this field.
     *
     * @return string
     */
    public function getTemplate();

    /**
     * Returns the translation key used to translate the fields
     * label.
     *
     * @return string
     */
    public function getTranslationKey();

    /**
     * Returns the fields value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * This is a special setter for the value to process input values
     * retrieved from the MailChimp API.
     *
     * @param mixed $value
     * @return void
     */
    public function setApiValue($value);

    /**
     * Sets the fields value. Setting a new value will reset the validation
     * and clear all error messages.
     *
     * @param mixed $value
     * @return void
     */
    public function setValue($value);
}
