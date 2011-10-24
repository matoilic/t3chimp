<?php

class Tx_T3chimp_Controller_SubscriptionsController extends Tx_T3chimp_Controller_BaseController {
    /**
     * @var Tx_T3chimp_Domain_Repository_ListRepository
     */
    private $listRepository;

    public function initializeAction() {
        parent::initializeAction();
        $this->listRepository = new Tx_T3chimp_Domain_Repository_ListRepository();
    }

    public function indexAction() {
        $fields = $this->listRepository->getFieldsFor($this->settings['subscriptionList']);
        $this->view->assign('lists', print_r($fields, true));
    }
}
