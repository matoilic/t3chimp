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

class Tx_T3chimp_MailChimp_Field_Checkboxes extends Tx_T3chimp_MailChimp_Field_Radio {
    public function getDefaultValue() {
        return array();
    }


    /**
     * @param array $choices
     */
    protected function initializeChoices(array $choices) {
        foreach($choices as $choice) {
            $this->choices[] = new Tx_T3chimp_MailChimp_Field_Helper_MultiChoice($this, $choice['name']);
            $this->validValues[] = $choice['name'];
        }
    }

    /**
     * @param mixed $value
     * @throws Tx_T3chimp_MailChimp_Exception
     */
    public function setValue($value) {
        if($value == null) {
            $this->value = array();
            return;
        }

        if(!is_array($value)) {
            throw new Tx_T3chimp_MailChimp_Exception('Value for checkboxes field must be an array');
        }

        foreach($value as $selection) {
            if(!in_array($selection, $this->validValues)) {
                throw new Tx_T3chimp_MailChimp_Exception('Invalid choice ' . htmlentities($selection) . ' for field ' . $this->getName());
            }
        }

        $this->value = $value;
        $this->resetValidation();
    }


    /**
     * @return void
     */
    protected function validate() {
        $this->isValidated = true;
        $value = $this->getValue();
        if($this->getIsRequired() && count($value) == 0) {
            $this->errors[] = 't3chimp.error.required';
        }
    }
}
