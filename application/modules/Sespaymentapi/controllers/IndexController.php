<?php

class Sespaymentapi_IndexController extends Core_Controller_Action_Standard
{
  
  public function init() {
    // Set up require's
    $this->_helper->requireUser();
  }
  
  //get user account details
  public function accountDetailsAction() {

    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings');
    
    $viewer = Engine_Api::_()->user()->getViewer();

    $userGateway = Engine_Api::_()->getDbtable('usergateways', 'sespaymentapi')->getUserGateway(array('user_id' => $viewer->getIdentity(),'enabled' => true));
    
		$settings = Engine_Api::_()->getApi('settings', 'core');
    $userGatewayEnable = 'paypal';
		$this->view->form = $form = new Sespaymentapi_Form_PayPal();
		$gatewayTitle = 'Paypal';
		$gatewayClass= 'Sespaymentapi_Plugin_Gateway_PayPal';
		
    if (count($userGateway)) {
      $form->populate($userGateway->toArray());
      if (is_array($userGateway['config'])) {
        $form->populate($userGateway['config']);
      }
    }
    
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    // Process
    $values = $form->getValues(); 
    $enabled = (bool) $values['enabled'];
    unset($values['enabled']);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $userGatewayTable = Engine_Api::_()->getDbtable('usergateways', 'sespaymentapi');
    // insert data to table if not exists
    try {
      if (!count($userGateway)) {
        $gatewayObject = $userGatewayTable->createRow();
        $gatewayObject->user_id = $viewer->getIdentity();
        $gatewayObject->title = $gatewayTitle;
        $gatewayObject->plugin = $gatewayClass;
        $gatewayObject->save();
      } else {
        $gatewayObject = Engine_Api::_()->getItem("sespaymentapi_usergateway", $userGateway['usergateway_id']);
      }
      $db->commit();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    // Validate gateway config
    if ($enabled) {
      $gatewayObjectObj = $gatewayObject->getGateway();
      try {
        $gatewayObjectObj->setConfig($values);
        $response = $gatewayObjectObj->test();
      } catch (Exception $e) {
        $enabled = false;
        $form->populate(array('enabled' => false));
        $form->addError(sprintf('Gateway login failed. Please double check ' .
                        'your connection information. The gateway has been disabled. ' .
                        'The message was: [%2$d] %1$s', $e->getMessage(), $e->getCode()));
      }
    } else {
      $form->addError('Gateway is currently disabled.');
    }
    // Process
    $message = null;
    try {
      $values = $gatewayObject->getPlugin()->processAdminGatewayForm($values);
    } catch (Exception $e) {
      $message = $e->getMessage();
      $values = null;
    }
    if (null !== $values) {
      $gatewayObject->setFromArray(array(
          'enabled' => $enabled,
          'config' => $values,
      ));
      $gatewayObject->save();
      $form->addNotice('Changes saved.');
    } else {
      $form->addError($message);
    }
  }
  
  public function manageTransactionsAction() {
  
    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings');
    
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    
//     if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $event->isOwner($viewer)))
//       return;
  }
  
  public function manageOrdersAction() {
  
    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings');
  
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    
//     if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $event->isOwner($viewer)))
//       return;
  }
  
  
  //get payment to admin information
  public function paymentRequestsAction() {
  
    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings');
    
    //Set up navigation
    $this->view->subnavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings_paymenrredeem');
    
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    
    //$this->view->event = $event = Engine_Api::_()->core()->getSubject();
    
//     if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $event->isOwner($viewer)))
//       return;
      
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    
    $this->view->thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'sesmembersubscription', 'sesmembersubscription_threshold_amount');

    //get total amount of ticket sold in given
		$this->view->userGateway = Engine_Api::_()->getDbtable('usergateways', 'sespaymentapi')->getUserGateway(array('user_id' => $viewer->user_id));
		
    $this->view->orderDetails = Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->getOrderStats(array('resource_id' => $viewer->getIdentity(), 'resource_type' => $viewer->getType()));
    
    //get ramaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'sespaymentapi')->getRemainingAmount(array('user_id' => $viewer->getIdentity(), 'resource_id' => $viewer->getIdentity(), 'resource_type' => $viewer->getType()));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else
      $this->view->remainingAmount = $remainingAmount->remaining_payment;
      
		$this->view->isAlreadyRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sespaymentapi')->getPaymentRequests(array('resource_id' => $viewer->getIdentity(), 'resource_type' => $viewer->getType(), 'isPending'=>true));
		
    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sespaymentapi')->getPaymentRequests(array('resource_id' => $viewer->getIdentity(), 'resource_type' => $viewer->getType(), 'isPending'=>true));
  }
  
