<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPaymentController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_AdminPaymentController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_paymentrequests');

    //$this->view->formFilter = $formFilter = new Sescrowdfunding_Form_Admin_Filterpaymentorder();

		$values = array();

//     if ($formFilter->isValid($this->_getAllParams()))
//       $values = $formFilter->getValues();

    $paymentTable = Engine_Api::_()->getItemTable('sescrowdfunding_userpayrequest');
		$paymentTableName = $paymentTable->info('name');

		$crowdfundingTableName = Engine_Api::_()->getItemTable('crowdfunding')->info('name');
		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $paymentTable->select()
                          ->from($paymentTableName)
                          ->where('state =?','pending')
                          ->setIntegrityCheck(false)
                          ->joinLeft($crowdfundingTableName, "$paymentTableName.crowdfunding_id = $crowdfundingTableName.crowdfunding_id", 'title')
                          ->where($crowdfundingTableName.'.crowdfunding_id !=?','')
                          ->joinLeft($tableUserName, "$paymentTableName.owner_id = $tableUserName.user_id", 'username')
                          ->order('creation_date DESC');

		if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

		if (!empty($_GET['creation_date']))
      $select->where($paymentTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

		if (!empty($_GET['crowdfunding']))
      $select->where($crowdfundingTableName . '.title LIKE ?', '%' . $_GET['crowdfunding'] . '%');

		if (!empty($_GET['amount']))
      $select->where($paymentTableName . '.requested_amount LIKE ?', '%' . $_GET['amount'] . '%');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

	public function approveAction() {

        $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $this->getRequest()->getParam('crowdfunding_id'));

        $paymnetReq = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->getRequest()->getParam('id'));

        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');

        $gateway_enable = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id' => $crowdfunding->owner_id));
        $user_id = $crowdfunding->owner_id;
        if(empty($gateway_enable)) {
            $this->view->disable_gateway = true;
        } else {
            $this->view->disable_gateway = false;

            // Make form
            $this->view->form = $form = new Sescrowdfunding_Form_Admin_Payment_Approve(array('userId' => $user_id));

            $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency();

            $remainingAmount  =  Engine_Api::_()->getDbtable('remainingpayments', 'sescrowdfunding')->getCrowdfundingRemainingAmount(array('crowdfunding_id'=>$crowdfunding->crowdfunding_id));

            $orderDetails  =  Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getCrowdfundingStats(array('crowdfunding_id'=>$crowdfunding->crowdfunding_id));
            $value = array();

            $value['total_amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($orderDetails['totalAmountSale'],$defaultCurrency);

            //$value['total_tax_amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($orderDetails['totalTaxAmount'],$defaultCurrency);

            $value['total_commission_amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency);

            $value['remaining_amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($remainingAmount->remaining_payment,$defaultCurrency);

            //set value to form
            if($this->_getParam('id',false)){
                $item = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->_getParam('id'));
                if($item){
                    $itemValue = $item->toArray();
                    $value = array_merge($itemValue,$value);
                    $value['requested_amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($itemValue['requested_amount'],$defaultCurrency);
                    $value['release_amount'] = $itemValue['requested_amount'];
                }else{
                    return $this->_forward('requireauth', 'error', 'core');
                }
            }

            if(empty($_POST))
                $form->populate($value);

            if (!$this->getRequest()->isPost())
                return;

            if (!$form->isValid($this->getRequest()->getPost()))
                return;

            if($item->requested_amount < @round($_POST['release_amount'],2)){
                $form->addError('Release amount must be less than or equal to requested amount.');
                return;
            }

            $db = Engine_Api::_()->getDbtable('userpayrequests', 'sescrowdfunding')->getAdapter();
            $db->beginTransaction();
            try {

                $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'sescrowdfunding');
                $order = $item;
                $order->release_amount = @round($_POST['release_amount'],2);
                $order->admin_message = $_POST['admin_message'];
                $order->release_date	 = date('Y-m-d h:i:s');
                $order->save();

                //Notification work
//                 $viewer = Engine_Api::_()->user()->getViewer();
//                 $owner = $crowdfunding->getOwner();
//                 Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $crowdfunding, 'sescrowdfunding_adminpaymentapprove', array());
//
//                 //Payment approve mail send to crowdfunding owner
//                 Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'sescrowdfunding_payment_adminrequestapproved', array('crowdfunding_title' => $crowdfunding->title, 'object_link' => $crowdfunding->getHref(), 'host' => $_SERVER['HTTP_HOST']));

                $db->commit();
                if($_POST['gateway_type'] == "paypal") {
                    $session = new Zend_Session_Namespace();
                    $session->payment_request_id = $order->userpayrequest_id;
                    $this->view->status = true;
                    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Processing...');
                    return $this->_forward('success', 'utility', 'core', array(
                        'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'sescrowdfunding', 'controller' => 'payment', 'action' => 'process'),'admin_default',true),
                        'messages' => array($this->view->message)
                    ));
                } else if($_POST['gateway_type'] == "stripe") {
                    $session = new Zend_Session_Namespace("sescrowdfunding_userpayrequest");
                    $session->payment_request_id = $order->userpayrequest_id;
                    return $this->_forward('success', 'utility', 'core', array(
                        'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'sesadvpmnt', 'controller' => 'payment', 'action' => 'index','type'=>'sescrowdfunding_userpayrequest'),'default',true),
                        'messages' => array($this->view->message)
                    ));
                } else if($_POST['gateway_type'] == "paytm") {
                    $session = new Zend_Session_Namespace("sescrowdfunding_userpayrequest");
                    $session->payment_request_id = $order->userpayrequest_id;
                    return $this->_forward('success', 'utility', 'core', array(
                        'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'epaytm', 'controller' => 'payment', 'action' => 'index','type'=>'sescrowdfunding_userpayrequest'),'default',true),
                        'messages' => array($this->view->message)
                    ));
                }
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
        }
	}

	public function processAction() {

		$session = new Zend_Session_Namespace();
		$viewer = Engine_Api::_()->user()->getViewer();
		if(!$session->payment_request_id)
			return $this->_forward('requireauth', 'error', 'core');

		$item = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $session->payment_request_id);
		$crowdfunding = Engine_Api::_()->getItem('crowdfunding', $item->crowdfunding_id);

        // Get gateway
        $gatewayId = $item->gateway_id;
        $gateway = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id'=>$crowdfunding->owner_id,'gateway_type'=>'paypal'));

        if( !$gatewayId || !($gateway) || !($gateway->enabled) ) {
            return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }

        $this->view->gateway = $gateway;
		$this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway(array('plugin'=>$gateway->plugin,'is_sponsorship'=>'sescrowdfunding'));
		$plugin = $gateway->getPlugin();

		$ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');

        //Process
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->usergateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'sescrowdfunding_userpayrequest',
            'source_id' => $item->userpayrequest_id,
        ));

		$session = new Zend_Session_Namespace();
        $session->sescrowdfunding_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
		$session->sescrowdfunding_item_id = $item->getIdentity();

        // Prepare host info
        $schema = 'http://';
        if( !empty($_ENV["HTTPS"]) && 'on' == strtolower($_ENV["HTTPS"]) ) {
            $schema = 'https://';
        }

        $host = $_SERVER['HTTP_HOST'];

        // Prepare transaction
        $params = array();
        $params['language'] = $viewer->language;
        $localeParts = explode('_', $viewer->language);
        if( count($localeParts) > 1 ) {
            $params['region'] = $localeParts[1];
        }

        $params['vendor_order_id'] = $order_id;
        $params['return_url'] = $schema . $host
        .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'sescrowdfunding'), 'admin_default', true)
        . '/?state=' . 'return&order_id=' . $order_id;
        $params['cancel_url'] = $schema . $host
        .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'sescrowdfunding'), 'admin_default', true)
        . '/?state=' . 'cancel&order_id=' . $order_id;
        $params['ipn_url'] = $schema . $host
        .  $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'admin_default', true).'&order_id=' . $order_id;
        // Process transaction

        $transaction = $plugin->createOrderTransaction($item, $crowdfunding, $params);

        // Pull transaction params
        $this->view->transactionUrl = $transactionUrl = $gatewayPlugin->getGatewayUrl();
        $this->view->transactionMethod = $transactionMethod = $gatewayPlugin->getGatewayMethod();
        $this->view->transactionData = $transactionData = $transaction->getData();

        // Handle redirection
        if( $transactionMethod == 'GET' ) {
            $transactionUrl .= '?' . http_build_query($transactionData);
            return $this->_helper->redirector->gotoUrl($transactionUrl, array('prependBase' => false));
        }
        //Post will be handled by the view script
	}

	public function returnAction() {
		$session = new Zend_Session_Namespace();
        // Get order
		$orderId = $this->_getParam('order_id', null);
		$orderPaymentId = $session->sescrowdfunding_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);
        if(($this->_getParam('type', null) == "stripe") || $this->_getParam('type', null) == "paytm") {
              return $this->_finishPayment($session->status,$orderPayment->source_id);
        }
		$item_id = $session->sescrowdfunding_item_id ;
		$item = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $item_id);
    if (!$orderPayment || ($orderId != $orderPaymentId) || ($orderPayment->source_type != 'sescrowdfunding_userpayrequest') || !($user_order = $orderPayment->getSource()) ) {
           // return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }
		$gateway = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id'=>$user_order->owner_id));
		if( !$gateway )
            return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        // Get gateway plugin
        $plugin = $gateway->getPlugin();
        unset($session->errorMessage);
        try {
            //get all params
            $params = $this->_getAllParams();
            $status = $plugin->orderTransactionReturn($orderPayment, $params,$item);
        } catch (Payment_Model_Exception $e) {
            $status = 'failure';
            $session->errorMessage = $e->getMessage();
        }
    }

    protected function _finishPayment($state = 'active',$orderPaymentId) {

        $session = new Zend_Session_Namespace();
        // Clear session
        $errorMessage = $session->errorMessage;
        $session->errorMessage = $errorMessage;
        // Redirect
        if ($state == 'free') {
            return $this->_helper->redirector->gotoRoute(array(), 'default', true);
        } else {
            return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
        }
    }

    public function finishAction() {

        $session = new Zend_Session_Namespace();

        if (!empty($session->sescrowdfunding_order_id))
        $session->sescrowdfunding_order_id = '';

    // 		if(empty($session->sescrowdfunding_order_id))
    // 			return $this->_forward('notfound', 'error', 'core');

        $orderTrabsactionDetails = array('state' => $this->_getParam('state'), 'errorMessage' => $session->errorMessage);
        $session->sescrowdfunding_order_details = $orderTrabsactionDetails;
            $state = $this->_getParam('state');
        if(!$state)
            return $this->_forward('notfound', 'error', 'core');
        $this->view->error = $error =  $session->errorMessage;
        $session->unsetAll();
    }

	public function cancelAction() {

        $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $this->getRequest()->getParam('crowdfunding_id'));
        $paymnetReq = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->getRequest()->getParam('id'));

        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');

        // Make form
        $this->view->form = $form = new Sesbasic_Form_Delete();
        $form->setTitle('Reject Payment Request');
        $form->setDescription('Are you sure that you want to reject this payment request?');
        $form->submit->setLabel('Reject');

        if (!$paymnetReq) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to cancel");
            return;
        }

        if (!$this->getRequest()->isPost()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $db = $paymnetReq->getTable()->getAdapter();
        $db->beginTransaction();

        try {
            $paymnetReq->state = 'cancelled';
                    $paymnetReq->save();
            $db->commit();

            //Notification work
            $viewer = Engine_Api::_()->user()->getViewer();
            $owner = $crowdfunding->getOwner();
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $crowdfunding, 'sescrowdfunding_adminpaymentcancel', array());

            //Payment cancel mail send to crowdfunding owner
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'sescrowdfunding_payment_adminrequestcancel', array('crowdfunding_title' => $crowdfunding->title, 'object_link' => $crowdfunding->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment Request has been cancelled.');
        return $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array($this->view->message)
        ));
	}
}
