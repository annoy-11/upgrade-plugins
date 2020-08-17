<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPaymentController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_AdminPaymentController extends Core_Controller_Action_Admin {

  public function indexAction() {

      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'sesproduct_admin_main_manageorde');

      $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_manageorde', array(), 'sesproduct_admin_main_payreq');

      $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_payreq', array(), 'sesproduct_admin_main_patreqsub');
    //echo "<pre>";var_dump($this->view->subsubNavigation);die;
    $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_Filterpaymentorder();
		$values = array();
    if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
        $paymentTable = Engine_Api::_()->getItemTable('sesproduct_userpayrequest');
		$paymentTableName = $paymentTable->info('name');
		$sesproductTableName = Engine_Api::_()->getItemTable('stores')->info('name');
		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
        $select = $paymentTable->select()
            ->from($paymentTableName)
						->where('state =?','pending')
						->setIntegrityCheck(false)
						->joinLeft($sesproductTableName, "$paymentTableName.store_id = $sesproductTableName.store_id", 'title')
						->where($sesproductTableName.'.store_id !=?','')
						->joinLeft($tableUserName, "$paymentTableName.owner_id = $tableUserName.user_id", 'username')
            ->order('creation_date DESC');

		if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
		if (!empty($_GET['creation_date']))
      $select->where($paymentTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
		if (!empty($_GET['store']))
      $select->where($sesproductTableName . '.title LIKE ?', '%' . $_GET['store'] . '%');
		if (!empty($_GET['amount']))
      $select->where($paymentTableName . '.requested_amount LIKE ?', '%' . $_GET['amount'] . '%');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
	public function approveAction(){
    $viewer = Engine_Api::_()->user()->getViewer();
    $store_id = $this->getRequest()->getParam('store_id');
		$this->view->store = $store = Engine_Api::_()->getItem('stores', $this->getRequest()->getParam('store_id'));
	    $paymnetReq = Engine_Api::_()->getItem('sesproduct_userpayrequest', $this->getRequest()->getParam('id'));
		// In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
		$gateway_enable = Engine_Api::_()->getDbtable('usergateways', 'sesproduct')->getUserGateway(array('store_id'=>$store->store_id));
		if(empty($gateway_enable)){
			$this->view->disable_gateway = true;
        }else{
           $this->view->disable_gateway = false;
            // Make form
             $this->view->form = $form = new Sesproduct_Form_Admin_Payment_Approve(array('storeId'=>$store_id));
             $defaultCurrency = Engine_Api::_()->sesproduct()->defaultCurrency();
             $remainingAmount  =  Engine_Api::_()->getDbtable('remainingpayments', 'estore')->getStoreRemainingAmount(array('store_id'=>$store->store_id));
                $orderDetails  =  Engine_Api::_()->getDbtable('orders', 'sesproduct')->getProductStats(array('store_id'=>$store->store_id));
                $value = array();
                $value['total_amount'] = Engine_Api::_()->sesproduct()->getCurrencyPrice($orderDetails['total_amount'],$defaultCurrency);
                $value['total_shipping_amount'] = Engine_Api::_()->sesproduct()->getCurrencyPrice($orderDetails['total_shippingtax_cost'],$defaultCurrency);
                $value['total_admintax_amount'] = Engine_Api::_()->sesproduct()->getCurrencyPrice($orderDetails['total_admintax_cost'],$defaultCurrency);
                $value['total_tax_amount'] = Engine_Api::_()->sesproduct()->getCurrencyPrice($orderDetails['total_billingtax_cost'],$defaultCurrency);
                $value['total_commission_amount'] = Engine_Api::_()->sesproduct()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency);
                $value['remaining_amount'] = Engine_Api::_()->sesproduct()->getCurrencyPrice($remainingAmount->remaining_payment,$defaultCurrency);
                //set value to form
                if($this->_getParam('id',false)){
                        $item = Engine_Api::_()->getItem('sesproduct_userpayrequest', $this->_getParam('id'));
                        if($item){
                            $itemValue = $item->toArray();
                            $value = array_merge($itemValue,$value);
                            $value['requested_amount'] = Engine_Api::_()->sesproduct()->getCurrencyPrice($itemValue['requested_amount'],$defaultCurrency);
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
                $db = Engine_Api::_()->getDbtable('userpayrequests', 'sesproduct')->getAdapter();
                $db->beginTransaction();
                try{
                    $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'sesproduct');
                    $order = $item;
                    $order->release_amount = @round($_POST['release_amount'],2);
                    $order->admin_message = $_POST['admin_message'];
                    $order->release_date	 = date('Y-m-d h:i:s');
                    $order->save();

                    $db->commit();
                    if($_POST['gateway_type'] == "paypal") {
                        $session = new Zend_Session_Namespace();
                        $session->payment_request_id = $order->userpayrequest_id;
                        $this->view->status = true;
                        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Processing...');
                        return $this->_forward('success', 'utility', 'core', array(
                                    'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'sesproduct', 'controller' => 'payment', 'action' => 'process'),'admin_default',true),
                                    'messages' => array($this->view->message)
                        ));
                    } else if($_POST['gateway_type'] == "stripe") {
                        $session = new Zend_Session_Namespace("sesproduct_userpayrequest");
                        $session->payment_request_id = $order->userpayrequest_id;
                        return $this->_forward('success', 'utility', 'core', array(
                            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'sesadvpmnt', 'controller' => 'payment', 'action' => 'index','type'=>'sesproduct_userpayrequest'),'default',true),
                            'messages' => array($this->view->message)
                        ));
                    } else if($_POST['gateway_type'] == "paytm") {
                        $session = new Zend_Session_Namespace("sesproduct_userpayrequest");
                        $session->payment_request_id = $order->userpayrequest_id;
                        return $this->_forward('success', 'utility', 'core', array(
                            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'epaytm', 'controller' => 'payment', 'action' => 'index','type'=>'sesproduct_userpayrequest'),'default',true),
                            'messages' => array($this->view->message)
                        ));
                    }
                }catch (Exception $e) {

                    $db->rollBack();
                    throw $e;
                }
        }
	}
	public function processAction(){
        $session = new Zend_Session_Namespace();
        $viewer = Engine_Api::_()->user()->getViewer();
        if(!$session->payment_request_id)
            return $this->_forward('requireauth', 'error', 'core');

        $item = Engine_Api::_()->getItem('sesproduct_userpayrequest', $session->payment_request_id);
        $store = Engine_Api::_()->getItem('stores', $item->store_id);
        // Get gateway
        $gatewayId = $item->gateway_id;
            $gateway = Engine_Api::_()->getDbtable('usergateways', 'sesproduct')->getUserGateway(array('store_id'=>$store->store_id,'gateway_type'=>"paypal","enabled"=>true,'user_id'=>$store->owner_id));
            if( !$gatewayId ||
            !($gateway) ||
            !($gateway->enabled) ) {
           return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }
        $this->view->gateway = $gateway;
            $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway($gateway->plugin);
            $plugin = $gateway->getPlugin();
            $ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
        // Process
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->usergateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'sesproduct_userpayrequest',
            'source_id' => $item->userpayrequest_id,
        ));
        $session = new Zend_Session_Namespace();
        $session->sesproduct_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
        $session->sesproduct_item_id = $item->getIdentity();
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
          .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'sesproduct'), 'admin_default', true)
          . '/?state=' . 'return&order_id=' . $order_id;
        $params['cancel_url'] = $schema . $host
          .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'sesproduct'), 'admin_default', true)
          . '/?state=' . 'cancel&order_id=' . $order_id;
        $params['ipn_url'] = $schema . $host
          .  $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'admin_default', true).'&order_id=' . $order_id;
        // Process transaction

        $transaction = $plugin->createOrderTransaction($item,$store,$params);

        // Pull transaction params
        $this->view->transactionUrl = $transactionUrl = $gatewayPlugin->getGatewayUrl();
        $this->view->transactionMethod = $transactionMethod = $gatewayPlugin->getGatewayMethod();
        $this->view->transactionData = $transactionData = $transaction->getData();
        // Handle redirection
        if( $transactionMethod == 'GET' ) {
         $transactionUrl .= '?' . http_build_query($transactionData);
         return $this->_helper->redirector->gotoUrl($transactionUrl, array('prependBase' => false));
        }
        // Post will be handled by the view script
	}
	public function returnAction() {
		$session = new Zend_Session_Namespace();
    // Get order
		$orderId = $this->_getParam('order_id', null);
		$orderPaymentId = $session->sesproduct_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);
		if(($this->_getParam('type', null) == "stripe") || ($this->_getParam('type', null) == "paytm")){
                return $this->_finishPayment($session->status,$orderPayment->source_id);
		}
		$item_id = $session->sesproduct_item_id;
		$item = Engine_Api::_()->getItem('sesproduct_userpayrequest', $item_id);
        if (!$orderPayment || ($orderId != $orderPaymentId) ||
                ($orderPayment->source_type != 'sesproduct_userpayrequest') ||
                !($user_order = $orderPayment->getSource()) ) {
                return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }
		$gateway = Engine_Api::_()->getDbtable('usergateways', 'sesproduct')->getUserGateway(array('store_id'=>$user_order->store_id,'gateway_type'=>"paypal","enabled"=>true));
		if( !$gateway )
      return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    // Get gateway plugin
    $plugin = $gateway->getPlugin($gateway->plugin);
    unset($session->errorMessage);
    try {
     //get all params
      $params = $this->_getAllParams();
      $status = $plugin->orderTransactionReturn($orderPayment, $params,$item);
    } catch (Payment_Model_Exception $e) {
      $status = 'failure';
      $session->errorMessage = $e->getMessage();
    }
    return $this->_finishPayment($status,$orderPayment->source_id);
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
        //Notification work
        $order = Engine_Api::_()->getItem('sesproduct_userpayrequest',$orderPaymentId);
        $store = Engine_Api::_()->getItem('stores',$order->store_id);
        $viewer = Engine_Api::_()->user()->getViewer();
        $owner = $store->getOwner();
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $store, 'estore_approve_request', array());
        //Payment approve mail send to event owner
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->email, 'estore_approve_request', array('host' => $_SERVER['HTTP_HOST'], 'object_link' => $store->getHref()));
      return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
    }
  }
  public function finishAction() {
    $session = new Zend_Session_Namespace();
    if (!empty($session->sesproduct_order_id))
      $session->sesproduct_order_id = '';
    $orderTrabsactionDetails = array('state' => $this->_getParam('state'), 'errorMessage' => $session->errorMessage);
    $session->sesproduct_order_details = $orderTrabsactionDetails;
		$state = $this->_getParam('state');
	  if(!$state)
	 	 return $this->_forward('notfound', 'error', 'core');
		$this->view->error = $error =  $session->errorMessage;
		$session->unsetAll();
  }
	public function cancelAction(){
		$this->view->store = $store = Engine_Api::_()->getItem('stores', $this->getRequest()->getParam('store_id'));
	  $paymnetReq = Engine_Api::_()->getItem('sesproduct_userpayrequest', $this->getRequest()->getParam('id'));
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    // Make form
	   $this->view->form = $form = new Sesbasic_Form_Delete();
		 $form->setTitle('Reject Payment Request');
		 $form->setDescription('Are you sure that you want to reject this payment request?');
		 $form->submit->setLabel('Reject');
    if(!$paymnetReq) {
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
      $owner = $store->getOwner();
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $store, 'estore_cancel_request', array());
      //Payment cancel mail send to store owner
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'estore_cancel_request', array('store_title' => $store->title, 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
    public function managePaymentStoreOwnerAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'sesproduct_admin_main_manageorde');

        $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_manageorde', array(), 'sesproduct_admin_main_payreq');

        $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_payreq', array(), 'sesproduct_admin_main_paymade');

        $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_FilterPaymentStoreOwner();
        $values = array();
        if ($formFilter->isValid($this->_getAllParams()))
            $values = $formFilter->getValues();

        $values = array_merge(array('order' => $_GET['order'], 'order_direction' => $_GET['order_direction']), $values);

        $this->view->assign($values);

        $storeTableName = Engine_Api::_()->getItemTable('stores')->info('name');
        $ordersTable = Engine_Api::_()->getDbTable('userpayrequests', 'sesproduct');
        $ordersTableName = $ordersTable->info('name');

        $select = $ordersTable->select()
            ->setIntegrityCheck(false)
            ->from($ordersTableName)
            ->joinLeft($storeTableName, "$ordersTableName.store_id = $storeTableName.store_id", 'title')
            ->where($ordersTableName . '.state = ?', 'complete')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'userpayrequest_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

        if (!empty($_GET['name']))
            $select->where($storeTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

        if (!empty($_GET['creation_date']))
            $select->where($ordersTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
        if (!empty($_GET['gateway']))
            $select->where($ordersTableName . '.gateway_type LIKE ?', $_GET['gateway'] . '%');
        $paginator = Zend_Paginator::factory($select);
        $this->view->paginator = $paginator;
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    }

    public function viewPaymentrequestAction() {
        $this->view->item = Engine_Api::_()->getItem('sesproduct_userpayrequest', $this->_getParam('id', null));
    }
}
