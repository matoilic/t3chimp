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
 * Custom bootstrap to properly initialize important properties for AJAX requests
 */
class Tx_T3chimp_Core_Bootstrap extends Tx_Extbase_Core_Bootstrap {
    /**
     * Runs the the Extbase Framework by resolving an appropriate Request Handler and passing control to it.
     * If the Framework is not initialized yet, it will be initialized.
     *
     * @param string $content The content
     * @param array $configuration The TS configuration array
     * @return string $content The processed content
     * @api
     */
    public function run($content, $configuration) {
        $this->initialize($configuration);

        /** @var Tx_Extbase_MVC_RequestHandlerResolver $requestHandlerResolver */
        $requestHandlerResolver = $this->objectManager->get('Tx_Extbase_MVC_RequestHandlerResolver');
        /** @var Tx_Extbase_MVC_Web_FrontendRequestHandler $requestHandler */
        $requestHandler = $requestHandlerResolver->resolveRequestHandler();

        $GLOBALS['TSFE']->sys_language_uid = $_GET['L'];
        if(strlen($_GET['LISO']) > 0) {
            $GLOBALS['TSFE']->sys_language_isocode = $_GET['LISO'];
            $GLOBALS['TSFE']->config['config']['language'] = $_GET['LISO'];
        }

        $GLOBALS['TSFE']->id = $_GET['id'];

        $response = $requestHandler->handleRequest();

        // If response is NULL after handling the request we need to stop
        // This happens for instance, when a USER object was converted to a USER_INT
        // @see Tx_Extbase_MVC_Web_FrontendRequestHandler::handleRequest()
        if ($response === NULL) {
            $this->reflectionService->shutdown();
            return;
        }
        if (count($response->getAdditionalHeaderData()) > 0) {
            $GLOBALS['TSFE']->additionalHeaderData[] = implode(chr(10), $response->getAdditionalHeaderData());
        }
        $response->sendHeaders();
        $content = $response->getContent();

        $this->resetSingletons();
        return $content;
    }
}
