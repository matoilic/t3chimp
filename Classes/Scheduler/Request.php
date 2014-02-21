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

namespace MatoIlic\T3Chimp\Scheduler;

use TYPO3\CMS\Extbase\Mvc\Exception\InvalidActionNameException;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchControllerException;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;

class Request implements RequestInterface {
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
        return FALSE;
    }

    /**
     * Returns the object name of the controller defined by the package key and
     * controller name
     *
     * @return string The controller's Object Name
     * @throws NoSuchControllerException if the controller does not exist
     * @api
     */
    public function getControllerObjectName() {
        return NULL;
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
     * @throws NoSuchArgumentException if such an argument does not exist
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

    /**
     * Sets the extension name of the controller.
     *
     * @param string $extensionName The extension name.
     * @return void
     * @throws InvalidPackageKey if the package key is not valid
     * @api
     */
    public function setControllerExtensionName($extensionName) {
        // 4.5.x compatibility
    }

    /**
     * Returns the extension name of the specified controller.
     *
     * @return string The package key
     * @api
     */
    public function getControllerExtensionName() {
        // 4.5.x compatibility
    }

    /**
     * Sets the name of the controller which is supposed to handle the request.
     * Note: This is not the object name of the controller!
     *
     * @param string $controllerName Name of the controller
     * @return void
     * @api
     */
    public function setControllerName($controllerName) {
        // 4.5.x compatibility
    }

    /**
     * Returns the object name of the controller supposed to handle this request, if one
     * was set already (if not, the name of the default controller is returned)
     *
     * @return string Object name of the controller
     * @api
     */
    public function getControllerName() {
        // 4.5.x compatibility
    }

    /**
     * Sets the name of the action contained in this request.
     *
     * Note that the action name must start with a lower case letter.
     *
     * @param string $actionName: Name of the action to execute by the controller
     * @return void
     * @throws InvalidActionNameException if the action name is not valid
     * @api
     */
    public function setControllerActionName($actionName) {
        // 4.5.x compatibility
    }

    /**
     * Returns the name of the action the controller is supposed to execute.
     *
     * @return string Action name
     * @author Robert Lemke <robert@typo3.org>
     * @api
     */
    public function getControllerActionName() {
        // 4.5.x compatibility
    }

    /**
     * Sets the requested representation format
     *
     * @param string $format The desired format, something like "html", "xml", "png", "json" or the like.
     * @return void
     * @api
     */
    public function setFormat($format) {
        // 4.5.x compatibility
    }

    /**
     * Returns the requested representation format
     *
     * @return string The desired format, something like "html", "xml", "png", "json" or the like.
     * @api
     */
    public function getFormat() {
        // 4.5.x compatibility
    }

    /**
     * Set the request errors that occured during the request
     *
     * @param array $errors An array of Tx_Extbase_Error_Error objects
     * @return void
     * @api
     */
    public function setErrors(array $errors) {
        // 4.5.x compatibility
    }

    /**
     * Get the request errors that occured during the request
     *
     * @return array An array of Tx_Extbase_Error_Error objects
     * @api
     */
    public function getErrors() {
        // 4.5.x compatibility
    }
}
