<?php

class Tx_T3chimp_Controller_SubscriptionsController extends Tx_T3chimp_Controller_BaseController {
    /**
     * @var int
     */
    private $listId;

    /**
     * @var Tx_T3chimp_Service_MailChimp
     */
    private $mailChimpService;

    private function generateCaptcha() {
        $_SESSION['cc'] = rand(10, 1000000000);
        $this->response->addAdditionalHeaderData('<meta name="cc" content="' . $_SESSION['captcha'] . '" />');
    }

    public function initializeAction() {
        parent::initializeAction();
        $this->mailChimpService = $this->objectManager->get('Tx_T3chimp_Service_MailChimp');
        $this->listId = $this->settings['subscriptionList'];
    }

    /**
     * @NotCsrfProtected
     */
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
     * TODO enable csrf protection
     * @NotCsrfProtected
     */
    public function processAction() {
        $form = $this->mailChimpService->getForm();
        $form->bindRequest($this->request);
        if($form->isValid()) {
            if($this->mailChimpService->saveForm($form) > 0) {
                $this->redirect('subscribed');
            } else {
                $this->redirect('unsubscribed');
            }
            return;
        }

        $this->view->assign('form', $form);
    }

    /**
     * @NotCsrfProtected
     */
    public function subscribedAction() {

    }

    /**
     * @NotCsrfProtected
     */
    public function unsubscribedAction() {

    }

    //TODO remove
    public function subscribeAction() {
        if(!$this->validateCaptcha()) {
            $this->redirect('index');
            return;
        }

        $fields = $this->mailChimpService->getFieldsFor($this->listId);
        $interestGroupings = $this->mailChimpService->getInterestGroupingsFor($this->listId);

        if($this->validateSubscription(&$fields, &$interestGroupings, $_POST)) {
            $this->mailChimpService->addSubscriber($this->listId, $fields, $interestGroupings, $this->settings['doubleOptIn']);
        } else {
            $this->view->assign('fieldDefinitions', $fields);
            $this->view->assign('action', 'subscribe');
            return $this->view->render('index');
        }
    }

    //todo remove
    public function unsubscribeAction() {
        if(!$this->validateCaptcha()) {
            $this->redirect('index');
            return;
        }

        $email = $_POST['EMAIL'];

        if($this->validateEmail($email)) {
            $this->mailChimpService->removeSubscriber($this->listId, $email);
        } else {
            $this->flashMessageContainer->add($this->translate('form.invalidEmail'));
            $fields = $this->mailChimpService->getFieldsFor($this->listId);
            $this->view->assign('fieldDefinitions', $fields);
            $this->view->assign('action', 'unsubscribe');
            return $this->view->render('index');
        }
    }

    private function validateCaptcha() {
        return $this->request->getArgument('cc') == $_SESSION['cc'];
    }

    private function validateEmail($email) {
        return preg_match("/^([a-z0-9])([a-z0-9-_.]+)@([a-z0-9])([a-z0-9-_]+\.)+([a-z]{2,4})$/i", $email);
    }

    private function validateSubscription($fields, $interestGroupings, $values) {
        $hasErrors = false;

        for($i = 0; $i < count($fields); $i++) {
            $field = $fields[$i];
            $field['value'] = trim($values[$field['tag']]);
            $field['errors'] = array();

            if($field['value'] == null && $field['req']) {
                $field['errors'][] = $this->translate('form.required');
                $hasErrors = $hasErrors || true;
            } else if($field['field_type'] == 'email' && !$this->validateEmail($field['value'])) {
                $field['errors'][] = $this->translate('form.invalidEmail');
                $hasErrors = $hasErrors || true;
            } else if(in_array($field['field_type'], array('dropdown', 'radio')) && !in_array($field['value'], $field['choices'])) {
                $field['errors'][] = $this->translate('form.invalidValue');
                $hasErrors = $hasErrors || true;
            } else {
                $hasErrors = $hasErrors || false;
            }

            $fields[$i] = $field;
        }

        for($i = 0; $i < count($interestGroupings); $i++) {
            $grouping = $interestGroupings[$i];
            $selection = array();

            foreach($grouping['groups'] as $group) {
                $fieldName = 'mc_group_' . $grouping['id'] . '_' . $group['bit'];
                if(isset($values[$fieldName]) && $values[$fieldName] == $group['bit']) {
                    $selection[] = $group['name'];
                }
            }

            $grouping['selection'] = $selection;
            $interestGroupings[$i] = $grouping;
        }

        return !$hasErrors;
    }
}
