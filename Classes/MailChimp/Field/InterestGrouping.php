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

class Tx_T3chimp_MailChimp_Field_InterestGrouping extends Tx_T3chimp_MailChimp_Field_Checkboxes {
    public function getGroupingId() {
        return $this->definition['groupingId'];
    }

    public function getDisplayAsDropdown() {
        return $this->definition['form_field'] == 'dropdown';
    }

    public function getDisplayAsCheckboxes() {
        return $this->definition['form_field'] == 'checkboxes';
    }

    public function getDisplayAsRadios() {
        return $this->definition['form_field'] == 'radio';
    }

    public function getTag() {
        return $this->definition['name'];
    }

    public function setValue($value) {
        if($value != null && !is_array($value)) {
            parent::setValue(array($value));
            return;
        }

        if(!$this->getDisplayAsCheckboxes() && count($value) > 1) {
            throw new Tx_T3chimp_MailChimp_Exception('Interest groupings with a field type other than checkboxes can only have one value');
        }

        parent::setValue($value);
    }
}
