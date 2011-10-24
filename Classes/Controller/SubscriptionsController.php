<?php

class Tx_T3chimp_Controller_SubscriptionsController extends Tx_T3chimp_Controller_BaseController {
    public function indexAction() {
        $repo = new Tx_T3chimp_Domain_Repository_ListRepository();
        $this->view->assign('lists', $this->set);
    }
}
