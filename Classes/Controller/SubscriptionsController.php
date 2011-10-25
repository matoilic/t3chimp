<?php

class Tx_T3chimp_Controller_SubscriptionsController extends Tx_T3chimp_Controller_BaseController {
    /**
     * @var Tx_T3chimp_Domain_Repository_ListRepository
     */
    private $listRepository;

    private function generateCaptcha() {
        $_SESSION['cc'] = rand(10, 1000000000);
        $this->response->addAdditionalHeaderData('<meta name="cc" content="' . $_SESSION['captcha'] . '" />');
    }

    public function initializeAction() {
        parent::initializeAction();
        $this->listRepository = new Tx_T3chimp_Domain_Repository_ListRepository();
    }

    public function indexAction() {
        $fields = $this->listRepository->getFieldsFor($this->settings['subscriptionList']);
        $this->view->assign('fieldDefinitions', $fields);
    }

    /**
     * @param string $action either subscribe or unsubscribe
     * @return void
     */
    public function processAction($action) {
        if(!$this->validateCaptcha()) {
            $this->redirect('index');
            return;
        }

        $listId = $this->settings['subscriptionList'];
        $fields = $this->listRepository->getFieldsFor($listId);
        $values = $this->request->getArguments();

        if($this->validateSubscription($fields, $values)) {
            if($action == 'unsubscribe') {
                $this->listRepository->removeSubscriber($listId, $fields);
            } else {
                $this->listRepository->addSubscriber($listId, $fields);
            }
        } else {
            $this->view->assign('fieldDefinitions', $fields);
        }
    }

    private function validateCaptcha() {
        return $this->request->getArgument('cc') == $_SESSION['cc'];
    }

    private function validateEmail($email) {
        return preg_match("#^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$#i", $email);
    }

    private function validateSubscription($fields, $values) {
        $hasErrors = false;

        for($i = 0; $i < count($fields); $i++) {
            $field = $fields[$i];
            $field['value'] = $values[$field['tag']];
            $field['errors'] = array();

            if($field['value'] == null && $field['req']) {
                $field['errors'][] = $this->translate('form.required');
                $hasErrors = $hasErrors || true;
            } else if($field['field_type'] == 'email' && !$this->validateEmail($field['value'])) {
                $field['errors'][] = $this->translate('form.invalidEmail');
                $hasErrors = $hasErrors || true;
            } else if($field['field_type'] == 'dropdown' && in_array($field['value'], $field['choices'])) {
                $field['errors'][] = $this->translate('form.invalidValue');
                $hasErrors = $hasErrors || true;
            } else {
                $hasErrors = $hasErrors || false;
            }

            $fields[$i] = $field;
        }

        return $hasErrors;
    }
}
