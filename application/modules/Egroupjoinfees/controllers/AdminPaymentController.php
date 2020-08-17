<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPaymentController.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Egroupjoinfees_AdminPaymentController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroup_admin_main', array(), 'egroupjoinfees_admin_main');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('egroupjoinfees_admin_main', array(), 'egroupjoinfees_admin_main_paymentrequest');
    $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('egroupjoinfees_admin_main_paymentrequest', array(), 'egroupjoinfees_admin_main_paymentrequestsub');
    $this->view->formFilter = $formFilter = new Egroupjoinfees_Form_Admin_Filterpaymentorder();
		$values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();
    $paymentTable = Engine_Api::_()->getItemTable('egroupjoinfees_userpayrequest');
		$paymentTableName = $paymentTable->info('name');
		$groupTableName = Engine_Api::_()->getItemTable('sesgroup_group')->info('name');
		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $paymentTable->select()
            ->from($paymentTableName)
						->where('state =?','pending')
						->setIntegrityCheck(false)
						->joinLeft($groupTableName, "$paymentTableName.group_id = $groupTableName.group_id", 'title')
						->where($groupTableName.'.group_id !=?','')
						->joinLeft($tableUserName, "$paymentTableName.owner_id = $tableUserName.user_id", 'username')
            ->order('creation_date DESC');
		
		if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
		if (!empty($_GET['creation_date']))
      $select->where($paymentTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
		if (!empty($_GET['group']))
      $select->where($groupTableName . '.title LIKE ?', '%' . $_GET['group'] . '%');
		if (!empty($_GET['amount']))
      $select->where($paymentTableName . '.requested_amount LIKE ?', '%' . $_GET['amount'] . '%');
		
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
	public function approveAction(){    
		$this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $this->getRequest()->getParam('group_id'));
	  $paymnetReq = Engine_Api::_()->getItem('egroupjoinfees_userpayrequest', $this->getRequest()->getParam('id'));  
		// In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
		$gateway_enable = Engine_Api::_()->getDbtable('usergateways', 'egroupjoinfees')->getUserGateway(array('group_id'=>$group->group_id));
		if(empty($gateway_enable)){
			$this->view->disable_gateway = true;		
    }else{
        $this->view->disable_gateway = false;	
        // Make form
      $this->view->form = $form = new Egroupjoinfees_Form_Admin_Payment_Approve(array('groupId'=>$group->group_id));
      $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency();
      $remainingAmount  =  Engine_Api::_()->getDbtable('remainingpayments', 'egroupjoinfees')->getGroupRemainingAmount(array('group_id'=>$group->group_id));
        $orderDetails  =  Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getContestStats(array('group_id'=>$group->group_id));
        $value = array();
        $value['total_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($orderDetails['totalAmountSale'],$defaultCurrency);
        $value['total_tax_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($orderDetails['totalTaxAmount'],$defaultCurrency);
        $value['total_commission_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency);
        $value['remaining_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($remainingAmount->remaining_payment,$defaultCurrency);
        //set value to form
        if($this->_getParam('id',false)){
            $item = Engine_Api::_()->getItem('egroupjoinfees_userpayrequest', $this->_getParam('id'));
            if($item){
              $itemValue = $item->toArray();
              $value = array_merge($itemValue,$value);
              $value['requested_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($itemValue['requested_amount'],$defaultCurrency);
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
        $db = Engine_Api::_()->getDbtable('userpayrequests', 'egroupjoinfees')->getAdapter();
        $db->beginTransaction();
        try{
          $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'egroupjoinfees');
          $order = $item;
          $order->release_amount = @round($_POST['release_amount'],2);
          $order->admin_message = $_POST['admin_message'];
          $order->release_date	 = date('Y-m-d h:i:s');
          $order->save();
          //Notification work
          $viewer = Engine_Api::_()->user()->getViewer();
          $owner = $group->getOwner();
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $group, 'egroupjoinfees_adminpayaprov', array());
          //Payment approve mail send to event owner
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'egroupjoinfees_payment_adminrequestapproved', array('group_title' => $group->title, 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          $db->commit();
          $session = new Zend_Session_Namespace();
          $session->payment_request_id = $order->userpayrequest_id;
          $this->view->status = true;
          $this->view->message = Zend_Registry::get('Zend_Translate')->_('Processing...');
          return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'egroupjoinfees', 'controller' => 'payment', 'action' => 'process','gateway_id'=>$_POST['gateway_id']),'admin_default',true),
                'messages' => array($this->view->message)
          ));		
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
		$item = Engine_Api::_()->getItem('egroupjoinfees_userpayrequest', $session->payment_request_id);
		$group = Engine_Api::_()->getItem('sesgroup_group', $item->group_id);
    // Get gateway
    $gatewayId = $this->_getParam('gateway_id', null); 
		$gateway = Engine_Api::_()->getItem('egroupjoinfees_usergateway',$gatewayId);
		if( !$gatewayId ||
        !($gateway) ||
        !($gateway->enabled) ) {
       return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }
    $this->view->gateway = $gateway;
		$this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
		$plugin = $gateway->getPlugin();
		$ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
    // Process
    $ordersTable->insert(array(
        'user_id' => $viewer->getIdentity(),
        'gateway_id' => $gateway->usergateway_id,
        'state' => 'pending',
        'creation_date' => new Zend_Db_Expr('NOW()'),
        'source_type' => 'egroupjoinfees_userpayrequest',
        'source_id' => $item->userpayrequest_id,
    ));
		$session = new Zend_Session_Namespace();
    $session->egroupjoinfees_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId(); 
		$session->egroupjoinfees_item_id = $item->getIdentity();    
    // Prepare host info
    $schema = 'http://';
    if( !empty($_ENV["HTTPS"]) && 'on' == strtolower($_ENV["HTTPS"])){
      $schema = 'https://';
    }
    $host = $_SERVER['HTTP_HOST'];
    //Prepare transaction
    $params = array();
    $params['language'] = $viewer->language;
    $localeParts = explode('_', $viewer->language);
		if(count($localeParts) > 1){
			$params['region'] = $localeParts[1];
		}
    $params['vendor_order_id'] = $order_id;
    $params['return_url'] = $schema . $host
      .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'egroupjoinfees'), 'admin_default', true)
      . '/?state=' . 'return&order_id=' . $order_id;
    $params['cancel_url'] = $schema . $host
      .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'egroupjoinfees'), 'admin_default', true)
      . '/?state=' . 'cancel&order_id=' . $order_id;
    $params['ipn_url'] = $schema . $host
      .  $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'admin_default', true).'&order_id=' . $order_id;
    // Process transaction
    if($gateway->plugin == "Egroupjoinfees_Plugin_Gateway_Group_Stripe") {
        $this->view->currency =  Engine_Api::_()->egroupjoinfees()->defaultCurrency(); 
        $this->view->publishKey = $publishKey = $gateway->config['sesadvpmnt_stripe_publish']; 
        $this->view->title = $title = $gateway->config['sesadvpmnt_stripe_title'];
        $this->view->description = $description = $gateway->config['sesadvpmnt_stripe_description'];
        $this->view->logo = $logo = $gateway->config['sesadvpmnt_stripe_logo'];
        $this->view->returnUrl = $params['return_url'];
        $this->view->amount = $item->release_amount;
        $this->renderScript('/application/modules/Sesadvpmnt/views/scripts/payment/index.tpl');
    } elseif($gateway->plugin  == "Egroupjoinfees_Plugin_Gateway_Group_Paytm") {
        $paytmParams = $plugin->createOrderTransaction($item,$group,$params);
        $secretKey  = $gateway->config['paytm_secret_key'];
        $this->view->paytmParams = $paytmParams;
        $this->view->checksum = getChecksumFromArray($paytmParams, $secretKey);
        if($gateway->test_mode){
          $this->view->url = "https://securegw-stage.paytm.in/order/process";
        } else {
          $this->view->url = "https://securegw.paytm.in/merchant-status/getTxnStatus";
        }
         $this->renderScript('/application/modules/Epaytm/views/scripts/payment/index.tpl');
    } else {
        $transaction = $plugin->createOrderTransaction($item,$group,$params);	
        // Pull transaction params
        $this->view->transactionUrl = $transactionUrl = $gatewayPlugin->getGatewayUrl();
        $this->view->transactionMethod = $transactionMethod = $gatewayPlugin->getGatewayMethod();
        $this->view->transactionData = $transactionData = $transaction->getData();
    }
    // Handle redirection
    if($transactionMethod == 'GET'){
     $transactionUrl .= '?' . http_build_query($transactionData);
     return $this->_helper->redirector->gotoUrl($transactionUrl, array('prependBase' => false));
    }
    // Post will be handled by the view script
	}
	public function returnAction() {
		$session = new Zend_Session_Namespace();
    // Get order
		$orderId = $this->_getParam('order_id', null);
		$orderPaymentId = $session->egroupjoinfees_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);
		$item_id = $session->egroupjoinfees_item_id ;
		$item = Engine_Api::_()->getItem('egroupjoinfees_userpayrequest', $item_id);
    if (!$orderPayment || ($orderId != $orderPaymentId) ||
			 ($orderPayment->source_type != 'egroupjoinfees_userpayrequest') ||
			 !($user_order = $orderPayment->getSource()) ) {
			return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }
    $gateway = Engine_Api::_()->getItem('egroupjoinfees_usergateway', $orderPayment->gateway_id); 
		if( !$gateway )
      return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    // Get gateway plugin
    $plugin = $gateway->getPlugin();
    unset($session->errorMessage);
    try {
      // Stripe plugin Integration work

      if($gateway->plugin == "Egroupjoinfees_Plugin_Gateway_Group_Stripe") {
         $group = Engine_Api::_()->getItem('group', $item->group_id);
          if(isset($_POST['stripeToken'])){
            $params['token'] = $_POST['stripeToken'];
            $params['order_id'] = $orderPaymentId;
            $params['type'] = "egroupjoinfees_userpayrequest";
            $params['amount'] = @round($item->release_amount, 2);
            $params['description'] = $item->admin_message; 
            $params['gateway_id'] = $item->gateway_id;
            $params['currency'] = Engine_Api::_()->egroupjoinfees()->defaultCurrency();
            $transaction = $plugin->createOrderTransaction($params);
          } 
         $status = $plugin->orderTransactionReturn($orderPayment,$transaction);
      } else {
         //get all params 
        $params = $this->_getAllParams();
        $status = $plugin->orderTransactionReturn($orderPayment, $params,$item);
      }
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
			 return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
    }
  }
  public function finishAction() {
    $session = new Zend_Session_Namespace();
    if (!empty($session->egroupjoinfees_order_id))
      $session->egroupjoinfees_order_id = '';
		
    $orderTrabsactionDetails = array('state' => $this->_getParam('state'), 'errorMessage' => $session->errorMessage);
    $session->egroupjoinfees_order_details = $orderTrabsactionDetails;
		$state = $this->_getParam('state');
	  if(!$state)
	 	 return $this->_forward('notfound', 'error', 'core');
		$this->view->error = $error =  $session->errorMessage;
		$session->unsetAll();
  } 
	public function cancelAction(){
		$this->view->event = $group = Engine_Api::_()->getItem('group', $this->getRequest()->getParam('group_id'));
	  $paymnetReq = Engine_Api::_()->getItem('egroupjoinfees_userpayrequest', $this->getRequest()->getParam('id'));  

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
			$owner = $group->getOwner();
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $group, 'egroupjoinfees_adminpaycancl', array());
      //Payment cancel mail send to group owner
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'egroupjoinfees_payment_adminrequestcancel', array('group_title' => $group->title, 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
