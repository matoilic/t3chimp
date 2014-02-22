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

use MatoIlic\T3Chimp\MailChimp\Form;

class EmailFormat extends Radio {
    /**
     * @var bool
     */
    private $hidden = TRUE;

    public function __construct(array $definition, Form $form) {
        $definition['choices'] = array('HTML', 'Text');
        parent::__construct($definition, $form);
    }

    public function getApiValue() {
        return strtolower($this->getValue());
    }

    public function getDefaultValue() {
        return 'HTML';
    }

    public function getIsEmailFormatField() {
        return TRUE;
    }

    public function getIsHidden() {
        return $this->hidden;
    }

    public function getIsRequired() {
        return true;
    }

    public function getLabel() {
        return 'Email format';
    }

    public function getTag() {
        return 'email_type';
    }

    public function hide($hidden) {
        $this->hidden = $hidden;
    }

    public function setApiValue($value) {
        if($value == 'text') {
            $this->setValue('Text');
        } else {
            $this->setValue('HTML');
        }
    }
}
