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

class MailChimp_Field_Helper_Choice {
    /**
     * @var string
     */
    protected $id;

    /**
     * @var MailChimp_Field
     */
    protected $parent;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param MailChimp_Field $parent
     * @param mixed $value
     */
    public function __construct(MailChimp_Field $parent, $value) {
        $this->parent = $parent;
        $this->value = $value;
        $this->id = strtolower(str_replace(' ', '-', $value));
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->parent->getId() . '-' . $this->id;
    }

    public function getLocalizedValue() {
        $value = Tx_Extbase_Utility_Localization::translate(
            't3chimp: ' . $this->getValue(),
            'T3chimp'
        );

        return ($value !== null) ? $value : $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    public function getIsSelected() {
        return $this->value == $this->parent->getValue();
    }
}
