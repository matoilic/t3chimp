<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Mato Ilic <info@matoilic.ch>
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

/**
 * makes arguments writable
 */
class Tx_T3chimp_ViewHelpers_WritableArguments extends Tx_Fluid_Core_ViewHelper_Arguments {
    /**
     * @var array
     */
    protected $overriddenValues = array();

    /**
     * @var array | ArrayAccess
     */
    protected $parent;

    public function __construct($parent) {
        $this->parent = $parent;
    }

    public function hasArgument($argumentName) {
        if(array_key_exists($argumentName, $this->overriddenValues) && $this->overriddenValues[$argumentName] !== null) {
            return true;
        }

        return (
            (
                (is_array($this->parent) && array_key_exists($argumentName, $this->parent)) ||
                (is_object($this->parent) && $this->parent->hasArgument($argumentName)) //4.5.x compatibility
            ) &&
            $this->parent[$argumentName] !== null
        );
    }

    public function offsetExists($key) {
        if(array_key_exists($key, $this->overriddenValues)) {
            return true;
        }

        return (
            (is_array($this->parent) && array_key_exists($key, $this->parent)) ||
            (is_object($this->parent) && $this->parent->offsetExists($key)) //4.5.x compatibility
        );
    }

    public function offsetGet($key) {
        if(array_key_exists($key, $this->overriddenValues)) {
            return $this->overriddenValues[$key];
        }

        return $this->parent[$key];
    }

    public function offsetSet($key, $value) {
        $this->overriddenValues[$key] = $value;
    }

    public function offsetUnset($key) {
        unset($this->overriddenValues[$key]);
    }

    public function toArray() {
        return array_merge_recursive($this->parent, $this->overriddenValues);
    }
}
