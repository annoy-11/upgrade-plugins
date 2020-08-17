<?php

class Sessubscribeuser_OrderController extends Core_Controller_Action_Standard {

  public function processAction() {

    $gatewayId = $this->_getParam('gateway_id', null);

    $package_id = $this->_getParam('package_id', null);
    $package = Engine_Api::_()->getItem('sessubscribeuser_package', $package_id);
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    
    $user_id = $this->_getParam('user_id', null);
    
		$user = null;
    if ($user_id) {
      $user = Engine_Api::_()->getItem('user', $user_id);
      if ($user) {
        $this->view->user = $user ;
      } else
				return $this->_forward('requireauth', 'error', 'core');	
		}
		
		if(!$user)
			return $this->_forward('requireauth', 'error', 'core');

    $commission_percentage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessubscribeuser.commison', '5');
    
    $commison_amount = ($package->price * $commission_percentage) / 100;
    $total_amount = $package->price + $commison_amount;
    
		$sessubscribeuserordersTable = Engine_Api::_()->getDbtable('orders', 'sessubscribeuser');
    
    $subscriberOrder = $sessubscribeuserordersTable->createRow();
    $values = array(
      'subject_id' => $user_id,
      'user_id' => $viewer_id,
      'gateway_id' => $gatewayId,
      'fname' => $viewer->displayname,
      'lname' => $viewer->displayname,
      'email' => $viewer->email,
      'commission_amount' => $commison_amount,
      'total_amount' => $total_amount,
      'total_useramount' => $package->price,
      'creation_date' => new Zend_Db_Expr('NOW()'),
    );
    
    $subscriberOrder->setFromArray($values);
    $subscriberOrder->save();
    $order_id = $subscriberOrder->order_id; 

		if($subscriberOrder->state == 'complete')
			return $this->_forward('notfound', 'error', 'core');

    if( !$gatewayId || !($gateway = Engine_Api::_()->getItem('sessubscribeuser_gateway', $gatewayId)) || !($gateway->enabled) ) {
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
      'source_type' => 'sessubscribeuser_order',
      'source_id' => $subscriberOrder->order_id,
    ));
    
		$session = new Zend_Session_Namespace();
    $session->sessubscribeuser_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
		
    $params['vendor_order_id'] = $order_id;
    $params['return_url'] = $schema . $host
      . $this->view->escape($this->view->url(array('action' => 'return', 'order_id' => $order_id)))
      . '/?state=' . 'return';

    $params['cancel_url'] = $this->view->escape($schema . $host
      . $this->view->url(array('action' => 'return')))
      . '/?state=' . 'cancel';
    $params['ipn_url'] = $schema . $host . $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'default') . '?order_id=' . $order_id.'&gateway_id='.$gatewayId;
      
		if ($gatewayId == 1) {
      $gatewayPlugin->createProduct(array_merge($subscriberOrder->getGatewayParams(),array('approved_url'=>$params['return_url'])));
		}

    // Process transaction
    $transaction = $plugin->createOrderTransaction($viewer,$subscriberOrder,$user,$params, $package);
    
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
		$user_id = $this->_getParam('user_id', null); //echo $user_id;die;
    //Get order
		$orderId = $this->_getParam('order_id', null);
		$orderPaymentId = $session->sessubscribeuser_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);

		$subsorderPayment = Engine_Api::_()->getItem('sessubscribeuser_order', $orderPayment->source_type);
    if (!$orderPayment || ($orderId != $orderPayment->getIdentity()) || ($orderPayment->source_type != 'sessubscribeuser_order') || !($user_order = $orderPayment->getSource())) {
      return $this->_helper->redirector->gotoRoute(array('id' => $user_id), 'user_profile', true);
    }

    $gateway = Engine_Api::_()->getItem('sessubscribeuser_gateway', $orderPayment->gateway_id); 

    if( !$gateway )
      return $this->_helper->redirector->gotoRoute(array(), 'user_profile', true);
      
    //Get gateway plugin
		$params = $this->_getAllParams();  
    $plugin = $gateway->getPlugin();
    unset($session->errorMessage);
    try {
			
		  if($params['state'] != 'cancel') {
     		//get all params 
      	$status = $plugin->orderSubcriberTransactionReturn($orderPayment, $params);
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
		$checkOrderStatus = Engine_Api::_()->getDbtable('orders', 'sessubscribeuser')->getOrderStatus($order_id);
		if($checkOrderStatus){
			echo json_encode(array('status'=>true));die;
		}else{
			echo json_encode(array('status'=>false));	die;
		}
		
	}
	
	public function successAction() {
	
		$session = new Zend_Session_Namespace();
		$order_id = $this->_getParam('order_id', null);
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();	
    $order = Engine_Api::_()->getItem('payment_order', $order_id);
    $order = Engine_Api::_()->getItem('sessubscribeuser_order', $order->source_id);
		if (!$order || $order->user_id != $viewer->getIdentity())
      return $this->_forward('notfound', 'error', 'core');
		if(!$order_id)
			return $this->_forward('notfound', 'error', 'core');

		$id = $this->_getParam('user_id', null);
		$user = null;
    if ($id) {
      $user = Engine_Api::_()->getItem('user', $id);
      if ($user) {
     	 $this->view->user = $user ;
      } else
				return $this->_forward('notfound', 'error', 'core');	
		}
		if(!$user)
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
