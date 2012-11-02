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

class Tx_T3chimp_Command_Request implements Tx_Extbase_MVC_RequestInterface {
    /**
     * @var array
     */
    private $arguments = array();

    /**
     * Sets the dispatched flag
     *
     * @param boolean $flag If this request has been dispatched
     * @return void
     * @api
     */
    public function setDispatched($flag) {

    }

    /**
     * If this request has been dispatched and addressed by the responsible
     * controller and the response is ready to be sent.
     *
     * The dispatcher will try to dispatch the request again if it has not been
     * addressed yet.
     *
     * @return boolean TRUE if this request has been disptached successfully
     * @api
     */
    public function isDispatched() {
        return false;
    }

    /**
     * Returns the object name of the controller defined by the package key and
     * controller name
     *
     * @return string The controller's Object Name
     * @throws Tx_Extbase_MVC_Exception_NoSuchController if the controller does not exist
     * @api
     */
    public function getControllerObjectName() {
        return null;
    }

    /**
     * Sets the value of the specified argument
     *
     * @param string $argumentName Name of the argument to set
     * @param mixed $value The new value
     * @return void
     * @api
     */
    public function setArgument($argumentName, $value) {
        $this->arguments[$argumentName] = $value;
    }

    /**
     * Sets the whole arguments array and therefore replaces any arguments
     * which existed before.
     *
     * @param array $arguments An array of argument names and their values
     * @return void
     * @api
     */
    public function setArguments(array $arguments) {
        $this->arguments = $arguments;
    }

    /**
     * Returns the value of the specified argument
     *
     * @param string $argumentName Name of the argument
     * @return string Value of the argument
     * @throws Tx_Extbase_MVC_Exception_NoSuchArgument if such an argument does not exist
     * @api
     */
    public function getArgument($argumentName) {
        return $this->arguments[$argumentName];
    }

    /**
     * Checks if an argument of the given name exists (is set)
     *
     * @param string $argumentName Name of the argument to check
     * @return boolean TRUE if the argument is set, otherwise FALSE
     * @api
     */
    public function hasArgument($argumentName) {
        return array_key_exists($argumentName, $this->arguments);
    }

    /**
     * Returns an array of arguments and their values
     *
     * @return array Array of arguments and their values (which may be arguments and values as well)
     * @api
     */
    public function getArguments() {
        return $this->arguments;
    }

}
