<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespaymentapi
 * @package    Sespaymentapi
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPaymentController.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespaymentapi_AdminRefundController extends Core_Controller_Action_Admin {

  public function indexAction() {
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_admin_main', array(), 'sespaymentapi_admin_main_managerefunds');
    
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_admin_main_managerefunds', array(), 'sespaymentapi_admin_main_refundrequests');

    $this->view->formFilter = $formFilter = new Sespaymentapi_Form_Admin_FilterRefundRequests();
    
		$values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();
      
    $refundTable = Engine_Api::_()->getItemTable('sespaymentapi_refundrequest');
		$refundTableName = $refundTable->info('name');
		
		$userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		
		//$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
		
    $select = $refundTable->select()
            ->from($refundTableName)
						->where('state =?','pending')
						->setIntegrityCheck(false)
						->joinLeft($userTableName, "$refundTableName.user_id = $userTableName.user_id", null)
						//->joinLeft($tableUserName, "$refundTableName.owner_id = $tableUserName.user_id", 'username')
            ->order('creation_date DESC');
		
		if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
      
		if (!empty($_GET['creation_date']))
      $select->where($refundTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
      
		if (!empty($_GET['amount']))
      $select->where($refundTableName . '.total_amount LIKE ?', '%' . $_GET['amount'] . '%');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  
  
	public function approveAction() {
	
    $resource = Engine_Api::_()->getItem('user', $this->getRequest()->getParam('user_id'));
    
    //$transaction = Engine_Api::_()->getItem('sespaymentapi_transaction', $this->getRequest()->getParam('transaction_id'));
    
    $refundReq = Engine_Api::_()->getItem('sespaymentapi_refundrequest', $this->getRequest()->getParam('id'));
    
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $gateway_enable = Engine_Api::_()->getDbtable('usergateways', 'sespaymentapi')->getUserGateway(array('user_id' => $this->getRequest()->getParam('user_id')));
    
    if(empty($gateway_enable)) {
      $this->view->disable_gateway = true;
    } else {
      $this->view->disable_gateway = false;
    
      // Make form
      $this->view->form = $form = new Sespaymentapi_Form_Admin_Refund_Approve();
      
      $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency();
      
      //$remainingAmount  =  Engine_Api::_()->getDbtable('remainingpayments', 'sespaymentapi')->getRemainingAmount(array('user_id' => $this->getRequest()->getParam('owner_id'), 'resource_id' => $this->getRequest()->getParam('resource_id'), 'resource_type' => $this->getRequest()->getParam('resource_type')));
      
      //$orderDetails  =  Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->getOrderStats(array('resource_id' => $this->getRequest()->getParam('resource_id'), 'resource_type' => $this->getRequest()->getParam('resource_type')));
      
      $value = array();
      $value['total_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($refundReq->total_amount, $defaultCurrency);
      //$value['total_tax_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($orderDetails['totalTaxAmount'],$defaultCurrency);
      //$value['total_commission_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency);
      $value['remaining_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($refundReq->total_amount, $defaultCurrency);
      
      //set value to form
      if($this->_getParam('id',false)){
        $item = Engine_Api::_()->getItem('sespaymentapi_refundrequest', $this->_getParam('id'));
        if($item) {
          $itemValue = $item->toArray();
          $value = array_merge($itemValue,$value);
          $value['requested_amount'] = Engine_Api::_()->sespaymentapi()->getCurrencyPrice($itemValue['total_amount'],$defaultCurrency);
          $value['release_amount'] = $itemValue['total_amount'];
        } else {
          return $this->_forward('requireauth', 'error', 'core');	
        }
      }
      
      if(empty($_POST))
        $form->populate($value);
      
      if (!$this->getRequest()->isPost())
        return;
        
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
        
//       if($item->requested_amount < @round($_POST['release_amount'],2)){
//         $form->addError('Release amount must be less than or equal to requested amount.');
//         return;
//       }
      
      $db = Engine_Api::_()->getDbtable('refundrequests', 'sespaymentapi')->getAdapter();
      $db->beginTransaction();
      try {

        $tableOrder = Engine_Api::_()->getDbtable('refundrequests', 'sespaymentapi');
        $order = $item;
        $order->release_amount = @round($_POST['release_amount'],2);
        $order->admin_message = $_POST['admin_message'];
        $order->release_date	 = date('Y-m-d h:i:s');
        $order->save();
        

        
        //Payment approve mail send to event owner
        //Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'sesevent_ticketpayment_adminrequestapproved', array('event_title' => $resource->title, 'object_link' => $resource->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        
        $db->commit();
        $session = new Zend_Session_Namespace();
        $session->refund_request_id = $order->refundrequest_id;
        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Processing...');
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespaymentapi', 'controller' => 'refund', 'action' => 'process'), 'admin_default',true),
          'messages' => array($this->view->message)
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
	}
	
	public function processAction() {
	
		$session = new Zend_Session_Namespace();
		$viewer = Engine_Api::_()->user()->getViewer();
		
		if(!$session->refund_request_id)
			return $this->_forward('requireauth', 'error', 'core');
		
		$item = Engine_Api::_()->getItem('sespaymentapi_refundrequest', $session->refund_request_id);
		
		$user = Engine_Api::_()->getItem('user', $item->user_id);
		
    // Get gateway
    $gatewayId = $item->gateway_id;
		$gateway = Engine_Api::_()->getDbtable('usergateways', 'sespaymentapi')->getUserGateway(array('user_id' => $user->getIdentity()));

		if( !$gatewayId ||
        !($gateway) ||
        !($gateway->enabled) ) {
       return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }
    
    $this->view->gateway = $gateway;
		$this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway('refund');
		
		$plugin = $gateway->getPlugin('refund');
		
		$ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
		
    // Process
    $ordersTable->insert(array(
      'user_id' => $viewer->getIdentity(),
      'gateway_id' => 2,
      'state' => 'pending',
      'creation_date' => new Zend_Db_Expr('NOW()'),
      'source_type' => 'sespaymentapi_refundrequest',
      'source_id' => $item->refundrequest_id,
    ));
    
		$session = new Zend_Session_Namespace();
    $session->sespaymentapi_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId(); 
		$session->sespaymentapi_item_id = $item->getIdentity();
		
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
      .  $this->view->url(array('action' => 'return', 'controller' => 'refund', 'module' => 'sespaymentapi'), 'admin_default', true)
      . '/?state=' . 'return&order_id=' . $order_id;
      
    $params['cancel_url'] = $schema . $host
      .  $this->view->url(array('action' => 'return', 'controller' => 'refund', 'module' => 'sespaymentapi'), 'admin_default', true)
      . '/?state=' . 'cancel&order_id=' . $order_id;
      
    $params['ipn_url'] = $schema . $host
      .  $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'admin_default', true).'&order_id=' . $order_id;
    // Process transaction
		
    $transaction = $plugin->createOrderTransaction($item, $user, $params);
		
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
		$orderPaymentId = $session->sespaymentapi_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);
		$item_id = $session->sespaymentapi_item_id ;
		$item = Engine_Api::_()->getItem('sespaymentapi_refundrequest', $item_id);
    if (!$orderPayment || ($orderId != $orderPaymentId) ||
			 ($orderPayment->source_type != 'sespaymentapi_refundrequest') ||
			 !($user_order = $orderPayment->getSource()) ) {
			return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }

		$gateway = Engine_Api::_()->getDbtable('usergateways', 'sespaymentapi')->getUserGateway(array('user_id'=>$user_order->user_id));
    
		if( !$gateway )
      return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
			
    // Get gateway plugin
    $plugin = $gateway->getPlugin('refund');
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
			 return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
    }
  }
  
  public function finishAction() {
  
    $session = new Zend_Session_Namespace();
    
		if(empty($session->sespaymentapi_order_id))
			return $this->_forward('notfound', 'error', 'core');
			
    if (!empty($session->sespaymentapi_order_id))
      $session->sespaymentapi_order_id = '';

    $orderTrabsactionDetails = array('state' => $this->_getParam('state'), 'errorMessage' => $session->errorMessage);
    $session->sespaymentapi_order_details = $orderTrabsactionDetails;
    
		$state = $this->_getParam('state');
	  if(!$state)
	 	 return $this->_forward('notfound', 'error', 'core');
	 	 
		$this->view->error = $error =  $session->errorMessage;
		$session->unsetAll();
  }
  
	public function cancelAction() {
	
		$resource = Engine_Api::_()->getItem('user', $this->getRequest()->getParam('user_id'));

	  $paymnetReq = Engine_Api::_()->getItem('sespaymentapi_refundrequest', $this->getRequest()->getParam('id'));  

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Make form
	   $this->view->form = $form = new Sespaymentapi_Form_Delete();
		 $form->setTitle('Reject Refund Request');
		 $form->setDescription('Are you sure that you want to reject this refund request?');
		 $form->submit->setLabel('Reject');
		 
    if (!$paymnetReq) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Refund request doesn't exists or not authorized to cancel");
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
			//$owner = $resource->getOwner();
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($resource, $viewer, $resource, $resource->getType().'_adminrefundrequestcancel', array());
			
      //Payment cancel mail send to event owner
			//Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'sesevent_ticketpayment_adminrequestcancel', array('event_title' => $resource->title, 'object_link' => $resource->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Refund Request has been cancelled.');
    return $this->_forward('success', 'utility', 'core', array(
     'smoothboxClose' => 10,
     'parentRefresh' => 10,
     'messages' => array($this->view->message)
    ));
	}
	
  
  public function manageRefundMadeAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_admin_main', array(), 'sespaymentapi_admin_main_managerefunds');
    
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_admin_main_managerefunds', array(), 'sespaymentapi_admin_main_managerefundmade');

    $this->view->formFilter = $formFilter = new Sespaymentapi_Form_Admin_FilterPaymentMade();
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    $values = array_merge(array('order' => $_GET['order'], 'order_direction' => $_GET['order_direction']), $values);

    $this->view->assign($values);

    $eventTableName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $ordersTable = Engine_Api::_()->getDbTable('refundrequests', 'sespaymentapi');
    $ordersTableName = $ordersTable->info('name');

    $select = $ordersTable->select()
            ->setIntegrityCheck(false)
            ->from($ordersTableName)
            ->joinLeft($eventTableName, "$ordersTableName.user_id = $eventTableName.user_id", 'displayname')
            ->where($ordersTableName . '.state = ?', 'complete')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'refundrequest_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
      $select->where($eventTableName . '.displayname LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['creation_date']))
      $select->where($ordersTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
      
    if(!empty($_GET['gateway']))
      $select->where($ordersTableName . '.gateway_type LIKE ?', $_GET['gateway'] . '%');
      
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function viewrefundmadeAction() {
    $this->view->item = Engine_Api::_()->getItem('sespaymentapi_refundrequest', $this->_getParam('id', null));
  }

  public function detailAction() {
  
    //$this->view->event = $event = Engine_Api::_()->core()->getSubject();
    
    $this->view->item = $paymnetReq = Engine_Api::_()->getItem('sespaymentapi_refundrequest', $this->getRequest()->getParam('id'));
    
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    
//     if (!$this->_helper->requireAuth()->setAuthParams($event, null, 'edit')->isValid())
//       return;

    if (!$paymnetReq) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
      return;
    }
  }
}
