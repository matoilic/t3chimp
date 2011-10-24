<?php
/***************************************************************
 * Copyright notice
 *
 *   2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
 *   2011 Mato Ilic <milic@bsmediavision.ch>
 * All rights reserved
 *
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once(PATH_t3lib . 'class.t3lib_page.php');
require_once(PATH_tslib . 'class.tslib_pibase.php');
require_once(PATH_tslib . 'class.tslib_content.php');
require_once(PATH_t3lib . 'class.t3lib_stdgraphic.php');
require_once(PATH_tslib . 'class.tslib_gifbuilder.php');

/**
 * Utility to include defined frontend libraries as jQuery and related CSS
 *
 *
 * @package Utility
 * @author Daniel Lienert <daniel@lienert.cc>
 */

class Tx_AjaxDispatcher {


    /**
     * Array of all request Arguments
     *
     * @var array
     */
    protected $requestArguments = array();



    /**
     * Extbase Object Manager
     * @var Tx_Extbase_Object_ObjectManager
     */
    protected $objectManager;


    /**
     * @var string
     */
    protected static $EXTENSION_NAME = 'T3chimp';


    /**
     * @var string
     */
    protected $pluginName;


    /**
     * @var string
     */
    protected $controllerName;


    /**
     * @var string
     */
    protected $actionName;


    /**
     * @var array
     */
    protected $arguments;



    /**
     * Called by ajax.php / eID.php
     * Builds an extbase context and returns the response
     */
    public function dispatch() {
        $this->prepareCallArguments();

        $configuration['extensionName'] = self::$EXTENSION_NAME;
        $configuration['pluginName'] = $this->pluginName;

        $bootstrap = t3lib_div::makeInstance('Tx_Extbase_Core_Bootstrap');
        $bootstrap->initialize($configuration);

        $this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');

        $request = $this->buildRequest();
        $response = $this->objectManager->create('Tx_Extbase_MVC_Web_Response');

        $dispatcher =  $this->objectManager->get('Tx_Extbase_MVC_Dispatcher');
        $dispatcher->dispatch($request, $response);

        $response->sendHeaders();
        echo $response->getContent();

        $this->cleanShutDown();
    }


    protected function cleanShutDown() {
        $this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
        $this->objectManager->get('Tx_Extbase_Reflection_Service')->shutdown();
    }


    /**
     * Build a request object
     *
     * @return Tx_Extbase_MVC_Web_Request $request
     */
    protected function buildRequest() {
        $request = $this->objectManager->get('Tx_Extbase_MVC_Web_Request'); /* @var $request Tx_Extbase_MVC_Request */
        $request->setControllerExtensionName(self::$EXTENSION_NAME);
        $request->setPluginName($this->pluginName);
        $request->setControllerName($this->controllerName);
        $request->setControllerActionName($this->actionName);
        $request->setArguments($this->arguments);

        return $request;
    }


    /**
     * Prepare the call arguments
     */
    protected function prepareCallArguments() {
        $request = t3lib_div::_GP('request');

        if($request) {
            $this->setRequestArgumentsFromJSON($request);
            $this->setRequestArgumentsFromGetPost($request);
        }

        $this->pluginName        = $this->requestArguments['pluginName'];
        $this->controllerName    = $this->requestArguments['controllerName'];
        $this->actionName        = $this->requestArguments['actionName'];

        $this->arguments         = $this->requestArguments['arguments'];
        if(!is_array($this->arguments)) $this->arguments = array();
    }



    /**
     * Set the request array from JSON
     *
     * @param string $request
     */
    protected function setRequestArgumentsFromJSON($request) {
        $requestArray = json_decode($request, true);
        if(is_array($requestArray)) {
            $this->requestArguments = t3lib_div::array_merge_recursive_overrule($this->requestArguments, $requestArray);
        }
    }



    /**
     * Set the request array from the getPost array
     *
     * @param array $request
     */
    protected function setRequestArgumentsFromGetPost($request) {
        $validArguments = array('pluginName','controllerName','actionName','arguments');
        foreach($validArguments as $argument) {
            if($request[$argument]) $this->requestArguments[$argument] = $request[$argument];
        }
    }
}

if (TYPO3_MODE == 'FE') {
    //Connect to database
    tslib_eidtools::connectDB();

    // Initialize TSFE
    $temp_TSFEclassName = t3lib_div::makeInstanceClassName('tslib_fe');
    $TSFE = new $temp_TSFEclassName($TYPO3_CONF_VARS, $page, 0, true);
    $TSFE->tmpl = t3lib_div::makeInstance('t3lib_tstemplate');
    $TSFE->tmpl->init();
    $TSFE->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');
    $TSFE->rootLine = $TSFE->sys_page->getRootLine(intval(4));
    $TSFE->initFEuser();
    $TSFE->getConfigArray();
    $GLOBALS['TSFE'] = $TSFE;


    $dispatcher = t3lib_div::makeInstance('Tx_Hacoshowroom_AjaxDispatcher');
    $dispatcher->dispatch();
}
