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

use MatoIlic\T3Chimp\MailChimp\MailChimpException;

class Birthday extends AbstractField {
    protected static $daysInMonth = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    /**
     * @return int
     */
    public function getDay() {
        return (int)$this->getField('day');
    }

    /**
     * @return array
     */
    public function getDefaultValue() {
        return array(
            'month' => '',
            'day' => ''
        );
    }

    /**
     * @param string $field
     * @return string
     */
    private function getField($field) {
        $value = $this->getValue();
        return array_key_exists($field, $value) ? $value[$field] : '';
    }

    /**
     * @return string
     */
    public function getFormat() {
        return $this->definition['dateformat'];
    }

    /**
     * @return int
     */
    public function getMonth() {
        return (int)$this->getField('month');
    }

    /**
     * @return bool
     */
    public function getMonthFirst() {
        return substr($this->getFormat(), 0, 2) == 'MM';
    }

    public function setApiValue($value) {
        if(strlen($value) == 0) {
            return;
        }

        $parts = explode('/', $value);
        $this->setValue(array('month' => $parts[0], 'day' => $parts[1]));
    }

    /**
     * @param array $value in the format array('month' => x, 'day' => x)
     * @throws MailChimpException
     */
    public function setValue($value) {
        foreach(array_keys($value) as $key) {
            if($key != 'month' && $key != 'day') {
                throw new MailChimpException('Unallowed key ' . htmlentities($key) . ' in value for field' . $this->getName());
            }
        }

        $value['month'] = (int)$value['month'];
        $value['day'] = (int)$value['day'];

        $this->value = $value;

        $this->resetValidation();
    }

    protected function validate() {
        $this->isValidated = TRUE;

        $value = $this->getValue();

        $month = $value['month'];
        $day = $value['day'];

        if(!$this->getIsRequired() && $month == 0 && $day == 0) {
            return;
        }

        if($this->getIsRequired() && $month == 0 && $day == 0) {
            $this->errors[] = 'error_required';
            return;
        }

        if($month < 1 || $month > 12 && $day < 0 || $day > self::$daysInMonth[$month - 1]) {
            $this->errors[] = 'error_invalidBirthDate';
        }
    }
}
