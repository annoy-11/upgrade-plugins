<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: OrderController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_OrderController extends Core_Controller_Action_Standard {

  public function init()
  {
    // Get user and session
    $this->_user = Engine_Api::_()->user()->getViewer();
    $this->_session = new Zend_Session_Namespace();
	$this->_session->gateway_id = $this->_getParam('gateway_id',false);
		// Check viewer and user

    if( !$this->_user || !$this->_user->getIdentity() ) {
      if( !empty($this->_session->user_id) ) {
        $this->_user = Engine_Api::_()->getItem('user', $this->_session->user_id);
      }
    }
  }
  public function donateAction() {

    $this->view->crowdfunding_id = $crowdfunding_id = $this->_getParam('crowdfunding_id', null);
    $this->view->gateway_id = $gateway_id = $this->_getParam('gateway_id', null);
    if(empty($crowdfunding_id))
      return $this->_forward('requireauth', 'error', 'core');

    $this->_helper->content->setEnabled();

    $this->view->form = $form = new Sescrowdfunding_Form_Donate();

    //If not post or form not valid, return
    if(!$this->getRequest()->isPost())
      return;

    if(!$form->isValid($this->getRequest()->getPost()))
      return;
     $paymentGateways = Engine_Api::_()->sescrowdfunding()->checkPaymentGatewayEnable();
     if($paymentGateways['noPaymentGatewayEnableByAdmin']) {
      return;
    }
    //Check custom url
    if (empty($_POST['price'])) {
      $form->addError($this->view->translate("Please enter donation amount. Donation amount is requried."));
      return;
    }
    if (empty($_POST['gateway']) && isset($_POST['gateway'])) {
      $form->addError($this->view->translate("Please Select Payment Method. Payment Method is requried."));
      return;
    }
    if($_POST['payment_type'] == "stripe"){
     // Integration of Stripe Payment mathod using Advanced Payment plugin
        $table = Engine_Api::_()->getDbTable('gateways','payment');
        $select = $table->select()->where('plugin =?','Sesadvpmnt_Plugin_Gateway_Stripe')->where('enabled =?',1);
        $stripe = $table->fetchRow($select);
        $gateway_id = $stripe->getIdentity();
        $this->_session->gateway_id = $gateway_id;
        $this->_session->crowdfunding_id = $crowdfunding_id;
        return $this->_helper->redirector->gotoRoute(array('module' => 'sesadvpmnt', 'controller' => 'payment', 'action' => 'index', 'crowdfunding_id' => $crowdfunding_id, 'gateway_id' => $gateway_id, 'price' => $_POST['price'],'type'=>'crowdfunding'),'default',true);
    }else if($_POST['payment_type'] == "paypal"){
        //paypal
        $table = Engine_Api::_()->getDbTable('gateways','payment');
        $select = $table->select()->where('plugin =?','Payment_Plugin_Gateway_PayPal')->where('enabled =?',1);
        $paypal = $table->fetchRow($select);
        $gateway_id = $paypal->getIdentity();
        $this->_session->gateway_id = $gateway_id;
        $this->_session->crowdfunding_id = $crowdfunding_id;
        return $this->_helper->redirector->gotoRoute(array('module' => 'sescrowdfunding', 'controller' => 'order', 'action' => 'process', 'crowdfunding_id' => $crowdfunding_id, 'gateway_id' => $gateway_id, 'price' => $_POST['price']),'default',true);
    } else if($_POST['payment_type'] == "paytm"){
        //paypal
        $table = Engine_Api::_()->getDbTable('gateways','payment');
        $select = $table->select()->where('plugin =?','Epaytm_Plugin_Gateway_Paytm')->where('enabled =?',1);
        $paypal = $table->fetchRow($select);
        $gateway_id = $paypal->getIdentity();
        $this->_session->gateway_id = $gateway_id;
        $this->_session->crowdfunding_id = $crowdfunding_id;
        return $this->_helper->redirector->gotoRoute(array('module' => 'epaytm', 'controller' => 'payment', 'action' => 'index', 'crowdfunding_id' => $crowdfunding_id, 'gateway_id' => $gateway_id, 'price' => $_POST['price'],'type'=>'crowdfunding'),'default',true);
    }
    
  }
  public function processAction() {

    $gatewayId = $this->_getParam('gateway_id', null);

    $resource_id = $this->_getParam('crowdfunding_id', null);
    $price = $this->_getParam('price', 0.00);

    if(empty($price))
      return $this->_forward('requireauth', 'error', 'core');
		$resource = null;
    if ($resource_id) {
      $resource = Engine_Api::_()->getItem('crowdfunding', $resource_id);
      if ($resource) {
        $this->view->crowdfunding = $resource ;
      } else
				return $this->_forward('requireauth', 'error', 'core');
		}

		if(!$resource)
			return $this->_forward('requireauth', 'error', 'core');

    $resource = Engine_Api::_()->getItem('crowdfunding', $resource_id);

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $admin_commission = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sescrowdfunding', 'sescrowdfunding_commison'); //Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.commison', '5');

    $commison_amount = ($price * $admin_commission) / 100;
    $total_amount = $price + $commison_amount;

		$ordersTable = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding');

    $order = $ordersTable->createRow();
    $values = array(
      'crowdfunding_id' => $resource_id,
      'user_id' => $viewer_id,
      'gateway_id' => $gatewayId,
      'fname' => $viewer->displayname,
      'lname' => $viewer->displayname,
      'email' => $viewer->email,
      'commission_amount' => $commison_amount,
      'total_amount' => $total_amount,
      'total_useramount' => $price,
      'creation_date' => new Zend_Db_Expr('NOW()'),
    );

    $order->setFromArray($values);
    $order->save();
    $order_id = $order->order_id;

    if($order->state == 'complete')
			return $this->_forward('notfound', 'error', 'core');

    if( !$gatewayId || !($gateway = Engine_Api::_()->getItem('sescrowdfunding_gateway', $gatewayId)) || !($gateway->enabled) ) {
      header("location:".$this->view->escape($this->view->url(array('action' => 'checkout'))));
			die;
    }

    $this->view->gateway = $gateway;
    $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();

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

		$plugin = $gateway->getPlugin();
		$ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');

    // Process
    $ordersTable->insert(array(
      'user_id' => $viewer->getIdentity(),
      'gateway_id' => $gateway->gateway_id,
      'state' => 'pending',
      'creation_date' => new Zend_Db_Expr('NOW()'),
      'source_type' => 'sescrowdfunding_order',
      'source_id' => $order->order_id,
    ));

    $session = new Zend_Session_Namespace();
    $session->sescrowdfunding_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();

    $params['vendor_order_id'] = $order_id;
    $params['return_url'] = $schema . $host
      . $this->view->escape($this->view->url(array('action' => 'return', 'order_id' => $order_id)))
      . '/?state=' . 'return';

    $params['cancel_url'] = $this->view->escape($schema . $host
      . $this->view->url(array('action' => 'return')))
      . '/?state=' . 'cancel';
    $params['ipn_url'] = $schema . $host . $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'default') . '?order_id=' . $order_id.'&gateway_id='.$gatewayId;

		if ($gatewayId == 1) {
      $gatewayPlugin->createProduct(array_merge($order->getGatewayParams(),array('approved_url'=>$params['return_url'])));
		}

    // Process transaction
    $transaction = $plugin->createOrderTransaction($viewer, $order, $resource, $params);


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

		//if($order->state == 'complete')
			//return $this->_forward('notfound', 'error', 'core');

		$session = new Zend_Session_Namespace();
		$crowdfunding_id = $this->_getParam('crowdfunding_id', $this->_session->crowdfunding_id);
    //Get order
		$orderId = $this->_getParam('order_id', null);
		$orderPaymentId = $session->sescrowdfunding_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);

		$subsorderPayment = Engine_Api::_()->getItem('sescrowdfunding_order', $orderPayment->source_id);

    if (!$orderPayment || ($orderId != $orderPayment->getIdentity()) || ($orderPayment->source_type != 'sescrowdfunding_order') || !($user_order = $orderPayment->getSource())) {
      return $this->_helper->redirector->gotoRoute(array('crowdfunding_id' => $crowdfunding_id), 'sescrowdfunding_entry_view', true);
    }

    $gateway = Engine_Api::_()->getItem('sescrowdfunding_gateway', $orderPayment->gateway_id);

    if( !$gateway )
      return $this->_helper->redirector->gotoRoute(array(), 'user_profile', true);

    //Get gateway plugin
    $params = $this->_getAllParams();
    $plugin = $gateway->getPlugin();
    unset($session->errorMessage);
    try {

		  if($params['state'] != 'cancel') {
     		//get all params
      	$status = $plugin->orderResourceTransactionReturn($orderPayment, $params);
			} else {
				$status = 'cancel';
				$session->errorMessage = $this->view->translate('Your payment has been cancelled and not been charged. If this is not correct, please try again later.');
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
			$session->unsetAll();
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    } else {
			$url =  $this->view->escape($this->view->url(array('action' => 'finish', 'state' => $state)));
     header('location:'.$url);die;
    }
  }

  public function finishAction() {

    $session = new Zend_Session_Namespace();
    $orderTrabsactionDetails = array('state' => $this->_getParam('state'), 'errorMessage' => $session->errorMessage);
    $session->sessubscribeuser_order_details = $orderTrabsactionDetails;
		$url =  $this->view->escape($this->view->url(array('action' => 'success')));
    header('location:'.$url);die;

  }

	public function checkorderAction() {

		$order_id = $this->_getParam('order_id',null);
		$checkOrderStatus = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getOrderStatus($order_id);
		if($checkOrderStatus){
			echo json_encode(array('status'=>true));die;
		} else {
			echo json_encode(array('status'=>false));	die;
		}
	}

	public function successAction() {

		$session = new Zend_Session_Namespace();
		$order_id = $this->_getParam('order_id', null);
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $order = Engine_Api::_()->getItem('payment_order', $order_id);
    $order = Engine_Api::_()->getItem('sescrowdfunding_order', $order->source_id);

		if (!$order || $order->user_id != $viewer->getIdentity())
      return $this->_forward('notfound', 'error', 'core');

		if(!$order_id)
			return $this->_forward('notfound', 'error', 'core');

		$resource_id = $this->_getParam('crowdfunding_id', null);
		$resource = null;
    if ($resource_id) {
      $resource = Engine_Api::_()->getItem('crowdfunding', $resource_id);
      if ($resource) {
     	 $this->view->resource = $resource ;
      } else
				return $this->_forward('notfound', 'error', 'core');
		}
		if(!$resource)
			return $this->_forward('notfound', 'error', 'core');

		$state = $this->_getParam('state');
	  if(!$state)
	 	 return $this->_forward('notfound', 'error', 'core');
		$this->view->error = $error =  $session->errorMessage;
		$session->unsetAll();
		$this->view->state = $state;
   //return $this->_helper->redirector->gotoRoute(array('id' => $user->getIdentity()), 'user_profile', true);
	}
}
