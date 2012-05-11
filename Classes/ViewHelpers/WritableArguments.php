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

/**
 * makes arguments writable
 */
class Tx_T3chimp_ViewHelpers_WritableArguments extends Tx_Fluid_Core_ViewHelper_Arguments {
    /**
     * @var array
     */
    protected $overridenValues = array();

    /**
     * @var Tx_Fluid_Core_ViewHelper_Arguments
     */
    protected $parent;

    public function __construct(Tx_Fluid_Core_ViewHelper_Arguments $parent) {
        $this->parent = $parent;
    }

    public function hasArgument($argumentName) {
        if($this->offsetExists($argumentName) && $this->overridenValues[$argumentName] !== null) {
            return true;
        }

        return $this->parent->hasArgument($argumentName);
    }

    public function offsetExists($key) {
        if(array_key_exists($key, $this->overridenValues)) {
            return true;
        }

        return $this->parent->offsetExists($key);
    }

    public function offsetGet($key) {
        if(array_key_exists($key, $this->overridenValues)) {
            return $this->overridenValues[$key];
        }

        return $this->parent->offsetGet($key);
    }

    public function offsetSet($key, $value) {
        $this->overridenValues[$key] = $value;
    }

    public function offsetUnset($key) {
        unset($this->overridenValues[$key]);
    }
}
