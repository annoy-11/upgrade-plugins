<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Paytm.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
include_once APPLICATION_PATH . "/application/modules/Epaytm/Api/PaytmKit/lib/encdec_paytm.php";
class Epaytm_Plugin_Gateway_Paytm extends Engine_Payment_Plugin_Abstract
{
  protected $_gatewayInfo;
  protected $_gateway;
  public function __construct(Zend_Db_Table_Row_Abstract $gatewayInfo)
  {
    $this->_gatewayInfo = $gatewayInfo;
  }
  public function getService()
  {
    return $this->getGateway()->getService();
  }
  public function getGateway()
  {
    if( null === $this->_gateway ) {
        $class = 'Epaytm_Gateways_Paytm';
        Engine_Loader::loadClass($class);
        $gateway = new $class(array(
        'config' => (array) $this->_gatewayInfo->config,
        'testMode' => $this->_gatewayInfo->test_mode,
        'currency' => Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD'),
      ));
      if( !($gateway instanceof Engine_Payment_Gateway) ) {
        throw new Engine_Exception('Plugin class not instance of Engine_Payment_Gateway');
      }
      $this->_gateway = $gateway;
    }
    return $this->_gateway;
  }
  public function createTransaction(array $params)
  {
    $transaction = new Engine_Payment_Transaction($params);
    $transaction->process($this->getGateway());
    return $transaction;
  }
  public function createIpn(array $params)
  {
    $ipn = new Engine_Payment_Ipn($params);
    $ipn->process($this->getGateway());
    return $ipn;
  }
  public function createSubscriptionTransaction(User_Model_User $user,
      Zend_Db_Table_Row_Abstract $subscription,
      Payment_Model_Package $package,
      array $params = array())
  {
    // Process description
    $desc = $package->getPackageDescription();
    if( strlen($desc) > 127 ) {
      $desc = substr($desc, 0, 124) . '...';
    } else if( !$desc || strlen($desc) <= 0 ) {
      $desc = 'N/A';
    }
    if( function_exists('iconv') && strlen($desc) != iconv_strlen($desc) ) {
      // PayPal requires that DESC be single-byte characters
      $desc = @iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
    }
    // This is a one-time fee
    if( $package->isOneTime() ) {
        $paytmParams  = array(
          /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
          "MID" => $this->_gatewayInfo->config['paytm_marchant_id'],
          /* Find your WEBSITE in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
          "WEBSITE" => $this->_gatewayInfo->config['paytm_website'],
          /* Find your INDUSTRY_TYPE_ID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
          "INDUSTRY_TYPE_ID" => $this->_gatewayInfo->config['paytm_industry_type'],
          /* WEB for website and WAP for Mobile-websites or App */
          "CHANNEL_ID" => $this->_gatewayInfo->config['paytm_channel_id'],
          /* Enter your unique order id */
          "ORDER_ID" => $params['vendor_order_id'],
          /* unique id that belongs to your customer */
          "CUST_ID" => $subscription->subscription_id,
          /* customer's mobile number */
          /**
          * Amount in INR that is payble by customer
          * this should be numeric with optionally having two decimal points
          */
          "TXN_AMOUNT" =>  $params['amount'],
          /* on completion of transaction, we will send you the response on this URL */
          "CALLBACK_URL" => $params['return_url'],
        );
    }
    // This is a recurring subscription
    else { 
      $addTime = $package->duration == 1 ? "+".$package->duration.' '.$package->duration_type : "+".$package->duration.' '.$package->duration_type.'s';
      $paytmParams = array(
        "REQUEST_TYPE"			=> "SUBSCRIBE",
        "MID"					=> $this->_gatewayInfo->config['paytm_marchant_id'],
        "WEBSITE"				=> $this->_gatewayInfo->config['paytm_website'],
        "INDUSTRY_TYPE_ID"	    => $this->_gatewayInfo->config['paytm_industry_type'],
        "CHANNEL_ID" 			=> $this->_gatewayInfo->config['paytm_channel_id'],
        "ORDER_ID" 			=> $params['vendor_order_id'],
        "CUST_ID"				=> $params['user_id'],
        "TXN_AMOUNT"			=> $params['amount'],
        "SUBS_AMOUNT_TYPE" 	=> "VARIABLE",
        "SUBS_MAX_AMOUNT"		=> $params['amount'],
        "SUBS_FREQUENCY_UNIT"  => strtoupper($package->recurrence_type),
        "SUBS_FREQUENCY"		=> $package->recurrence,
        "SUBS_ENABLE_RETRY"	=> "1",
        "SUBS_START_DATE"		=> date('Y-m-d'),
        "SUBS_EXPIRY_DATE"	    => date('Y-m-d',strtotime($addTime,strtotime(date('Y-m-d')))),
        "SUBS_PPI_ONLY"		=> "N",
        "SUBS_PAYMENT_MODE"	=> "CC",
        "SUBS_GRACE_DAYS"		=> "1",
        "CALLBACK_URL"			=> $params['return_url']
      );
    }
    return $paytmParams;
    // Create transaction
  }
  public function onSubscriptionReturn(
      Payment_Model_Order $order,$transaction)
  {}
  public function onSubscriptionTransactionReturn(Payment_Model_Order $order,array $params = array()){
    if( $order->gateway_id != $this->_gatewayInfo->gateway_id ) {
      throw new Engine_Payment_Plugin_Exception('Gateways do not match');
    }
    // Get related info
    $user = $order->getUser();
    $subscription = $order->getSource();
    $package = $subscription->getPackage();
    // Check subscription state
    if( $subscription->status == 'active' ||
        $subscription->status == 'trial') {
      return 'active';
    } else if( $subscription->status == 'pending' ) {
      return 'pending';
    }
    // Check for cancel state - the user cancelled the transaction
    if($params['STATUS'] == 'TXN_FAILURE' ) {
      // Cancel order and subscription?
      $order->onCancel();
      $subscription->onPaymentFailure();
      // Error
      throw new Payment_Model_Exception('Your payment has been cancelled and ' .
          'not been charged. If this is not correct, please try again later.');
    }
          // Get payment state
    $paymentStatus = null;
    $orderStatus = null;
    switch($params['STATUS']) {
      case 'created':
      case 'pending':
        $paymentStatus = 'pending';
        $orderStatus = 'complete';
        break;
      case 'active':
      case 'succeeded':
      case 'completed':
      case 'processed':
      case 'TXN_SUCCESS': // Probably doesn't apply
        $paymentStatus = 'okay';
        $orderStatus = 'complete';
        break;
      case 'denied':
      case "TXN_FAILURE": 
        $paymentStatus = 'failed';
        $orderStatus = 'failed'; 
      case 'voided': // Probably doesn't apply
      case 'reversed': // Probably doesn't apply
      case 'refunded': // Probably doesn't apply
      case 'TXN_FAILURE':  // Probably doesn't apply
      default: // No idea what's going on here
        $paymentStatus = 'failed';
        $orderStatus = 'failed'; // This should probably be 'failed'
        break;
    }
      
//     // One-time
    if($package->isOneTime()) {
      // Update order with profile info and complete status?
      $order->state = $orderStatus;
      $order->gateway_transaction_id = $params['TXNID'];
      $order->save();
      // Insert transaction
      $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');
      $transactionsTable->insert(array(
        'user_id' => $order->user_id,
        'gateway_id' => $this->_gatewayInfo->gateway_id,
        'timestamp' => new Zend_Db_Expr('NOW()'),
        'order_id' => $order->order_id,
        'type' => 'payment',
        'state' => $paymentStatus,
        'gateway_transaction_id' => $params['TXNID'], 
        'amount' => $params['TXNAMOUNT'], // @todo use this or gross (-fee)?
        'currency' => $params['CURRENCY'],
      ));
      $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
      // Get benefit setting
      $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')
          ->getBenefitStatus($user);
      // Check payment status
      if( $paymentStatus == 'okay' ||
          ($paymentStatus == 'pending' && $giveBenefit) ) {
        // Update subscription info
        $subscription->gateway_id = $this->_gatewayInfo->gateway_id;
        $subscription->gateway_profile_id = $params['TXNID'];
        // Payment success
        $subscription->onPaymentSuccess();
        $paymentTransaction = Engine_Api::_()->getItem('payment_transaction', $transaction_id);
        //For Coupon
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')){
          $couponSessionCode = $package->getType().'-'.$package->package_id.'-'.$subscription->getType().'-'.$subscription->subscription_id.'-1';
          $paymentTransaction->ordercoupon_id = Engine_Api::_()->ecoupon()->setAppliedCouponDetails($couponSessionCode);
          $paymentTransaction->save();
        }
        //For Credit 
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescredit')) {
           $creditCode =  'credit'.'-payment-'.$package->package_id.'-'.$subscription->subscription_id;
          $sessionCredit = new Zend_Session_Namespace($creditCode);
          if(isset($sessionCredit->credit_value)){
            $paymentTransaction->credit_point = $sessionCredit->credit_value;  
            $paymentTransaction->credit_value =  $sessionCredit->purchaseValue;
            $paymentTransaction->save();
            $userCreditDetailTable = Engine_Api::_()->getDbTable('details', 'sescredit');
            $userCreditDetailTable->update(array('total_credit' => new Zend_Db_Expr('total_credit - ' . $sessionCredit->credit_value)), array('owner_id =?' => $order->user_id));
          }
        }
        // send notification
        if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }
        return 'active';
      }
      else if( $paymentStatus == 'pending' ) {
        // Update subscription info
        $subscription->gateway_id = $this->_gatewayInfo->gateway_id;
        $subscription->gateway_profile_id = $params['TXNID'];
        // Payment pending
        $subscription->onPaymentPending();
        // send notification
        if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_pending', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }
        return 'pending';
      }
      else if( $paymentStatus == 'failed' ) {
        // Cancel order and subscription?
        $order->onFailure();
        $subscription->onPaymentFailure();
        // Payment failed
        throw new Payment_Model_Exception('Your payment could not be ' .
            'completed. Please ensure there are sufficient available funds ' .
            'in your account.');
      }
      else {
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
            'transaction. Please try again later.');
      }
    } // For Recurring Payment
    else {
      // Create recurring payments profile
      $desc = $package->getPackageDescription();
      if( strlen($desc) > 127 ) {
        $desc = substr($desc, 0, 124) . '...';
      } else if( !$desc || strlen($desc) <= 0 ) {
        $desc = 'N/A';
      }
      if( function_exists('iconv') && strlen($desc) != iconv_strlen($desc) ) {
        // PayPal requires that DESC be single-byte characters
        $desc = @iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
      }
      $order->state = 'complete';
      $order->gateway_order_id = $params['order_id'];
      $order->gateway_transaction_id = $params['TXNID'];
      $order->save();
      $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');
      $transactionsTable->insert(array(
        'user_id' => $order->user_id,
        'gateway_id' => $this->_gatewayInfo->gateway_id,
        'timestamp' => new Zend_Db_Expr('NOW()'),
        'order_id' => $order->order_id,
        'type' => 'payment',
        'state' => $paymentStatus,
        'gateway_transaction_id' => $params['TXNID'], 
        'amount' => $params['TXNAMOUNT'], // @todo use this or gross (-fee)?
        'currency' => $params['CURRENCY'],
      ));
      $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
      $transaction = Engine_Api::_()->getItem('payment_transaction', $transaction_id);
      // Get benefit setting
      $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')
          ->getBenefitStatus($user);
      // Check profile status
      if($giveBenefit) {
        // Enable now
        $subscription->gateway_id = $this->_gatewayInfo->gateway_id;
        $subscription->gateway_profile_id = $params['SUBS_ID'];
        $subscription->onPaymentSuccess();
        Engine_Api::_()->epaytm()->updateRenewal($transaction,$package);
        // send notification
        if( $subscription->didStatusChange()) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }
        return 'active';
      } else if($paymentStatus == 'pending') {
        // Enable later
        $subscription->gateway_id = $this->_gatewayInfo->gateway_id;
        $subscription->gateway_profile_id = $params['SUBS_ID'];
        $subscription->onPaymentPending();
        // send notification
        if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_pending', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }
        return 'pending';
      } else {
        // Cancel order and subscription?
        $order->onFailure();
        $subscription->onPaymentFailure();
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
            'transaction. Please try again later.');
      }
    }
  }
  public function onSubscriptionTransactionIpn(
      Payment_Model_Order $order,
      Engine_Payment_Ipn $ipn)
  {
  }
  public function cancelSubscription($transactionId, $note = null)
  {
    $paytmParams = array();
    $paytmParams['body'] = array(
        "mid"			=> $this->_gatewayInfo->config['paytm_marchant_id'],
        "subsId"		=> $transactionId,
    );
    $checksum = getChecksumFromString(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), $this->_gatewayInfo->config['paytm_secret_key']);
    $paytmParams["head"] = array(
        "version" => "V1",
        "requestTimestamp" => time(),
        "tokenType" => "AES",
        "signature" => $checksum
    );
    if($this->_gatewayInfo->test_mode){
      $url = 'https://securegw-stage.paytm.in/subscription/cancel'; // for staging
    } else {
      $url = 'https://securegw.paytm.in/subscription/cancel'; // for production
    }
    $post_fields = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    return $this;
  }
  /**
   * Generate href to a page detailing the order
   *
   * @param string $transactionId
   * @return string
   */
  public function getOrderDetailLink($orderId)
  {
    if( $this->getGateway()->getTestMode() ) {
      // Note: it doesn't work in test mode
      return 'https://dashboard.paytm.com/next/transactions';
    } else {
      return 'https://dashboard.paytm.com/next/transactions';
    }
  }
  public function getTransactionDetailLink($transactionId)
  {
    if( $this->getGateway()->getTestMode() ) {
      // Note: it doesn't work in test mode
      return 'https://dashboard.paytm.com/next/transactions';
    } else {
      return 'https://dashboard.paytm.com/next/transactions';
    }
  }
  public function getOrderDetails($orderId)
  {
    try {
      return $this->getService()->detailRecurringPaymentsProfile($orderId);
    } catch( Exception $e ) {
      echo $e;
    }
    try {
      return $this->getTransactionDetails($orderId);
    } catch( Exception $e ) {
      echo $e;
    }
    return false;
  }
  public function getTransactionDetails($transactionId)
  {
    return $this->getService()->detailTransaction($transactionId);
  }
  public function createOrderTransactionReturn($order,$transaction) {  
    $user = $order->getUser();
    $viewer = Engine_Api::_()->user()->getViewer();
    $orderPayment = $order->getSource();
    $paymentOrder = $order;
    switch($transaction["STATUS"]) {
        case 'created':
        case 'pending':
            $paymentStatus = 'pending';
            $orderStatus = 'complete';
        break;
        case "TXN_SUCCESS":
            $paymentStatus = 'okay';
            $orderStatus = 'complete';
        break;
        case 'denied':
        case "TXN_FAILURE": 
          $paymentStatus = 'okay';
          $orderStatus = 'failed'; 
        break;
        case 'voided':
        case 'reversed':
        case 'refunded':
        case 'expired':
        default:
            $paymentStatus = $transaction["STATUS"];
            $orderStatus = $transaction["STATUS"]; // This should probably be 'failed'
        break;
    }
    $transactionId = isset($transaction['TXNID']) ? $transaction['TXNID'] : '';
    if($order->source_type == "sescrowdfunding_order") {
        $currentCurrency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
        $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency();
        $settings = Engine_Api::_()->getApi('settings', 'core');
          $currencyValue = 1;
        if($currentCurrency != $defaultCurrency) {
            $currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
        }
        $order->state = $orderStatus;
        $order->gateway_transaction_id = $transactionId;
        $order->save();
         $crowdfundingItem = Engine_Api::_()->getItem('crowdfunding', $orderPayment->crowdfunding_id);
        $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')->getBenefitStatus($user);
        // Insert transaction
        $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');
        $transactionsTable->insert(array(
            'user_id' => $order->user_id,
            'gateway_id' =>2,
            'timestamp' => new Zend_Db_Expr('NOW()'),
            'order_id' => $order->order_id,
            'type' => 'payment',
            'state' => $paymentStatus,
            'gateway_transaction_id' => $transaction['CURRENCY'],
            'amount' => $transaction['TXNAMOUNT'], // @todo use this or gross (-fee)?
            'currency' => $transaction['CURRENCY'],
        ));
        if( $paymentStatus == 'okay' || ($paymentStatus == 'pending' && $giveBenefit) ) {
            $orderPayment->change_rate = $currencyValue;
            $orderPayment->gateway_id = $this->_gatewayInfo->gateway_id;
            $orderPayment->gateway_transaction_id = $transactionId;
            $orderPayment->currency_symbol = $transaction['CURRENCY'];
            $orderPayment->save();
            //update OWNER REMAINING amount
            $orderAmount = @round(($orderPayment->total_useramount/$currencyValue),2);
            $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'sescrowdfunding');
            $tableName = $tableRemaining->info('name');
            $select = $tableRemaining->select()->from($tableName)->where('crowdfunding_id =?',$crowdfundingItem->crowdfunding_id);
            $select = $tableRemaining->fetchAll($select);
            if(count($select)){
                $tableRemaining->update(array('remaining_payment' => new Zend_Db_Expr("remaining_payment + $orderAmount")),array('crowdfunding_id =?'=>$crowdfundingItem->crowdfunding_id));
            } else {
                $tableRemaining->insert(array(
                    'remaining_payment' => $orderAmount,
                    'crowdfunding_id' => $crowdfundingItem->crowdfunding_id,
                ));
            }
            Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->update(array('state' => 'complete'), array('order_id =?' => $orderPayment->order_id));
            // Payment success
            $orderPayment->onOrderComplete();
            // send notification
            if( $orderPayment->state == 'complete' ) {
                $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $orderPayment->crowdfunding_id);
                $total_amount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($orderPayment->total_amount, $orderPayment->currency_symbol);
                $total_useramount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($orderPayment->total_useramount, $orderPayment->currency_symbol);
                $commissionType = Engine_Api::_()->authorization()->getPermission($user,'crowdfunding','admin_commission');
                $commissionTypeValue = Engine_Api::_()->authorization()->getPermission($user,'crowdfunding','commission_value');
                //%age wise
                if($commissionType == 1 && $commissionTypeValue > 0){
                    $orderPayment->commission_amount = round(($orderPayment->total_amount/$currencyValue) * ($commissionTypeValue/100),2);
                    $orderPayment->save();
                } else if($commissionType == 2 && $commissionTypeValue > 0) {
                    $orderPayment->commission_amount = $commissionTypeValue;
                    $orderPayment->save();
                }
                $commission_amount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($orderPayment->commission_amount, $orderPayment->currency_symbol);
                $crowdfundingPhoto = ( isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] .Zend_Registry::get('StaticBaseUrl') . $crowdfunding->getPhotoUrl();
                $body = '<table cellpadding="0" cellspacing="0" style="background:#f0f4f5;border:3px solid #f1f4f5;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;max-width:608px;padding:0;text-align:center;vertical-align:top;width:450px;max-width:100%;font-family: Arial,Helvetica,sans-serif;"><tr><td style="text-align:center;padding:10px;"><table cellpadding="0" cellspacing="0" style="width:100%;"><tr><td style="padding:10px 0;color:#555;font-size:13px;">Free stock photos of crowdfunding · Pexels</td></tr><tr><td style="background-color:#fff;text-align:center;"><div style="width:150px;height:150px;float:left;"><a href="'.$crowdfunding->getHref().'"><img src="'.$crowdfundingPhoto.'" alt="" style="width:100%;height:100%;object-fit:cover;" /></a></div><div style="display: block; overflow: hidden; padding: 10px; text-align: left;"><a href="'.$crowdfunding->getHref().'" style="color: rgb(85, 85, 85); font-size: 17px; text-decoration: none; font-weight: bold;">'.$crowdfunding->getTitle().'</a></div></td></tr><tr><td style="height:20px;"></td></tr><tr><td><table style="color:#555;border:1px solid #ddd;background-color: rgb(255, 255, 255); width: 100%;font-size:13px;" cellspacing="0" cellpadding="10"><tbody><tr>';
                $body .= '<td align="left">Price</td><td align="right"><strong>'.$total_useramount.'</strong></td></tr><tr>';
                $body .= '<td align="left" style="border-top:1px dashed #ddd;">Total Paid</td>';
                $body .= '<td align="right" style="border-top:1px dashed #ddd;"><strong>'.$total_useramount.'</strong></td></tr></tbody></table></td></tr></table></td></tr></table>';
                //Notification send to Crowdfunding Owner When some one donate amount
                $crowdfunding->donate_count++;
                $crowdfunding->save();
                $user = Engine_Api::_()->getItem('user', $orderPayment->user_id);
                $owner = $crowdfunding->getOwner();
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $user, $crowdfunding, 'sescrowdfunding_donation_owner');
                //Donate invoice mail to doner
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'sescrowdfundinginvoice_doner', array('invoice_body' => $body, 'host' => $_SERVER['HTTP_HOST']));
                //Crowdfunding Purchased Mail to Crowdfunding Owner
                $owner = Engine_Api::_()->getItem('user', $crowdfunding->owner_id);
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'sescrowdfunding_donation_owner', array('crowdfunding_title' => $crowdfunding->getTitle(), 'object_link' => $user->getHref(), 'buyer_name' => $user->getTitle(), 'host' => $_SERVER['HTTP_HOST']));
                //Crowdfunding donation Mail send to admin
                $usersTable = Engine_Api::_()->getDbtable('users', 'user');
                $usersTableName = $usersTable->info('name');
                $datas = $usersTable->select()->from($usersTableName, array('user_id'))->where('level_id =?', 1)->query()->fetchAll();
                foreach($datas as $data) {
                $adminUser = Engine_Api::_()->getItem('user', $data['user_id']);
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($adminUser, 'sescrowdfunding_donation_adminemail', array('crowdfunding_title' => $crowdfunding->getTitle(), 'object_link' => $user->getHref(), 'buyer_name' => $user->getTitle(), 'host' => $_SERVER['HTTP_HOST'], 'total_amount' => $total_amount, 'total_useramount' => $total_useramount, 'commission_amount' => $commission_amount));
                }
            }
            $orderPayment->creation_date	= date('Y-m-d H:i:s');
            $orderPayment->save();
            return 'active';
        }
    } else if($order->source_type == "sesproduct_order") {
        $order->state = $orderStatus;
        $order->gateway_transaction_id = $transactionId;
        $order->save();
        $session = new Zend_Session_Namespace('Payment_Sesproduct');
        //check product variations
        $orderTableName = Engine_Api::_()->getDbTable('orders','sesproduct');
        $select = $orderTableName->select()->where('parent_order_id =?',$orderPayment->getIdentity());
        $orders = $orderTableName->fetchAll($select);
        $orderIds = array();
        $storeIds = array();
        $totalPrice = 0;
        foreach ($orders as $order){
            $orderIds[] = $order->getIdentity();
            $totalPrice +=$order->total;
            $order->state = "processing";
            $order->save();
            //For Coupon
            $ordercoupon_id = 0;
            if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')){
              $couponSessionCode = '-'.'-stores-'.$order->store_id.'-0';
              $ordercoupon_id = Engine_Api::_()->ecoupon()->setAppliedCouponDetails($couponSessionCode);
            }
            $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sesproduct');
            $transactionsTable->insert(array(
                'owner_id' => $order->user_id,
                'gateway_id' => $this->_gatewayInfo->gateway_id,
                'gateway_transaction_id' => $transactionId,
                'gateway_profile_id' => $transactionId,
                'creation_date' => new Zend_Db_Expr('NOW()'),
                'modified_date' => new Zend_Db_Expr('NOW()'),
                'order_id' => $order->order_id,
                'state' => $paymentStatus,
                'total_amount' => $order->total,
                'change_rate' => 1,
                'gateway_type' => 'Paytm',
                'ordercoupon_id'=> $ordercoupon_id,
                'currency_symbol' => $transaction['CURRENCY'], 
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            ));
            $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
            $storeIds[]  = $order->store_id;
        }
      //get all order products
        $productTableName = Engine_Api::_()->getDbTable('orderproducts','sesproduct');
        $select = $productTableName->select()->where('order_id IN (?)', $orderIds);
        $products = $productTableName->fetchAll($select);
      // Get benefit setting
        $giveBenefit = // Get benefit setting
        $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'sesproduct')
            ->getBenefitStatus($user);
        //Check payment status
        if ($paymentStatus == 'okay' || $paymentStatus == 'active' ||
                ($paymentStatus == 'pending' && $giveBenefit)) {
            // Payment success
            try{
                Engine_Api::_()->sesproduct()->orderComplete($orderPayment,$products);
            }catch(Exception $e){
                throw new Payment_Model_Exception($e->getMessage());
            }
            // send notification
            try {
                    $getAdminnSuperAdmins = Engine_Api::_()->sesproduct()->getAdminnSuperAdmins();
                    $counter = 0;
                    $storeIds = array_unique($storeIds);
                    foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
                        $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
                        foreach($storeIds as $storeid) {
                            $store = Engine_Api::_()->getItem('stores', $storeid);
                            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'sesproduct_product_orderplaced', array('sender_title' => $store->getOwner()->getTitle(), 'object_link' => $store->getHref(),'gateway_name'=>'paypal','buyer_name'=>$viewer->getTitle(),'host' => $_SERVER['HTTP_HOST']));

                            Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer->email, 'sesproduct_product_orderplacedtobuyer', array('host' => $_SERVER['HTTP_HOST'], 'order_id'=>$paymentOrder->order_id,'gateway_name'=>'paypal','buyer_name'=>$viewer->getTitle(),'object_link' => $store->getHref()));

                            if($counter)
                                Continue;
                            Engine_Api::_()->getApi('mail', 'core')->sendSystem($store->getOwner()->email, 'sesproduct_product_orderplaced', array('host' => $_SERVER['HTTP_HOST'], 'order_id'=>$paymentOrder->order_id,'gateway_name'=>'paypal','buyer_name'=>$viewer->getTitle(),'object_link' => $store->getHref()));
                        }
                        $counter++;
                }
            }catch(Exception $e){}
            return 'active';
        }
    } elseif($transaction['type'] == "courses") {
        $order->state = $orderStatus;
        $order->gateway_transaction_id = $transactionId;
        $order->save();
        $session = new Zend_Session_Namespace('Payment_Courses');
         $currency = $session->currency;
        $rate = $session->change_rate;
        if (!$rate)
            $rate = 1;
        $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency();
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $currencyValue = 1;
        if ($currency != $defaultCurrency)
            $currencyValue = $settings->getSetting('sesmultiplecurrency.' . $currency);
        //Insert transaction
        //check product variations
        $orderTableName = Engine_Api::_()->getDbTable('orders','courses');
        $select = $orderTableName->select()->where('order_id =?',$orderPayment->getIdentity());
        $order = $orderTableName->fetchRow($select);
        $order->gateway_transaction_id = $transactionId;
        $order->save();
        $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'courses');
        $transactionsTable->insert(array(
            'owner_id' => $order->user_id,
            'gateway_id' => $this->_gatewayInfo->gateway_id,
            'gateway_transaction_id' => $transactionId,
            'gateway_profile_id' => $transactionId,
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'modified_date' => new Zend_Db_Expr('NOW()'),
            'order_id' => $order->order_id,
            'state' => $paymentStatus,
            'item_count'=> $order->item_count,
            'total_amount' => $order->total_amount,
            'change_rate' => $rate,
            'gateway_type' => 'Paytm',
            'currency_symbol' => $currency,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ));
        $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
      //get all order products
        $coursesTableName = Engine_Api::_()->getDbTable('ordercourses','courses');
        $select = $coursesTableName->select()->where('order_id =?',$orderPayment->getIdentity());
        $courses = $coursesTableName->fetchAll($select);
      // Get benefit setting
        $giveBenefit = // Get benefit setting
        $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'courses')
            ->getBenefitStatus($user);
        //Check payment status
        if ($paymentStatus == 'okay' || $paymentStatus == 'active' ||
                ($paymentStatus == 'pending' && $giveBenefit)) {
            // Payment success
            try{
                Engine_Api::_()->courses()->orderComplete($orderPayment,$courses);
            }catch(Exception $e){
                throw new Payment_Model_Exception($e->getMessage());
            }
            return 'active';
        }
    } elseif($order->source_type == "sescredit_orderdetail") {
        // Update order with profile info and complete status?
        $order->state = $orderStatus;
        $order->gateway_transaction_id = $transactionId;
        $order->save();
        $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sescredit');
        $transactionsTable->insert(array(
            'owner_id' => $order->user_id,
            'gateway_id' => $this->_gatewayInfo->gateway_id,
            'gateway_transaction_id' => $transactionId,
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'modified_date' => new Zend_Db_Expr('NOW()'),
            'order_id' => $order->order_id,
            'total_amount' => $transaction['TXNAMOUNT'],
            'change_rate' => 1, 
            'state' => 'initial',
            'gateway_type' => 'Paytm', 
            'currency_symbol' => $transaction['INR'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ));
        $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
        $orderPayment->transaction_id = $transaction_id;
        $orderPayment->save();
        // Get benefit setting
        $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'sescredit')
                ->getBenefitStatus($user);
        if ($paymentStatus == 'okay' || $paymentStatus == 'active' ||
                ($paymentStatus == 'pending' && $giveBenefit)) { 
                $orderPayment->onPaymentSuccess();
            return 'active';
        }
    } elseif($order->source_type == "sesevent_order") { 
        if(!$orderPayment->ragistration_number){
            $orderPayment->ragistration_number = Engine_Api::_()->sesevent()->generateTicketCode(8);
            $orderPayment->save();
        } 
        return Engine_Api::_()->sesevent()->orderTicketTransactionReturn($order,$transaction,$this->_gatewayInfo);
    }
    return 'active';
  }
  function getSupportedCurrencies(){ 
      return array('INR'=>'INR');
  }
  public function getAdminGatewayForm(){
    return new Epaytm_Form_Admin_Settings_Paytm();
  }
  public function processAdminGatewayForm(array $values){
    return $values;
  }
  public function getGatewayUrl(){
  }
  function getSupportedBillingCycles(){ 
    return array(0=>'Day',2=>'Month',3=>'Year');
  }

  // IPN

  /**
   * Process an IPN
   *
   * @param Engine_Payment_Ipn $ipn
   * @return Engine_Payment_Plugin_Abstract
   */
  public function onIpn(Engine_Payment_Ipn $ipn){}
  public function cancelResourcePackage($transactionId, $note = null) {}
  public function cancelSubscriptionOnExpiry($source, $package) {
    $paytmParams = array();
    $paytmParams['body'] = array(
        "mid"			=> MERCHANT_MID,
        "subsId"		=> "18405",
        "ssoToken"	=> "af5c035b-1ae3-4ca3-8d3c-2de1a2ba5600"
    );
    $checksum = getChecksumFromString(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), MERCHANT_KEY);
    $paytmParams["head"] = array(
        "version" => "V1",
        "requestTimestamp" => time(),
        "tokenType" => "AES",
        "signature" => $checksum
    );
    if($this->_gatewayInfo->test_mode){
      $url = 'https://securegw-stage.paytm.in/subscription/cancel'; // for staging
    } else {
      $url = 'https://securegw.paytm.in/subscription/cancel'; // for production
    }
    $post_fields = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
  }
  public function onIpnTransaction($rawData){
      $ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
      $order = null;
      // Transaction IPN - get order by subscription_id
      if (!$order && !empty($rawData['data']['object']['subscription'])) {
          $gateway_order_id = $rawData['data']['object']['subscription'];
          $order = $ordersTable->fetchRow(array(
              'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
              'gateway_order_id = ?' => $gateway_order_id,
          ));
      }
      if ($order) {
          return $this->onTransactionIpn($order,$rawData);
      } else {
          throw new Engine_Payment_Plugin_Exception('Unknown or unsupported IPN type, or missing transaction or order ID');
      }
  }
  public function onTransactionIpn(Payment_Model_Order $order,  $rawData) {  }
  function setConfig(){}
  function test(){}
}
