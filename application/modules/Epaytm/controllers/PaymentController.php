<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: PaymentController.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
include_once APPLICATION_PATH . "/application/modules/Epaytm/Api/PaytmKit/lib/encdec_paytm.php";
class Epaytm_PaymentController extends Core_Controller_Action_Standard
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
  protected $order_id;

  protected $_type;

  /**
   * @var Payment_Model_Gateway
   */
  protected $_gateway;

  /**
   * @var Payment_Model_Subscription
   */
  protected $_item;
  protected $_sessionNames = array(
        'user'=>'Payment_Subscription',
        'product'=>'Payment_Sesproduct',
        'crowdfunding'=>'crowdfunding',
        'sescrowdfunding_userpayrequest'=>'sescrowdfunding_userpayrequest',
        'sesproduct_userpayrequest'=>'sesproduct_userpayrequest',
        'Payment_Credit'=>'Payment_Credit',
        'courses'=>'courses',
        'courses_userpayrequest'=>'courses_userpayrequest');
  /**
   * @var Payment_Model_Package
   */
  protected $_package;

  protected $_module;
  
  public function init()
  {
    // Get user and session
    $this->_user = Engine_Api::_()->user()->getViewer();
    $this->_session = new Zend_Session_Namespace('Payment_Subscription');
    $this->_session->gateway_id = $this->_getParam('gateway_id',false);
    $requestType = $this->_getParam('type',null);
    $sessionName = isset($requestType) ? $this->_sessionNames[$requestType] : '';
    $this->_session = new Zend_Session_Namespace($sessionName);
    // Check viewer and user
    if( !$this->_user || !$this->_user->getIdentity() ) {
      if( !empty($this->_session->user_id) ) {
        $this->_user = Engine_Api::_()->getItem('user', $this->_session->user_id);
      }
    }
  }  
  public function indexAction()
  {
  $settings = Engine_Api::_()->getApi('settings', 'core');
  $viewer = Engine_Api::_()->user()->getViewer();
  $ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
  $requestType = $this->_getParam('type',null);
  if($requestType == "user") {
      $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);
      if(!$gatewayId ||
        !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
        !($gateway->enabled)) {
        return $this->_forward('requireauth', 'error', 'core');
      }
      $this->_gateway = $gateway;
      if(!($subscriptionId = $this->_getParam('subscription_id', $this->_session->subscription_id)) ||
          !($subscription = Engine_Api::_()->getItem('payment_subscription', $subscriptionId)) ||
          !($package = Engine_Api::_()->getItem('payment_package', $subscription->package_id))) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'choose'));
      } else {
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
            'source_type' => 'payment_subscription',
            'source_id' => $subscription->subscription_id,
        ));
        $param['order_id'] = $this->_session->order_id = $this->order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
          $param['amount'] = $package->price;
        $param['type'] = "user";
          $param['currency'] = $settings->getSetting('payment.currency', 'USD');
      }
    } if($requestType == "product"){
      $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);
      if(!$gatewayId ||
        !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
        !($gateway->enabled)) {
        return $this->_forward('requireauth', 'error', 'core');
      }
      $this->_gateway = $gateway;
      $this->_session = new Zend_Session_Namespace('Payment_Sesproduct');
      $this->order_id = $this->_getParam('order_id',$this->_session->order_id);
      $productOrder = Engine_Api::_()->getItem('sesproduct_order',$this->order_id);
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
          'source_type' => 'sesproduct_order',
          'source_id' => $this->_getParam('order_id'),
      ));
      $param['order_id'] = $this->_session->order_id = $this->order_id = $ordersTable->getAdapter()->lastInsertId();
      $param['amount']  = Engine_Api::_()->getDbTable('orders','sesproduct')->getTotalCartPrice($productOrder->getIdentity());
      $this->_session->currency = $param['currency'] = Engine_Api::_()->sesproduct()->getCurrentCurrency();
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $this->_session->change_rate = $settings->getSetting('sesmultiplecurrency.' . $param['currency']);
      $this->_session->type = $param['type'] = "product";
    } if($requestType == "crowdfunding"){
        $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);
        if(!$gatewayId ||
          !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
          !($gateway->enabled)) {
          return $this->_forward('requireauth', 'error', 'core');
        }
        $this->_gateway =  $gateway;
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
        $viewer_id = $viewer->getIdentity();
        $admin_commission = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sescrowdfunding', 'sescrowdfunding_commison');
        $commison_amount = ($price * $admin_commission) / 100;
        $total_amount = $price + $commison_amount;
        $crowdfundingordersTable = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding');
        $order = $crowdfundingordersTable->createRow();
        $values = array(
            'crowdfunding_id' => $resource_id,
            'user_id' => $viewer_id,
            'gateway_id' => $gateway->gateway_id,
            'gateway_type' => 'Paytm',
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
        $this->order_id = $order_id = $order->order_id;
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->gateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'sescrowdfunding_order',
            'source_id' => $order->order_id,
        ));
        $param['amount'] = $price;
        $param['type'] = "crowdfunding";
        $param['order_id'] = $order_id = $ordersTable->getAdapter()->lastInsertId();
        $param['currency'] = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
        $this->_session->type = "crowdfunding";
    } if($requestType == "sescrowdfunding_userpayrequest"){
        $session = new Zend_Session_Namespace("sescrowdfunding_userpayrequest");
        if(!$session->payment_request_id)
          return $this->_forward('requireauth', 'error', 'core');
        $item = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $session->payment_request_id);
        $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $item->crowdfunding_id);
        // Get gateway
        $gatewayId = $item->gateway_id;
        $sessionReturn = new Zend_Session_Namespace();
        $gateway = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id'=>$crowdfunding->owner_id,'gateway_type'=>"paytm"));
        if( !$gatewayId || !($gateway) || !($gateway->enabled) ) {
            return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }
        $param['gateway_id'] = $gatewayId;
        $this->_gateway = $this->view->gateway = $gateway;
        $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway(array('plugin'=>$gateway->plugin,'is_sponsorship'=>'sescrowdfunding'));
        $plugin = $gateway->getPlugin($gateway->plugin);
        //Process
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->usergateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'sescrowdfunding_userpayrequest',
            'source_id' => $item->userpayrequest_id,
        ));
        $sessionReturn->sescrowdfunding_item_id = $item->getIdentity();
        $param['order_id'] = $session->sescrowdfunding_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
        $session->sescrowdfunding_item_id = $item->getIdentity();
        $param['amount'] = $item->release_amount;
        $param['currency'] = $item->currency_symbol ? $item->currency_symbol : $settings->getSetting('payment.currency', 'USD');
        $param['type'] = $this->_session->type = "sescrowdfunding_userpayrequest";
    } if($requestType == "sesproduct_userpayrequest"){
        $session = new Zend_Session_Namespace("sesproduct_userpayrequest");
        if(!$session->payment_request_id)
            return $this->_forward('requireauth', 'error', 'core');
        $item = Engine_Api::_()->getItem('sesproduct_userpayrequest', $session->payment_request_id);
        $store = Engine_Api::_()->getItem('stores', $item->store_id);
        // Get gateway
        $gateway = Engine_Api::_()->getDbtable('usergateways', 'sesproduct')->getUserGateway(array('store_id'=>$store->store_id,'gateway_type'=>'paytm'));
        if(!($gateway) || !($gateway->enabled) ) {
           return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }
        $sessionReturn = new Zend_Session_Namespace();
        $this->_gateway = $this->view->gateway = $gateway;
        $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway($gateway->plugin);
        $plugin = $gateway->getPlugin();
        // Process
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->usergateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'sesproduct_userpayrequest',
            'source_id' => $item->userpayrequest_id,
        ));
        $param['order_id'] = $session->sesproduct_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
        $session->sesproduct_item_id = $item->getIdentity();
        $sessionReturn->sesproduct_item_id = $item->getIdentity();
        $param['amount'] = $item->release_amount;
        $param['currency'] = $item->currency_symbol ? $item->currency_symbol : $settings->getSetting('payment.currency', 'USD');
        $param['type'] = "sesproduct_userpayrequest";
        $this->_session->type = "sesproduct_userpayrequest";
    } if($requestType == "Payment_Credit"){
        $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);
        if(!$gatewayId ||
          !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
          !($gateway->enabled)) {
          return $this->_forward('requireauth', 'error', 'core');
        }
        $this->_gateway =  $gateway;
        $currentCurrency = Engine_Api::_()->sescredit()->getCurrentCurrency();
        $defaultCurrency = Engine_Api::_()->sescredit()->defaultCurrency();
            $currencyValue = 1;
        if ($currentCurrency != $defaultCurrency) {
            $currencyValue = $settings->getSetting('sesmultiplecurrency.' . $currentCurrency);
        }
        $orderId = $session->order_id;
        $orderTable = Engine_Api::_()->getDbTable('orders', 'payment');
        $sourceId = $orderTable->select()->from($orderTable->info('name'), 'source_id')->where('order_id =?', $orderId)->query()->fetchColumn();
        $orderDetailTable = Engine_Api::_()->getDbTable('orderdetails', 'sescredit');
        $select = $orderDetailTable->select()->from($orderDetailTable->info('name'), array('*'))->where('orderdetail_id =?', $sourceId);
        $orderDetail = $orderDetailTable->fetchRow($select);
        if ($orderDetail->purchase_type == 1) {
            $price = Engine_Api::_()->getItem('sescredit_offer', $orderDetail->offer_id)->point_value;
        } else {
            $price = $orderDetail->point / Engine_Api::_()->getApi('settings', 'core')->getSetting('sescredit.creditvalue', '100');
        }
        $price = @round(($price * $currencyValue), 2);
        $param['order_id'] = $session->order_id;
        $param['change_rate'] = $currencyValue;
        $this->_session->type = "Payment_Credit";
        $param['amount'] = $price;
        $param['currency'] = $currentCurrency;
        $param['type'] = "Payment_Credit";
        $this->_gateway =  $gateway;
    }if($requestType == "courses"){
      $this->_session = new Zend_Session_Namespace('Payment_Courses');
      $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);
      if(!$gatewayId ||
        !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
        !($gateway->enabled)) {
        return $this->_forward('requireauth', 'error', 'core');
      }
      $this->_gateway =  $gateway;
      $this->order_id = $this->_getParam('order_id',$this->_session->order_id);
      $courseOrder = Engine_Api::_()->getItem('courses_order',$this->order_id);
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
      $param['order_id'] = $this->_session->order_id = $this->order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
      $param['amount'] = $courseOrder->total_amount;
        $this->_session->currency = $param['currency'] = Engine_Api::_()->courses()->getCurrentCurrency();
      $this->_session->change_rate = $settings->getSetting('sesmultiplecurrency.' . $param['currency']);
      $param['type'] = "courses";
    } if($requestType == "courses_userpayrequest"){
        $session = new Zend_Session_Namespace("courses_userpayrequest");
        if(!$session->payment_request_id)
            return $this->_forward('requireauth', 'error', 'core');
        $item = Engine_Api::_()->getItem('courses_userpayrequest', $session->payment_request_id);
        $course = Engine_Api::_()->getItem('courses', $item->course_id);
        // Get gateway
        $gateway = Engine_Api::_()->getDbtable('usergateways', 'courses')->getUserGateway(array('course_id'=>$course->course_id,'gateway_type'=>'paytm'));
        if(!($gateway) || !($gateway->enabled) ) {
           return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }
        $sessionReturn = new Zend_Session_Namespace();
        $this->_gateway = $this->view->gateway = $gateway;
        $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway($gateway->plugin);
        $plugin = $gateway->getPlugin();
        // Process
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->usergateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'courses_userpayrequest',
            'source_id' => $item->userpayrequest_id,
        ));
        $sessionReturn->courses_order_id = $param['order_id'] = $session->courses_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
        $session->courses_item_id = $item->getIdentity();
        $sessionReturn->courses_item_id = $item->getIdentity();
         $param['amount'] = $item->release_amount;
         $param['currency'] = $item->currency_symbol ? $item->currency_symbol : $settings->getSetting('payment.currency', 'USD');
        $param['type'] = "courses_userpayrequest";
    } if($requestType == "sesevent_order"){
        $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);
        if(!$gatewayId ||
          !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
          !($gateway->enabled)) {
          return $this->_forward('requireauth', 'error', 'core');
        }
        $this->_gateway = $gateway;
        $this->order_id = $this->_getParam('order_id',$this->_session->order_id);
        $order = Engine_Api::_()->getItem('sesevent_order',$this->order_id);
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->gateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'sesevent_order',
            'source_id' => $order->order_id,
        ));
        $this->_session->sesevent_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();  
        $currentCurrency = Engine_Api::_()->sesevent()->getCurrentCurrency();
        $defaultCurrency = Engine_Api::_()->sesevent()->defaultCurrency();
        $currencyValue = 1;
        if($currentCurrency != $defaultCurrency){
            $currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
        }
        $ticket_order = array();
        $event = Engine_Api::_()->getItem('sesevent_event', $order->event_id);
        $orderTicket = $order->getTicket(array('order_id'=>$order->order_id,'event_id'=>$event->event_id,'user_id'=>$viewer->user_id));
        $priceTotal = $entertainment_tax = $service_tax = $totalTicket =  0;
        foreach($orderTicket as $val){
          $ticket = Engine_Api::_()->getItem('sesevent_ticket', $val['ticket_id']);
          $price = @round($ticket->price*$currencyValue,2);
          $entertainmentTax = @round($ticket->entertainment_tax,2);
          $taxEntertainment = @round($price *($entertainmentTax/100),2);
          $serviceTax = @round($ticket->service_tax,2);
          $taxService = @round($price *($serviceTax/100),2);
          $priceTotal = @round($val['quantity']*$price + $priceTotal,2);		 
          $service_tax = @round(($taxService*$val['quantity']) + $service_tax,2);
          $entertainment_tax = @round(($taxEntertainment * $val['quantity']) + $entertainment_tax,2);
          $totalTicket = $val['quantity']+$totalTicket;
        }
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')):
          $couponSessionCode = '-'.'-'.$event->getType().'-'.$event->event_id.'-0'; 
          $priceTotal = @isset($_SESSION[$couponSessionCode]) ? round($priceTotal - $_SESSION[$couponSessionCode]['discount_amount']) : $priceTotal;
        endif;
        $totalTaxtAmt = @round($service_tax+$entertainment_tax,2);
        $subTotal = @round($priceTotal-$totalTaxtAmt,2);
        $order->total_amount = @round(($priceTotal/$currencyValue),2);
        $order->change_rate = $currencyValue;
        $order->total_service_tax = @round(($service_tax/$currencyValue),2);
        $order->total_entertainment_tax = @round(($entertainment_tax/$currencyValue),2);
        $order->creation_date	= date('Y-m-d H:i:s');
        $totalAmount = round($priceTotal+$service_tax+$entertainment_tax,2);
        $order->total_tickets = $totalTicket;
        $order->gateway_type = 'Stripe';
        $commissionType = Engine_Api::_()->authorization()->getPermission($viewer,'sesevent_event','event_admincomn');
        $commissionTypeValue = Engine_Api::_()->authorization()->getPermission($viewer,'sesevent_event','event_commission');
        //%age wise
        if($commissionType == 1 && $commissionTypeValue > 0){
            $order->commission_amount = round(($priceTotal/$currencyValue) * ($commissionTypeValue/100),2);
        }else if($commissionType == 2 && $commissionTypeValue > 0){
            $order->commission_amount = $commissionTypeValue;
        }
        $order->save();
         $param['amount'] = @round($priceTotal+$totalTaxtAmt, 2);
         $param['currency'] = $currentCurrency;
        $param['type'] = "sesevent_order";
        $param['order_id'] = $order_id;
    } 
    if($requestType == "sesevent_userpayrequest"){
        $session = new Zend_Session_Namespace("sesevent_userpayrequest");
        if(!$session->payment_request_id)
          return $this->_forward('requireauth', 'error', 'core');
        $order = Engine_Api::_()->getItem('sesevent_userpayrequest', $session->payment_request_id);
        $event = Engine_Api::_()->getItem('sesevent_event', $order->event_id);
        // Get gateway
        $gateway = Engine_Api::_()->getDbtable('usergateways', 'sesevent')->getUserGateway(array('event_id'=>$event->event_id,'gateway_type'=>'paytm'));
        if(!($gateway) || !($gateway->enabled) ) {
           return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
        }
       $this->_gateway = $gateway;
        $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
        $plugin = $gateway->getPlugin();
        // Process
        $ordersTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'gateway_id' => $gateway->usergateway_id,
            'state' => 'pending',
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'source_type' => 'sesevent_userpayrequest',
            'source_id' => $order->userpayrequest_id,
        ));
        $currentCurrency = Engine_Api::_()->sesevent()->getCurrentCurrency();
        $defaultCurrency = Engine_Api::_()->sesevent()->defaultCurrency();
        $currencyValue = 1;
        if($currentCurrency != $defaultCurrency){
            $currencyValue = $settings->getSetting('sesevent.'.$currentCurrency);
        }
        $session = new Zend_Session_Namespace();
        $session->sesevent_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId(); 
        $session->sesevent_item_id = $order->getIdentity();  
         $param['amount'] = @round($order->release_amount, 2);
         $param['currency'] = $currentCurrency;
        $param['type'] = "sesevent_userpayrequest";
        $param['order_id'] = $order_id;
    }
    $MID = $gateway->config['paytm_marchant_id']; 
    $secretKey  = $gateway->config['paytm_secret_key'];
    $WEBSITE = $gateway->config['paytm_website'];
    $INDUSTRY_TYPE_ID = $gateway->config['paytm_industry_type']; 
    $plugin = $this->_gateway->getPlugin();
    $this->_type = $this->_getParam('type');
    $this->_session->change_rate = 1;
    $schema = _ENGINE_SSL ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    /* initialize an array with request parameters */
    $this->view->paytmParams = $paytmParams  = array(
      /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
      "MID" => $MID,
      /* Find your WEBSITE in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
      "WEBSITE" => $WEBSITE,
      /* Find your INDUSTRY_TYPE_ID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
      "INDUSTRY_TYPE_ID" => $INDUSTRY_TYPE_ID,
      /* WEB for website and WAP for Mobile-websites or App */
      "CHANNEL_ID" => "WAP",
      /* Enter your unique order id */
      "ORDER_ID" => $param['order_id'],
      /* unique id that belongs to your customer */
      "CUST_ID" => $viewer->getIdentity(),
      /* customer's mobile number */
      /**
      * Amount in INR that is payble by customer
      * this should be numeric with optionally having two decimal points
      */
      "TXN_AMOUNT" => $param['amount'],
      /* on completion of transaction, we will send you the response on this URL */
      "CALLBACK_URL" => $schema .$host.$this->view->url(array('action' => 'return','order_id'=>$param['order_id'],'type'=>$param['type']),'epaytm_payment'),
    );
    $this->view->checksum = getChecksumFromArray($paytmParams, $secretKey);
    /* for Staging */
    if($gateway->test_mode){
      $this->view->url = "https://securegw-stage.paytm.in/order/process";
    } else {
      $this->view->url = "https://securegw.paytm.in/merchant-status/getTxnStatus";
    }
  }
  public function returnAction()
  { 
    $type = $this->_getParam('type',"");
    if($type == "product")
      $this->_session = new Zend_Session_Namespace("Payment_Sesproduct");
    else 
      $this->_session = new Zend_Session_Namespace($sessionName);
    // Get order
    if(!$this->_user ||
        !($orderId = $this->_getParam('order_id',$this->_session->order_id)) ||
        !($order = Engine_Api::_()->getItem('payment_order', $orderId)) ||
        $order->user_id != $this->_user->getIdentity()) {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    }
    switch($type) {
      case 'user':
      case 'product':
      case 'courses':
      case 'crowdfunding':
      case 'Payment_Credit':
      case 'sesevent_order':
        $gateway = Engine_Api::_()->getItem('payment_gateway', $order->gateway_id);
        $plugin = $gateway->getPlugin();
      break;
      case 'sesproduct_userpayrequest': 
        $gateway = Engine_Api::_()->getItem('sesproduct_usergateway', $order->gateway_id);
        $plugin = $gateway->getPlugin($gateway->plugin);
      break;
      case 'sescrowdfunding_userpayrequest': 
        $gateway = Engine_Api::_()->getItem('sesbasic_usergateway', $order->gateway_id);
        $plugin = $gateway->getPlugin($gateway->plugin);
      break;
      case 'courses_userpayrequest': 
        $gateway = Engine_Api::_()->getItem('courses_usergateway', $order->gateway_id);
        $plugin = $gateway->getPlugin($gateway->plugin);
      break;
      case 'sesevent_userpayrequest': 
        $gateway = Engine_Api::_()->getItem('sesevent_usergateway', $order->gateway_id);
        $plugin = $gateway->getPlugin($gateway->plugin);
      break;
    } 
    if(empty($plugin))
        return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    // Process return
    unset($this->_session->errorMessage);
    try {
      $paramList = $this->_getAllParams();
      //$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
      $paramList['type'] = $this->_getParam('type',"");
      $paramList['change_rate'] = $this->_session->change_rate;
      $status = $plugin->createOrderTransactionReturn($order,$paramList);
    } catch(Payment_Model_Exception $e ) {
      $status = false;
      $this->_session->errorMessage = $e->getMessage();
    }
    switch($type) {
			case 'user':
          $this->returnAction($transaction);
			break;
			case 'product':
        return $this->_helper->redirector->gotoRoute(array('action' => 'finish','order_id'=> $order->source_id), 'sesproduct_payment');
			break;
			case 'courses':
        return $this->_helper->redirector->gotoRoute(array('action' => 'return','order_id'=> $order->source_id), 'courses_payment');
			break;
      case 'courses_userpayrequest':
          $session = new Zend_Session_Namespace();
          $session->payment_request_id =  $order->order_id;
          $session->status = $status;
          return $this->_helper->redirector->gotoRoute(array('route' => 'default', 'module' => 'courses', 'controller' => 'payment','action'=>'return','type'=>'paytm'),'admin_default');
			break;
			case 'crowdfunding':
          return $this->_helper->redirector->gotoRoute(array('action' => 'return','order_id'=> $order->order_id), 'sescrowdfunding_payment');
			break;
			case 'sescrowdfunding_userpayrequest':
          $params['state'] = $status;
          $session = new Zend_Session_Namespace();
          $session->sescrowdfunding_order_id = $order->order_id;
          $session->status = $status;
          return $this->_helper->redirector->gotoRoute(array('module' => 'sescrowdfunding', 'controller' => 'payment','action'=>'return','type'=>'paytm'),'admin_default');
			break;
			case 'sesproduct_userpayrequest':
          $session = new Zend_Session_Namespace();
          $session->sesproduct_order_id = $order->order_id;
          $session->status = $status;
          return $this->_helper->redirector->gotoRoute(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'payment','action'=>'return','type'=>'paytm'),'admin_default');
			break;
			case 'Payment_Credit':
          $this->_session->order_id = $order->order_id;
          return $this->_helper->redirector->gotoRoute(array('module'=>'sescredit','controller' => 'payment','action' => 'finish','state'=>$status), 'default', true);
			break;
      case 'sesevent_order':
          $orderEvent = Engine_Api::_()->getItem('sesevent_order',$order->source_id);
          $event = Engine_Api::_()->getItem('sesevent_event',$orderEvent->event_id);
          if(!$orderEvent->ragistration_number){
              $orderEvent->ragistration_number = Engine_Api::_()->sesevent()->generateTicketCode(8);
              $orderEvent->save();
          }
          return $this->_helper->redirector->gotoRoute(array('module'=>'sesevent','controller' => 'order','action' => 'finish','event_id'=>$event->custom_url,'order_id'=>$order->source_id,'state'=>$status), 'default', true);
			break;
			case 'sesevent_userpayrequest':
          $session = new Zend_Session_Namespace();
          $session->sesevent_item_id = $order->source_id;
          $session->status = $status;
          return $this->_helper->redirector->gotoRoute(array('module' => 'sesevent', 'controller' => 'payment','action'=>'return','type'=>'paytm'),'admin_default');
			break;
		}
  }
}
