<?php

/**
 * Custom bootstrap to properly initialize some properties for AJAX requests
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

        $GLOBALS['TSFE']->sys_language_uid = $_SERVER['HTTP_X_LANGUAGE'];
        if(strlen($_SERVER['HTTP_X_LANGUAGE_ISO']) > 0) {
            $GLOBALS['TSFE']->sys_language_isocode = $_SERVER['HTTP_X_LANGUAGE_ISO'];
            $GLOBALS['TSFE']->config['config']['language'] = $GLOBALS['TSFE']->sys_language_isocode;
        }
        $GLOBALS['TSFE']->id = $_SERVER['HTTP_X_PID'];

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
