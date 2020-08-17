<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SubscriptionController.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_SubscriptionController extends Core_Controller_Action_Standard
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
  protected $_subscription;

  /**
   * @var Payment_Model_Package
   */
  protected $_package;
  
  protected $merchant;
  protected $username;
  protected $password;
  protected $liveurl;
  protected $priceHashUrl;
  protected $refundUrl;
  protected $recurringUrl;
  protected $successText;
  protected $failedText;
  protected $gateway_profile_id;
  public function init()
  {
    // If there are no enabled gateways or packages, disable
    if( Engine_Api::_()->getDbtable('gateways', 'payment')->getEnabledGatewayCount() <= 0 ||
        Engine_Api::_()->getDbtable('packages', 'payment')->getEnabledNonFreePackageCount() <= 0 ) {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    }
    
    // Get user and session
    $this->_user = Engine_Api::_()->user()->getViewer();
    $this->_session = new Zend_Session_Namespace('Payment_Subscription');
    $settings = Engine_Api::_()->getApi('settings', 'core');
   
    $this->merchant        	= $settings->getSetting('sessegpay_eTicket');
    $this->username        	= $settings->getSetting('sessegpay_username');
    $this->password        	= $settings->getSetting('sessegpay_password');
    $this->liveurl         	= ('https://secure4.segpay.com/billing/poset.cgi'); 
    $this->priceHashUrl   	= ('http://srs.segpay.com/PricingHash/PricingHash.svc/GetDynamicTrans'); 
    $this->refundUrl       	= ('http://Srs.segpay.com/ADM.asmx/RefundTransaction'); 
    $this->recurringUrl    	= ('http://secure2.segpay.com/billing/poset.cgi'); 
    $this->successText = $settings->getSetting('sessegpay_successText','Transaction Successful');
    $this->failedText = $settings->getSetting('sessegpay_failedText','Transaction Failed');
    // Check viewer and user
    if( !$this->_user || !$this->_user->getIdentity() ) {
      if( !empty($this->_session->user_id) ) {
        $this->_user = Engine_Api::_()->getItem('user', $this->_session->user_id);
      }
      // If no user, redirect to home?
      if( !$this->_user || !$this->_user->getIdentity() ) {
        $this->_session->unsetAll();
        return $this->_helper->redirector->gotoRoute(array(), 'default', true);
      }
    }
  }
  public function gatewayAction()
  {
     // Get subscription
    $subscriptionId = $this->_getParam('subscription_id', $this->_session->subscription_id);
    if( !$subscriptionId ||
        !($subscription = Engine_Api::_()->getItem('payment_subscription', $subscriptionId))  ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'choose','module'=>'payment','controller'=>'subscription'));
    }
    $this->view->subscription = $subscription;
    
    // Check subscription status
    if( $this->_checkSubscriptionStatus($subscription) ) {
      return;
    }

    // Get subscription
    if( !$this->_user ||
        !($subscriptionId = $this->_getParam('subscription_id', $this->_session->subscription_id)) ||
        !($subscription = Engine_Api::_()->getItem('payment_subscription', $subscriptionId)) ||
        $subscription->user_id != $this->_user->getIdentity() ||
        !($package = Engine_Api::_()->getItem('payment_package', $subscription->package_id)) ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'choose','module'=>'payment','controller'=>'subscription'));
    }
    $this->view->subscription = $subscription;
    $this->view->package = $package;

    // Unset certain keys
    unset($this->_session->gateway_id);
    unset($this->_session->order_id);

    // Gateways
    $gatewayTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    $gatewaySelect = $gatewayTable->select()
      ->where('enabled = ?', 1)
      ;
    $gateways = $gatewayTable->fetchAll($gatewaySelect);

    $gatewayPlugins = array();
    foreach( $gateways as $gateway ) {
      // Check billing cycle support
      if( !$package->isOneTime() ) {
        $sbc = $gateway->getGateway()->getSupportedBillingCycles();
        if( !in_array($package->recurrence_type, array_map('strtolower', $sbc)) ) {
          continue;
        }
      }
      $gatewayPlugins[] = array(
        'gateway' => $gateway,
        'plugin' => $gateway->getGateway(),
      );
    }
    if(!$package->is_segpay)
      $this->view->gateways = $gatewayPlugins;

    if($package->is_segpay){
      //gateway
      $table = Engine_Api::_()->getDbTable('gateways','payment');
      $select = $table->select()->where('plugin =?','Sessegpay_Plugin_Gateway_Segpay')->limit(1);
      $this->view->segpaygateway = $table->fetchRow($select);
    }
    
  }
  public function processAction(){
    //gateway
    $table = Engine_Api::_()->getDbTable('gateways','payment');
    $select = $table->select()->where('plugin =?','Sessegpay_Plugin_Gateway_Segpay')->limit(1);
    $segpaygateway = $table->fetchRow($select);
    $gateway_id = $this->_getParam('gateway_id',0);
    if(!$segpaygateway || $gateway_id != $segpaygateway->getIdentity())
        return $this->_helper->redirector->gotoRoute(array('action' => 'process','module'=>'payment','controller'=>'subscription','gateway_id'=>$gateway_id));
    
    $gateway = Engine_Api::_()->getItem('payment_gateway', $gateway_id);
    $this->view->gateway = $gateway;
    // Get subscription
    
    $subscriptionId = $this->_getParam('subscription_id', $this->_session->subscription_id);
    if( !$subscriptionId ||
        !($subscription = Engine_Api::_()->getItem('payment_subscription', $subscriptionId))  ) {
       return $this->_helper->redirector->gotoRoute(array('action' => 'choose','module'=>'payment','controller'=>'subscription'));
    }
    $subscription->gateway_id = $gateway_id;
    $subscription->save();
    $this->view->subscription = $subscription;
    
    // Get package
    $package = $subscription->getPackage();
    if( !$package || $package->isFree() ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'choose','module'=>'payment','controller'=>'subscription'));
    }
    $this->view->package = $package;
    // Check subscription?
    if( $this->_checkSubscriptionStatus($subscription) ) {
      return;
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
      'source_type' => 'payment_subscription',
      'source_id' => $subscription->subscription_id,
    ));
    $this->_session->order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();

    // Unset certain keys
    unset($this->_session->package_id);
    unset($this->_session->subscription_id);
    unset($this->_session->gateway_id);

    // Get gateway plugin
    //$this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
    //$plugin = $gateway->getPlugin();


    // Prepare host info
    $schema = _ENGINE_SSL ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    
    $return_url = $schema . $host
      . $this->view->url(array('action' => 'return'))
      . '?order_id=' . $order_id. '&state=' . 'return';
    $cancel_url = $schema . $host
      . $this->view->url(array('action' => 'return'))
      . '?order_id=' . $order_id
      . '&state=' . 'cancel';
    
    
    if(!$package->type){
      $segpay_args 	= $this->get_segpay_args( $order,$package,$return_url,$cancel_url );
      $str = $this->Encode($segpay_args);
      $processURI	= $this->liveurl;
    }else{
      $DynamicPricingID 	= $this->get_segpay_recurringargs( $order,$package,$return_url,$cancel_url );
      $this->_session->gateway_profile_id = $DynamicPricingID;
      $order_id 	= $order_id;
			$user_ID 	= $this->_user->user_id;
      // Segpay Args
			$segpay_args	= array(
				// Order key + ID
				'userId'   		=> $user_ID,
        'DynamicPricingID'=>$DynamicPricingID,
				'invoiceId' 	=> $order_id,
				'dynamicdesc'	=> 'Shopping Cart',
				// Billing Address info
				'x-billname'	  => $this->_user->getTitle(),
				'x-billemail'  	=> $this->_user->email,
				'x-auth-link'   => (($return_url)),
        'segpay_notify' => 1,
				'x-decl-link'	=> (($cancel_url)),
				'x-auth-text'   => $this->successText,
				'x-decl-text'   => $this->failedText,
			);		
      $str = $this->Encode($segpay_args);
      $processURI = $this->recurringUrl;
    }
    $merchant = $package->packagesegpay_id	.':'.$package->pricepointsegpay_id;
    $this->view->transactionUrl = $link	= $processURI."?x-eticketid=".$merchant.$str;
  }
  
  function get_segpay_recurringargs( $order,$package,$return_url,$cancel_url){
			$url	= ("https://srs.segpay.com/MerchantServices/DynamicRecurring?MerchantID=21642&InitialAmount=".$package->initial_price."&InitialLength=".$package->initial_length."&RecurringAmount=".$package->price."&RecurringLength=".$package->recurring_length.'&Username='.$this->username.'&Password='.$this->password);
      $cmd = "curl -u ".$this->username.":".$this->password." '".$url."'";
      exec($cmd,$result);
      $data = str_replace('"','',$result[0]);
			$dynamictrans	= (string)$data;
			$this->_session->gateway_profile_id = $dynamictrans;
      return $dynamictrans;
  }
  function returnAction(){
    // Get order
    if( !$this->_user ||
        !($orderId = $this->_getParam('order_id', $this->_session->order_id)) ||
        !($order = Engine_Api::_()->getItem('payment_order', $orderId)) ||
        $order->user_id != $this->_user->getIdentity() ||
        $order->source_type != 'payment_subscription' ||
        !($subscription = $order->getSource()) ||
        !($package = $subscription->getPackage()) ||
        !($gateway = Engine_Api::_()->getItem('payment_gateway', $order->gateway_id)) ) {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    }
    $gateway_profile_id = $this->_session->gateway_profile_id;
    // Process return
    unset($this->_session->errorMessage);
    try {
     $getAllParams = $this->_getAllParams();     
      $status = Engine_Api::_()->sessegpay()->updateUser($order, $this->_getAllParams(),$gateway_profile_id);
    } catch( Exception $e ) {
      $status = 'failure';
      unset($this->_session->gateway_profile_id);
      $this->_session->errorMessage = $e->getMessage();
    }
    return $this->_finishPayment($status);  
  }
    
   	/**
		* Get Segpay Args for passing to PP
		*
		* @access public
		* @param mixed $order
		* @return array
		*/
		function get_segpay_args( $order,$package,$return_url,$cancel_url )
		{
			$order_id 	= $order->order_id;
			$user_ID 	= $this->_user->user_id;
			
			
			$getResponse	= file_get_contents($this->priceHashUrl."?value=".$package->price);
			$getXml			= simplexml_load_string($getResponse);
			$dynamictrans	= (string)$getXml;
			$this->_session->gateway_profile_id = $dynamictrans;
			// Segpay Args
			$segpay_args	= array(
				// Order key + ID
				'userId'   		=> $user_ID,
				'invoiceId' 	=> $order_id,
				'amount'    	=> $package->price,
				'dynamicdesc'	=> 'Shopping Cart',
				'dynamictrans'	=> urldecode($dynamictrans),
        'segpay_notify' =>1,
				// Billing Address info
				'x-billname'	  => $this->_user->getTitle(),
				'x-billemail'  	=> $this->_user->email,
				'x-billaddr'   	=> '',
				'x-billzip'    	=> '',//$order->billing_postcode,
				'x-billcntry'   => '',//$order->billing_country,
				'x-auth-link'   => (($return_url)),
				'x-decl-link'	=> (($cancel_url)),
				'x-auth-text'   => $this->successText,//$this->authText,
				'x-decl-text'   => $this->failedText,//$this->decText
			);		
			return $segpay_args;
		}
  /**
		* Generate Segpay button link
		**/
		public function Encode($segpay_args)
		{
			$encodedRetStr 		= "";
			foreach($segpay_args as $key => $value)
			{
				$encodedRetStr .= "&".$key."=".urlencode($value);
			}
			return $encodedRetStr;
		}
    protected function _checkSubscriptionStatus(
      Zend_Db_Table_Row_Abstract $subscription = null)
  {
    if( !$this->_user ) {
      return false;
    }

    if( null === $subscription ) {
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
      $subscription = $subscriptionsTable->fetchRow(array(
        'user_id = ?' => $this->_user->getIdentity(),
        'active = ?' => true,
      ));
    }

    if( !$subscription ) {
      return false;
    }
    
    if( $subscription->status == 'active' ||
        $subscription->status == 'trial' ) {
      if( !$subscription->getPackage()->isFree() ) {
        $this->_finishPayment('active');
      } else {
        $this->_finishPayment('free');
      }
      return true;
    } else if( $subscription->status == 'pending' ) {
      $this->_finishPayment('pending');
      return true;
    }
    
    return false;
  }
  protected function _finishPayment($state = 'active')
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $user = $this->_user;

    // No user?
    if( !$this->_user ) {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    }

    // Log the user in, if they aren't already
    if( ($state == 'active' || $state == 'free') &&
        $this->_user &&
        !$this->_user->isSelf($viewer) &&
        !$viewer->getIdentity() ) {
      Zend_Auth::getInstance()->getStorage()->write($this->_user->getIdentity());
      Engine_Api::_()->user()->setViewer();
      $viewer = $this->_user;
    }

    // Handle email verification or pending approval
    if( $viewer->getIdentity() && !$viewer->enabled ) {
      Engine_Api::_()->user()->setViewer(null);
      Engine_Api::_()->user()->getAuth()->getStorage()->clear();

      $confirmSession = new Zend_Session_Namespace('Signup_Confirm');
      $confirmSession->approved = $viewer->approved;
      $confirmSession->verified = $viewer->verified;
      $confirmSession->enabled  = $viewer->enabled;
      return $this->_helper->_redirector->gotoRoute(array('action' => 'confirm'), 'user_signup', true);
    }
    
    // Clear session
    $errorMessage = $this->_session->errorMessage;
    $userIdentity = $this->_session->user_id;
    $this->_session->unsetAll();
    $this->_session->user_id = $userIdentity;
    $this->_session->errorMessage = $errorMessage;

    // Redirect
    if( $state == 'free' ) {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    } else {
      return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state,'module'=>'payment','controller'=>'subscription'));
    }
  }
    
}
