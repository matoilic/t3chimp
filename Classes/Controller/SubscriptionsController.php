<?php

class Tx_T3chimp_Controller_SubscriptionsController extends Tx_Extbase_MVC_Controller_ActionController {
    /**
     * @var int
     */
    private $listId;

    /**
     * @var Tx_T3chimp_Service_MailChimp
     */
    private $mailChimpService;

    /**
     * @var Tx_T3chimp_Session_Provider
     */
    protected $session;

    protected function checkCsrfToken() {
        if($_SERVER['HTTP_X_CSRF_TOKEN'] !== $this->session->csrfToken) {
            throw new Exception('t3chimp: invalid CRSF token');
        }
    }

    public function initializeAction() {
        parent::initializeAction();

        if(!isset($this->session->csrfToken)) {
            $this->session->csrfToken = md5(rand() . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
        }

        $this->response->addAdditionalHeaderData('<meta name="t3chimp:csrf-token" content="' . $this->session->csrfToken . '" />');
        $this->response->addAdditionalHeaderData('<meta name="t3chimp:lang" content="' . $GLOBALS['TSFE']->sys_language_uid . '" />');
        $this->response->addAdditionalHeaderData('<meta name="t3chimp:lang-iso" content="' . $GLOBALS['TSFE']->sys_language_isocode . '" />');
        $this->response->addAdditionalHeaderData('<meta name="t3chimp:pid" content="' . $GLOBALS['TSFE']->id . '" />');
    }

    public function indexAction() {
        $this->view->assign('form', $this->mailChimpService->getForm());
    }

    /**
     * @param Tx_T3chimp_Service_MailChimp $service
     */
    public function injectMailChimpService(Tx_T3chimp_Service_MailChimp $service) {
        $this->mailChimpService = $service;
    }

    /**
     * @param Tx_T3chimp_Session_Provider $provider
     */
    public function injectSessionProvider(Tx_T3chimp_Session_Provider $provider) {
        $this->session = $provider;
    }

    /**
     * @param SettingsProvider $provider
     */
    public function injectSettingsProvider(SettingsProvider $provider) {
        $this->settings = $provider->getAll();
    }

    public function processAction() {
        $this->checkCsrfToken();

        $form = $this->mailChimpService->getForm();
        $form->bindRequest($this->request);

        if($form->isValid()) {
            if($this->mailChimpService->saveForm($form) > 0) {
                $message = $this->translate('t3chimp.form.subscribed');
            } else {
                $message = $this->translate('t3chimp.form.unsubscribed');
            }

            return json_encode(array('html' => $message), JSON_HEX_TAG | JSON_HEX_QUOT);
        }

        $this->view->assign('form', $form);

        return json_encode(array('html' => $this->view->render()), JSON_HEX_TAG | JSON_HEX_QUOT);
    }

    /**
     * @param $key the key for the label
     * @param null|array $arguments
     * @param string $default
     * @return string
     */
    protected function translate($key, $arguments = null, $default = 'MISSING TRANSLATION') {
        $extensionName = $this->request->getControllerExtensionName();
        $value = Tx_Extbase_Utility_Localization::translate($key, $extensionName, $arguments);

        return ($value != NULL) ? $value : $default;
    }
}
