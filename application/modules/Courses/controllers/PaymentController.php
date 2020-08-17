<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: PaymentController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_PaymentController extends Core_Controller_Action_Standard
{
  /**
   * @var User_Model_User
   */
  protected $_user;

  /**
   * @var Zend_Session_Namespace
   */
  protected $_session;

  /**
   * @var Payment_Model_Order
   */
  protected $_order;

  /**
   * @var Payment_Model_Gateway
   */
  protected $_gateway;

  /**
   * @var Payment_Model_Subscription
   */
  protected $_item;

  /**
   * @var Payment_Model_Package
   */
  protected $_package;

  public function init()
  {
    // Get user and session
    $this->_user = Engine_Api::_()->user()->getViewer();
    $this->_session = new Zend_Session_Namespace('Payment_Courses');
    $this->_session->gateway_id = $this->_getParam('gateway_id',0);
		// Check viewer and user

    if( !$this->_user || !$this->_user->getIdentity() ) {
      if( !empty($this->_session->user_id) ) {
        $this->_user = Engine_Api::_()->getItem('user', $this->_session->user_id);
      }
    } 
  }
  public function indexAction()
  {
      // Get gateway
      $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);
      $courseOrder = Engine_Api::_()->getItem('courses_order',$this->_getParam('order_id'));

      //check cheque and cod orders
      if($gatewayId == 21 || $gatewayId == 20){
          return $this->_finishPayment("processing");
      }
      if( !$gatewayId ||
          !($gateway = Engine_Api::_()->getDbtable('gateways', 'courses')->find($gatewayId)->current()) ||
          !($gateway->enabled) || !$this->_getParam('order_id') || !$courseOrder) {
          return $this->_helper->redirector->gotoRoute(array('action' => 'index'),'courses_cart',true);
      }
      $this->view->gateway = $gateway;
      // Get package
      if( !$gatewayId ) {
          return $this->_helper->redirector->gotoRoute(array('action' => 'index'),'courses_cart',true);
      }
      // Create order
      $ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
      if( !empty($this->_session->order_id) ) {
          $previousOrder = $ordersTable->find($this->_session->order_id)->current();
          if( $previousOrder && $previousOrder->state == 'pending' ) {
              $previousOrder->state = 'incomplete';
              $previousOrder->save();
          }
      }
      $ordersTable->insert(array(
          'user_id' => $this->_user->getIdentity(),
          'gateway_id' => $gateway->gateway_id,
          'state' => 'pending',
          'creation_date' => new Zend_Db_Expr('NOW()'),
          'source_type' => 'courses_order',
          'source_id' => $this->_getParam('order_id'),
      ));
      $this->_session->order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
      $this->_session->currency = $currentCurrency = Engine_Api::_()->courses()->getCurrentCurrency();
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $this->_session->change_rate = $settings->getSetting('sesmultiplecurrency.' . $currentCurrency) ;
      // Unset certain keys
      unset($this->_session->gateway_id);
      // Get gateway plugin
      $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
      $plugin = $gateway->getPlugin();

      // Prepare host info
      $schema = 'http://';
      if( !empty($_ENV["HTTPS"]) && 'on' == strtolower($_ENV["HTTPS"]))
          $schema = 'https://';

      $host = $_SERVER['HTTP_HOST'];

      // Prepare transaction
      $params = array();

      $params['language'] = $this->_user->getIdentity() ? $this->_user->language : Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en_US');
      $localeParts = explode('_', $this->_user->getIdentity() ? $this->_user->language : Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en_US'));
      if( count($localeParts) > 1 ) {
          $params['region'] = $localeParts[1];
      }
      $params['vendor_order_id'] = $order_id;
      $params['return_url'] = $schema . $host
          . $this->view->url(array('action' => 'return','order_id'=>$this->_getParam('order_id')))
          . '?order_id=' . $order_id
          . '&state=' . 'return';
      $params['cancel_url'] = $schema . $host
          . $this->view->url(array('action' => 'return','order_id'=>$this->_getParam('order_id')))
          . '?order_id=' . $order_id
          . '&state=' . 'cancel';
      $params['ipn_url'] = $schema . $host . $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'courses'), 'default') . '?order_id=' . $order_id.'&gateway_id='.$gatewayId;

      // Process transaction
      $transaction = $plugin->createOrderTransaction($this->_user,$courseOrder, $params);
      // Pull transaction params
      $this->view->transactionUrl = $transactionUrl = $gatewayPlugin->getGatewayUrl();
      $this->view->transactionMethod = $transactionMethod = $gatewayPlugin->getGatewayMethod();
      $this->view->transactionData = $transactionData = $transaction->getData();
      // Handle redirection
      $transactionUrl .= '?' . http_build_query($transactionData);
      return $this->_helper->redirector->gotoUrl($transactionUrl, array('prependBase' => false));
  }
  public function returnAction()
  {
    if($this->_getParam('is_free',false))
      return $this->_finishPayment('active');
      
    $orderId = $this->_session->order_id;
    $order = Engine_Api::_()->getItem('payment_order', $orderId);
    // Get order
    if( ((!$this->_user || $order->user_id != $this->_user->getIdentity()) && $_SERVER["REMOTE_ADDR"] != $order->ip_address) ||
        !($orderId) ||
        !($order) ||
        $order->source_type != 'courses_order' ||
        !($item = $order->getSource()) ||
        !($gateway = Engine_Api::_()->getItem('courses_gateway', $order->gateway_id)) ) {
      return $this->_helper->redirector->gotoRoute(array('action'=>'manage'), 'courses_general', true);
    }
    // Get gateway plugin
    $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
    if(($gateway->plugin == "Epaytm_Plugin_Gateway_Paytm") || ($gateway->plugin == "Sesadvpmnt_Plugin_Gateway_Stripe")){
        return $this->_finishPayment($order->state);
		}
    $plugin = $gateway->getPlugin();
    // Process return
    unset($this->_session->errorMessage);
    try {
      $status = $plugin->createOrderTransactionReturn($order, $this->_getAllParams());
    } catch( Payment_Model_Exception $e ) {
      $status = 'failure';
      $this->_session->errorMessage = $e->getMessage();
    }
    return $this->_finishPayment($status);
  }

  public function finishAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->status = $status = $this->_getParam('state');
    $this->view->error = $this->_session->errorMessage;
    //$this->_session->unsetAll();
    $order = Engine_Api::_()->getItem('courses_order',$this->_getParam('order_id',$this->_session->order_id));
    if(!empty($this->_session->order_id))
      unset($this->_session->order_id);
    //get all orders from parent order
    if(!$order)
        return $this->_helper->redirector->gotoRoute(array('action'=>'manage'), 'courses_general', true);
    $this->view->order = $order;
    $this->view->status = $status = $this->_getParam('state');
    $this->view->error = $this->_session->errorMessage;
    $this->_session->unsetAll();
  }
  protected function _finishPayment($state = 'active')
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    //empty cart
    $cartId = Engine_Api::_()->courses()->getCartId();
    $table = Engine_Api::_()->getDbTable('cartcourses','courses');
    $select = $table->select()->where('cart_id =?',$cartId->getIdentity());
    $cartCourses = $table->fetchAll($select);
    foreach ($cartCourses as $course){
      $item = Engine_Api::_()->getItem('courses',$course->course_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer,$viewer, $item, 'courses_payment_donetouser',array('order_id' => $this->_session->order_id));
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer, 'courses_payment_donetouser', array('course_title' => $item->getTitle(),'sender_title' => $viewer->getTitle(), 'object_link' => $item->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($item->getOwner(), 'courses_payment_done', array('course_title' => $item->getTitle(),'sender_title' => $viewer->getTitle(),'object_link' => $item->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(),$viewer, $item, 'courses_payment_done');
      $course->delete();
    }
    //end empty cart work
    // No user?
    if( !$viewer->getIdentity() && $_SERVER["REMOTE_ADDR"] != $this->_order->ip_address) {
      return $this->_helper->redirector->gotoRoute(array('action'=>'manage'), 'courses_general', true);
    }
    // Redirect
    return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
  }
}