  public function paymentRequestAction() {
  
    //$this->view->event = $event = Engine_Api::_()->core()->getSubject();
    
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    
//     if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $event->isOwner($viewer)))
//       return;

    $this->view->thresholdAmount = $thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'sesmembersubscription', 'sesmembersubscription_threshold_amount');
    
    //get remaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'sespaymentapi')->getRemainingAmount(array('user_id' => $viewer->getIdentity(), 'resource_id' => $viewer->getIdentity(), 'resource_type' => $viewer->getType()));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else {
      $this->view->remainingAmount = $remainingAmount->remaining_payment;
    }
    
    $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency();
    
    $orderDetails = Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->getOrderStats(array('resource_id' => $viewer->getIdentity(), 'resource_type' => $viewer->getType()));
    
    $this->view->form = $form = new Sespaymentapi_Form_Paymentrequest();
    $value = array();
    $value['total_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($orderDetails['totalAmountSale'], $defaultCurrency);
    //$value['total_tax_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($orderDetails['totalTaxAmount'], $defaultCurrency);
    $value['total_commission_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($orderDetails['commission_amount'], $defaultCurrency);
    $value['remaining_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($remainingAmount->remaining_payment, $defaultCurrency);
    $value['requested_amount'] = round($remainingAmount->remaining_payment,2);
    
    //set value to form
    if ($this->_getParam('id', false)) {
    
      $item = Engine_Api::_()->getItem('sespaymentapi_userpayrequest', $this->_getParam('id'));
      if ($item) {
        $itemValue = $item->toArray();
        //unset($value['requested_amount']);
        $value = array_merge($itemValue, $value);
      } else {
        return $this->_forward('requireauth', 'error', 'core');
      }
    }
    
    if (empty($_POST))
      $form->populate($value);

    if (!$this->getRequest()->isPost())
      return;
      
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
      
    if (@round($thresholdAmount,2) > @round($remainingAmount->remaining_payment,2) && empty($_POST)) {
      $this->view->message = 'Remaining amount is less than Threshold amount.';
      $this->view->errorMessage = true;
      return;
    } else if (isset($_POST['requested_amount']) && @round($_POST['requested_amount'],2) > @round($remainingAmount->remaining_payment,2)) {
      $form->addError('Requested amount must be less than or equal to remaining amount.');
      return;
    } else if (isset($_POST['requested_amount']) && @round($thresholdAmount) > @round($_POST['requested_amount'],2)) {
      $form->addError('Requested amount must be greater than or equal to threshold amount.');
      return;
    }

    $db = Engine_Api::_()->getDbtable('userpayrequests', 'sespaymentapi')->getAdapter();
    $db->beginTransaction();
    try {
      $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'sespaymentapi');
      if (isset($itemValue))
        $order = $item;
      else
        $order = $tableOrder->createRow();
      $order->requested_amount = round($_POST['requested_amount'],2);
      $order->user_message = $_POST['user_message'];
      $order->resource_id = $viewer->getIdentity();
      $order->resource_type = $viewer->getType();
      $order->owner_id = $viewer->getIdentity();
      $order->user_message = $_POST['user_message'];
      $order->creation_date = date('Y-m-d h:i:s');
      $order->currency_symbol = $defaultCurrency;
			$settings = Engine_Api::_()->getApi('settings', 'core');
   	  $userGatewayEnable = 'paypal'; //$settings->getSetting('sesevent.userGateway', 'paypal');
      $order->save();
      $db->commit();
      
      //Notification work
			$owner_admin = Engine_Api::_()->getItem('user', 1);
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner_admin, $viewer, $viewer, 'user_paymentrequest', array('requestAmount' => round($_POST['requested_amount'],2)));
			
			//Payment request mail send to admin
			$event_owner = Engine_Api::_()->getItem('user', $viewer->getIdentity());
			//Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner_admin, 'sesevent_ticketpayment_requestadmin', array('event_title' => $event->title, 'object_link' => $event->getHref(), 'event_owner' => $event_owner->getTitle(), 'host' => $_SERVER['HTTP_HOST']));
			
      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment request send successfully.');
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array($this->view->message)
      ));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }
  

  //get paymnet detail
  public function detailPaymentAction() {
  
    //$this->view->event = $event = Engine_Api::_()->core()->getSubject();
    
    $this->view->item = $paymnetReq = Engine_Api::_()->getItem('sespaymentapi_userpayrequest', $this->getRequest()->getParam('id'));
    
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    
//     if (!$this->_helper->requireAuth()->setAuthParams($event, null, 'edit')->isValid())
//       return;

    if (!$paymnetReq) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
      return;
    }
  }
  
  //delete payment request
  public function deletePaymentRequestAction() {

    //$this->view->event = $event = Engine_Api::_()->core()->getSubject();
    $paymnetReq = Engine_Api::_()->getItem('sespaymentapi_userpayrequest', $this->getRequest()->getParam('id'));
		
    $viewer = Engine_Api::_()->user()->getViewer();
    
//     if (!$this->_helper->requireAuth()->setAuthParams($event, null, 'delete')->isValid())
//       return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Make form
    $this->view->form = $form = new Sesbasic_Form_Delete();
    $form->setTitle('Delete Payment Request?');
    $form->setDescription('Are you sure that you want to delete this payment request? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if (!$paymnetReq) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
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
      $paymnetReq->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment Request has been deleted.');
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array($this->view->message)
    ));
  }
  
  public function paymentTransactionAction() {
  
      //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings');
    
    //Set up navigation
    $this->view->subnavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings_paymenrredeem');
    
    //$this->view->event = $event = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

//     if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $event->isOwner($viewer)))
//       return;

    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sespaymentapi')->getPaymentRequests(array('resource_id' => $viewer->getIdentity(), 'resource_type' => $viewer->getType(), 'state' => 'complete'));
  }
  
  public function cancelProfileAction() {
  
    $transaction_id = $this->_getParam('transaction_id', null);
    $transaction = Engine_Api::_()->getItem('sespaymentapi_transaction', $transaction_id);
    
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sespaymentapi_Form_Delete();
    $form->setTitle('Cancel Subscription');
    $form->setDescription('Are you sure that you want to cancel subscription for this user?');
    $form->submit->setLabel('Cancel');
		 
		 
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    
    $db = $transaction->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $transaction->cancel();      
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('You have successfully cancel subscription for this user.');
    return $this->_forward('success' ,'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array($this->view->message)
    ));
  }
  
  
  public function refundRequestAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    
