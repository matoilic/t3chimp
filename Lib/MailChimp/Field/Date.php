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

class MailChimp_Field_Date extends MailChimp_Field_PatternBased {
    /**
     * @var string
     */
    private $apiValue = null;

    /**
     * Changes the format of the value to YYYY-MM-DD
     *
     * @return string|null
     */
    public function getApiValue() {
        if(!$this->getIsValid()) return null;

        if(empty($this->apiValue)) {
            $matches = array();
            preg_match($this->getPattern(), $this->getValue(), $matches);

            if($this->getFormat() == 'DD/MM/YYYY') {
                if(!empty($matches[1])) {
                    $this->apiValue = sprintf("%s-%s-%s", $matches[3], $matches[2], $matches[1]);
                } else {
                    $this->apiValue = sprintf("%s-%s-%s", $matches[6], $matches[5], $matches[4]);
                }
            } else {
                if(!empty($matches[1])) {
                    $this->apiValue = sprintf("%s-%s-%s", $matches[3], $matches[1], $matches[2]);
                } else {
                    $this->apiValue = sprintf("%s-%s-%s", $matches[6], $matches[4], $matches[5]);
                }
            }
        }

        return $this->apiValue;
    }

    public function getFormat() {
        return $this->definition['dateformat'];
    }

    public function getHtmlPattern() {
        if($this->getFormat() == 'DD/MM/YYYY') {
            return '^(?:(?:(?:(?:31(?:/|\.)(?:0[13578]|1[02]))|(?:(?:29|30)(?:/|\.)(?:0[1,3-9]|1[0-2])))(?:/|\.)(?:1[6-9]|[2-9]\d)\d{2})|(?:(29)(?:/|\.)(02)(?:/|\.)((?:(?:1[6-9]|[2-9]\d)(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))|(0[1-9]|1\d|2[0-8])(?:/|\.)((?:0[1-9])|(?:1[0-2]))(?:/|\.)((?:1[6-9]|[2-9]\d)\d{2}))$';
        }

        return '^(?:(?:(?:(?:(?:0[13578]|1[02])(?:/|\.)31)|(?:(?:0[1,3-9]|1[0-2])(?:/|\.)(?:29|30)))(?:/|\.)(?:1[6-9]|[2-9]\d)\d{2})|(?:(02)(?:/|\.)(29)(?:/|\.)((?:(?:1[6-9]|[2-9]\d)(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))|((?:0[1-9])|(?:1[0-2]))(?:/|\.)(0[1-9]|1\d|2[0-8])(?:/|\.)((?:1[6-9]|[2-9]\d)\d{2}))$';
    }

    public function setValue($value) {
        parent::setValue($value);
        $this->apiValue = null;
    }


    protected function validate() {
        parent::validate();

        if($this->getIsValid() && !$this->getIsEmpty() && !preg_match($this->getPattern(), $this->getValue())) {
            $this->errors[] = 't3chimp.error.invalidDate';
        }
    }
}
