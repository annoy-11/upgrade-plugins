<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminPaymentController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_AdminPaymentController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_manageorde');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_manageorde', array(), 'courses_admin_main_payreq');
    $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_payreq', array(), 'courses_admin_main_patreqsub');
    //echo "<pre>";var_dump($this->view->subsubNavigation);die;
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_Filterpaymentorder();
		$values = array();
    if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
        $paymentTable = Engine_Api::_()->getItemTable('courses_userpayrequest');
		$paymentTableName = $paymentTable->info('name');
		$coursesTableName = Engine_Api::_()->getItemTable('courses')->info('name');
		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
        $select = $paymentTable->select()
            ->from($paymentTableName)
						->where('state =?','pending')
						->setIntegrityCheck(false)
						->joinLeft($coursesTableName, "$paymentTableName.course_id = $coursesTableName.course_id", array('title','custom_url'))
						->where($coursesTableName.'.course_id !=?','')
						->joinLeft($tableUserName, "$paymentTableName.owner_id = $tableUserName.user_id", 'username')
            ->order('creation_date DESC');

		if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
		if (!empty($_GET['creation_date']))
      $select->where($paymentTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
		if (!empty($_GET['course']))
      $select->where($coursesTableName . '.title LIKE ?', '%' . $_GET['course'] . '%');
		if (!empty($_GET['amount']))
      $select->where($paymentTableName . '.requested_amount LIKE ?', '%' . $_GET['amount'] . '%');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
	public function approveAction(){
    $viewer = Engine_Api::_()->user()->getViewer();
    $course_id = $this->getRequest()->getParam('course_id');
		$this->view->course = $course = Engine_Api::_()->getItem('courses', $this->getRequest()->getParam('course_id'));
	    $paymnetReq = Engine_Api::_()->getItem('courses_userpayrequest', $this->getRequest()->getParam('id'));
		// In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
		$gateway_enable = Engine_Api::_()->getDbtable('usergateways', 'courses')->getUserGateway(array('course_id'=>$course->course_id));
		if(empty($gateway_enable)){
			$this->view->disable_gateway = true;
        }else{
           $this->view->disable_gateway = false;
            // Make form
             $this->view->form = $form = new Courses_Form_Admin_Payment_Approve(array('courseId'=>$course_id));
             $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency();
             $remainingAmount  =  Engine_Api::_()->getDbtable('remainingpayments', 'courses')->getCourseRemainingAmount(array('course_id'=>$course->course_id));
                $orderDetails  =  Engine_Api::_()->getDbtable('orders', 'courses')->getCourseStats(array('course_id'=>$course->course_id));
                $value = array();
                $value['total_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['total_amount'],$defaultCurrency);
                $value['total_tax_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['total_billingtax_cost'],$defaultCurrency);
                $value['total_commission_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency);
                $value['remaining_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($remainingAmount->remaining_payment,$defaultCurrency);
                //set value to form
                if($this->_getParam('id',false)){
                        $item = Engine_Api::_()->getItem('courses_userpayrequest', $this->_getParam('id'));
                        if($item){
                            $itemValue = $item->toArray();
                            $value = array_merge($itemValue,$value);
                            $value['requested_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($itemValue['requested_amount'],$defaultCurrency);
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
                    $db = Engine_Api::_()->getDbtable('userpayrequests', 'courses')->getAdapter();
                $db->beginTransaction();
                try{
                    $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'courses');
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
                                    'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'courses', 'controller' => 'payment', 'action' => 'process'),'admin_default',true),
                                    'messages' => array($this->view->message)
                        ));
                    } else if($_POST['gateway_type'] == "stripe") {
                        $session = new Zend_Session_Namespace("courses_userpayrequest");
                        $session->payment_request_id = $order->userpayrequest_id;
                        return $this->_forward('success', 'utility', 'core', array(
                            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'sesadvpmnt', 'controller' => 'payment', 'action' => 'index','type'=>'courses_userpayrequest'),'default',true),
                            'messages' => array($this->view->message)
                        ));
                    } else if($_POST['gateway_type'] == "paytm") {
                        $session = new Zend_Session_Namespace("courses_userpayrequest");
                        $session->payment_request_id = $order->userpayrequest_id;
                        return $this->_forward('success', 'utility', 'core', array(
                            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('route' => 'default','module' => 'epaytm', 'controller' => 'payment', 'action' => 'index','type'=>'courses_userpayrequest'),'default',true),
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

        $item = Engine_Api::_()->getItem('courses_userpayrequest', $session->payment_request_id);
        $course = Engine_Api::_()->getItem('courses', $item->course_id);
        // Get gateway
        $gatewayId = $item->gateway_id;
            $gateway = Engine_Api::_()->getDbtable('usergateways', 'courses')->getUserGateway(array('course_id'=>$course->course_id,'gateway_type'=>"paypal","enabled"=>true,'user_id'=>$course->owner_id));
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
            'source_type' => 'courses_userpayrequest',
            'source_id' => $item->userpayrequest_id,
        ));
        $session = new Zend_Session_Namespace();
        $session->courses_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
        $session->courses_item_id = $item->getIdentity();
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
          .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'courses'), 'admin_default', true)
          . '/?state=' . 'return&order_id=' . $order_id;
        $params['cancel_url'] = $schema . $host
          .  $this->view->url(array('action' => 'return', 'controller' => 'payment', 'module' => 'courses'), 'admin_default', true)
          . '/?state=' . 'cancel&order_id=' . $order_id;
        $params['ipn_url'] = $schema . $host
          .  $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'admin_default', true).'&order_id=' . $order_id;
        // Process transaction

        $transaction = $plugin->createOrderTransaction($item,$course,$params);

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
		$orderPaymentId = $session->courses_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);
		if(($this->_getParam('type', null) == "stripe") || $this->_getParam('type', null) == "paytm"){
        return $this->_finishPayment($session->status,$orderPayment->source_id);
		}
		$item_id = $session->courses_item_id;
		$item = Engine_Api::_()->getItem('courses_userpayrequest', $item_id);
    if (!$orderPayment || ($orderId != $orderPaymentId) ||
        ($orderPayment->source_type != 'courses_userpayrequest') ||
        !($user_order = $orderPayment->getSource()) ) {
        return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }
		$gateway = Engine_Api::_()->getDbtable('usergateways', 'courses')->getUserGateway(array('course_id'=>$user_order->course_id,'gateway_type'=>"paypal","enabled"=>true));
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
        $order = Engine_Api::_()->getItem('courses_userpayrequest',$orderPaymentId); 
        $course = Engine_Api::_()->getItem('courses',$order->course_id);
        $viewer = Engine_Api::_()->user()->getViewer();
        $owner = $course->getOwner();
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $course, 'courses_approve_request', array());
        //Payment approve mail send to courses owner
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->email, 'courses_approve_request', array('host' => $_SERVER['HTTP_HOST'], 'object_link' => $course->getHref()));
      return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
    }
  }
  public function finishAction() {
    $session = new Zend_Session_Namespace();
    if (!empty($session->courses_order_id))
      $session->courses_order_id = '';
    $orderTrabsactionDetails = array('state' => $this->_getParam('state'), 'errorMessage' => $session->errorMessage);
    $session->courses_order_details = $orderTrabsactionDetails;
		$state = $this->_getParam('state');
	  if(!$state)
	 	 return $this->_forward('notfound', 'error', 'core');
		$this->view->error = $error =  $session->errorMessage;
		$session->unsetAll();
  }
	public function cancelAction(){
		$this->view->course = $course = Engine_Api::_()->getItem('courses', $this->getRequest()->getParam('course_id'));
	  $paymnetReq = Engine_Api::_()->getItem('courses_userpayrequest', $this->getRequest()->getParam('id'));
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
      $owner = $course->getOwner();
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $course, 'courses_cancel_request', array());
      //Payment cancel mail send to course owner
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'courses_cancel_request', array('course_title' => $course->title, 'object_link' => $course->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
  public function managePaymentCourseOwnerAction() {
      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_manageorde');
      $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_manageorde', array(), 'courses_admin_main_payreq');
      $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_payreq', array(), 'courses_admin_main_paymade');
      $this->view->formFilter = $formFilter = new Courses_Form_Admin_FilterPaymentCourseOwner();
      $values = array();
      if ($formFilter->isValid($this->_getAllParams()))
          $values = $formFilter->getValues();
      $values = array_merge(array('order' => $_GET['order'], 'order_direction' => $_GET['order_direction']), $values);

      $this->view->assign($values);
      $courseTableName = Engine_Api::_()->getItemTable('courses')->info('name');
      $ordersTable = Engine_Api::_()->getDbTable('userpayrequests', 'courses');
      $ordersTableName = $ordersTable->info('name');
      $select = $ordersTable->select()
          ->setIntegrityCheck(false)
          ->from($ordersTableName)
          ->joinLeft($courseTableName, "$ordersTableName.course_id = $courseTableName.course_id", 'title')
          ->where($ordersTableName . '.state = ?', 'complete')
          ->order((!empty($_GET['order']) ? $_GET['order'] : 'userpayrequest_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

      if (!empty($_GET['name']))
          $select->where($courseTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

      if (!empty($_GET['creation_date']))
          $select->where($ordersTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
      if (!empty($_GET['gateway']))
          $select->where($ordersTableName . '.gateway_type LIKE ?', $_GET['gateway'] . '%');
      $paginator = Zend_Paginator::factory($select);
      $this->view->paginator = $paginator;
      $paginator->setItemCountPerPage(20);
      $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  public function viewPaymentrequestAction() {
      $this->view->item = Engine_Api::_()->getItem('courses_userpayrequest', $this->_getParam('id', null));
  }
}