//     if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $event->isOwner($viewer)))
//       return;

    $transaction_id = $this->_getParam('transaction_id', null);
    if(empty($transaction_id))
      return;

    $transaction = Engine_Api::_()->getItem('sespaymentapi_transaction', $transaction_id);
    
    $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency();

    $this->view->form = $form = new Sespaymentapi_Form_Refundrequest();
    
    $value = array();
    $value['total_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($transaction->amount, $defaultCurrency);
    
    //set value to form
    if ($this->_getParam('id', false)) {
    
      $item = Engine_Api::_()->getItem('sespaymentapi_requestrequest', $this->_getParam('id'));
      if ($item) {
        $itemValue = $item->toArray();
        //unset($value['requested_amount']);
        $value = array_merge($itemValue, $value);
      } else {
        return $this->_forward('requireauth', 'error', 'core');
      }
    }

    if (empty($_POST))
      $form->populate($value);

    if (!$this->getRequest()->isPost())
      return;
      
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $db = Engine_Api::_()->getDbtable('refundrequests', 'sespaymentapi')->getAdapter();
    $db->beginTransaction();
    try {
      $tableOrder = Engine_Api::_()->getDbtable('refundrequests', 'sespaymentapi');
      if (isset($itemValue))
        $order = $item;
      else
        $order = $tableOrder->createRow();
      $order->total_amount = round($value['total_amount'],2);
      $order->user_message = $_POST['user_message'];
      $order->transaction_id = $transaction->getIdentity();
      $order->user_id = $viewer->getIdentity();
      $order->creation_date = date('Y-m-d h:i:s');
      $order->currency_symbol = $defaultCurrency;
			$settings = Engine_Api::_()->getApi('settings', 'core');
   	  $userGatewayEnable = 'paypal'; //$settings->getSetting('sesevent.userGateway', 'paypal');
      $order->save();
      $db->commit();
      
      //Notification work
			$owner_admin = Engine_Api::_()->getItem('user', 1);
			//Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner_admin, $viewer, $viewer, 'user_paymentrequest', array('requestAmount' => round($_POST['requested_amount'],2)));
			
			//Payment request mail send to admin
			$event_owner = Engine_Api::_()->getItem('user', $viewer->getIdentity());
			//Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner_admin, 'sesevent_ticketpayment_requestadmin', array('event_title' => $event->title, 'object_link' => $event->getHref(), 'event_owner' => $event_owner->getTitle(), 'host' => $_SERVER['HTTP_HOST']));
			
      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Refund request send successfully.');
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array($this->view->message)
      ));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }
  
}