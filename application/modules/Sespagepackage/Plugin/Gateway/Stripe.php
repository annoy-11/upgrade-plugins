<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpmnt
 * @package    Sesadvpmnt
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Stripe.php  2019-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
include_once APPLICATION_PATH . "/application/modules/Sesadvpmnt/Api/Stripe/init.php";
class Sespagepackage_Plugin_Gateway_Stripe extends Engine_Payment_Plugin_Abstract
{
  protected $_gatewayInfo;

  protected $_gateway;
  protected $_session;
  public function __construct(Zend_Db_Table_Row_Abstract $gatewayInfo)
  {
      $this->_gatewayInfo = $gatewayInfo;
      $this->_session = new Zend_Session_Namespace('Stripe_Error');
  }
  public function getService()
  {
    return $this->getGateway()->getService();
  }
  public function getGateway()
  {
    if( null === $this->_gateway ) {
        $class = 'Sesadvpmnt_Gateways_Stripe';
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
  public function createSubscriptionTransaction(User_Model_User $user, Zend_Db_Table_Row_Abstract $subscription, Payment_Model_Package $package, array $params = array()) {
    
  }
  public function createPageTransaction(User_Model_User $user,
      Zend_Db_Table_Row_Abstract $subscription,
      Zend_Db_Table_Row_Abstract $package,
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
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->secretKey = $secretKey = $this->_gatewayInfo->config['sesadvpmnt_stripe_secret'];
    $this->view->currency = $currency = $settings->getSetting('payment.currency', 'USD');
    // This is a one-time fee
    if($package->isOneTime()) {
        $params['currency'] = $currency;
         return  $this->createOrderTransaction($params);

    } else {
       try{
        \Stripe\Stripe::setApiKey($secretKey);
                $plan = \Stripe\Plan::create(array(
                    "amount" => $params['amount']*100,
                    "interval" => $package->recurrence_type,
                    "interval_count" => $package->recurrence,
                    "currency" => $currency,
                    "product" => [
                        "name" => $package->title,
                        "type" => "service"
                    ],
                ));
                $plan_id = $plan->id;
                $createSubscription = \Stripe\Subscription::create([
                "customer" =>  $params['customer'],
                "items" => [
                    [
                     "plan" => $plan_id,
                    ],
                ],
                 'metadata' =>['order_id'=>$params['order_id'],'type'=>$params['type'],'gateway'=>!empty($params['gateway']) ? $params['gateway']->getIdentity() : null]
            ]);
            return $createSubscription;
        }catch(ExceptiocreateSubscriptionTransactionn $e) {
            throw new Payment_Model_Exception('There was an error processing your ' .
          'transaction. Please try again later.');
        }
    }
    // Create transaction
  }
  public function onSubscriptionReturn(
      Payment_Model_Order $order,$transaction){
  
  }
  public function onPageTransactionReturn(
    Payment_Model_Order $order, $params) {
    // Check that gateways match
    if ($order->gateway_id != $this->_gatewayInfo->gateway_id) {
      throw new Engine_Payment_Plugin_Exception('Gateways do not match');
    }
    $response = $params['transaction'];
    // Get related info
    $user = $order->getUser();
    $item = $order->getSource();
    $package = $item->getPackage();
    $transaction = $item->getTransaction();
    // Check subscription state
    if ($transaction && ($transaction->state == 'trial')) {
      return 'active';
    } else if ($transaction && $transaction->state == 'pending') {
      return 'pending';
    }
    // Check for cancel state - the user cancelled the transaction
    if ($response->status == 'cancel') {
      // Cancel order and item
      $order->onCancel();
      $item->onPaymentFailure();
      // Error
      throw new Payment_Model_Exception('Your payment has been cancelled and ' .
      'not been charged. If this is not correct, please try again later.');
    }
    $paymentStatus = null;
    $orderStatus = null;
    switch($response->status) {
        case 'created':
        case 'pending':
          $paymentStatus = 'pending';
          $orderStatus = 'complete';
          break;

        case 'active':
        case 'succeeded':
        case 'completed':
        case 'processed':
        case 'canceled_reversal': // Probably doesn't apply
          $paymentStatus = 'okay';
          $orderStatus = 'complete';
          break;

        case 'denied':
        case 'failed':
        case 'voided': // Probably doesn't apply
        case 'reversed': // Probably doesn't apply
        case 'refunded': // Probably doesn't apply
        case 'expired':  // Probably doesn't apply
        default: // No idea what's going on here
          $paymentStatus = 'failed';
          $orderStatus = 'failed'; // This should probably be 'failed'
          break;
    }
    // One-time
    if ($package->isOneTime()) {
      // Update order with profile info and complete status?
      $order->state = $orderStatus;
      $order->gateway_transaction_id = $response->id;
      $order->save();
      $orderPackageId = $item->existing_package_order ? $item->existing_package_order : false;
      $orderPackage = Engine_Api::_()->getItem('sespagepackage_orderspackage', $orderPackageId);
      if (!$orderPackageId || !$orderPackage) {
        $transactionsOrdersTable = Engine_Api::_()->getDbtable('orderspackages', 'sespagepackage');
        $transactionsOrdersTable->insert(array(
            'owner_id' => $order->user_id,
            'item_count' => ($package->item_count - 1 ),
            'package_id' => $package->getIdentity(),
            'state' => $paymentStatus,
            'expiration_date' => $package->getExpirationDate(),
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'creation_date' => new Zend_Db_Expr('NOW()'),
            'modified_date' => new Zend_Db_Expr('NOW()'),
        ));
        $orderPackageId = $transactionsOrdersTable->getAdapter()->lastInsertId();
      } else {
        $orderPackage = Engine_Api::_()->getItem('sespagepackage_orderspackage', $orderPackageId);
        $orderPackage->item_count = $orderPackage->item_count--;
        $orderPackage->save();
        $orderPackageId = $orderPackage->getIdentity();
      }
      $session = new Zend_Session_Namespace('Payment_Sespagepackage');
      $currency = $session->currency;
      $rate = $session->change_rate;
      if (!$rate)
        $rate = 1;
      $defaultCurrency = Engine_Api::_()->sespagepackage()->defaultCurrency();
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $currencyValue = 1;
      if ($currency != $defaultCurrency)
        $currencyValue = $settings->getSetting('sesmultiplecurrency.' . $currency);
      $price = @round(($params['amount'] * $currencyValue), 2);
      //Insert transaction
      $daysLeft = 0;
      //check previous transaction if any for reniew
      if (!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00') {
        $expiration = $package->getExpirationDate();
        //check isonetime condition and renew exiration date if left
        if ($package->isOneTime()) {
          $datediff = strtotime($transaction->expiration_date) - time();
          $daysLeft = floor($datediff / (60 * 60 * 24));
        }
      }
      $oldOrderPackageId = $item->orderspackage_id;
      $tablePage = Engine_Api::_()->getDbTable('pages', 'sespage');
      if (!empty($oldOrderPackageId)) {
        $select = $tablePage->select()->from($tablePage->info('name'))->where('orderspackage_id =?', $oldOrderPackageId);
        $totalItemCreated = count($tablePage->fetchAll($select));
        if ($package->item_count >= $totalItemCreated && $package->item_count)
          $leftPage = $package->item_count - $totalItemCreated;
        else if (!$package->item_count)
          $leftPage = -1;
        else
          $leftPage = 0;
      } else
      $leftPage = $package->item_count - 1;
      $tablePage->update(array('orderspackage_id' => $orderPackageId), array('orderspackage_id' => $oldOrderPackageId));
      $packageOrder = Engine_Api::_()->getItem('sespagepackage_orderspackage', $orderPackageId);
      $packageOrder->item_count = $leftPage;
      $packageOrder->save();
      $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sespagepackage');
      $transactionsTable->insert(array(
          'owner_id' => $order->user_id,
          'package_id' => $item->package_id,
          'item_count' => $leftPage,
          'gateway_id' => $this->_gatewayInfo->gateway_id,
          'gateway_transaction_id' => $response->id,
          'creation_date' => new Zend_Db_Expr('NOW()'),
          'modified_date' => new Zend_Db_Expr('NOW()'),
          'order_id' => $order->order_id,
          'orderspackage_id' => $orderPackageId,
          'state' => 'initial',
          'total_amount' => $params['amount'],
          'change_rate' => $rate,
          'gateway_type' => "Stripe",
          'currency_symbol' => $currency,
          'ip_address' => $_SERVER['REMOTE_ADDR'],
          'message' => $_SESSION['message'],
          'file_path' => $_SESSION['file_path'],
      ));
      unset($_SESSION['message']);
      unset($_SESSION['file_path']);
      $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
      $item->transaction_id = $transaction_id;
      $item->orderspackage_id = $orderPackageId;
      $item->existing_package_order = 0;
      $item->save();
      $transaction = Engine_Api::_()->getItem('sespagepackage_transaction', $transaction_id);
      // Get benefit setting
      $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'sespagepackage')
              ->getBenefitStatus($user);
      // Check payment status
      if (($paymentStatus == 'okay' || $paymentStatus == 'active' ||
              ($paymentStatus == 'pending' && $giveBenefit))) {
        //Update subscription info
        $transaction->gateway_id = $this->_gatewayInfo->gateway_id;
        $transaction->gateway_profile_id = $response->id ;
        $transaction->save();
        // Payment success
        if(!$bankTransfer)
          $transaction = $item->onPaymentSuccess();
        if ($daysLeft >= 1) {
          $expiration_date = date('Y-m-d H:i:s', strtotime($transaction->expiration_date . '+ ' . $daysLeft . ' days'));
          $transaction->expiration_date = $expiration_date;
          $transaction->save();
          $orderpackage = Engine_Api::_()->getItem('sespagepackage_orderspackage', $orderPackageId);
          $orderpackage->expiration_date = $expiration_date;
          $orderpackage->save();
        }
        //For Coupon
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')){
          $transaction->ordercoupon_id = Engine_Api::_()->ecoupon()->setAppliedCouponDetails($params['couponSessionCode']);
          $transaction->save();
        }
        //For Credit 
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescredit') && isset($params['creditCode'])) {
          $sessionCredit = new Zend_Session_Namespace($params['creditCode']);
          $transaction->credit_point = $sessionCredit->credit_value;  
          $transaction->credit_value =  $sessionCredit->purchaseValue;
          $transaction->save();
          $userCreditDetailTable = Engine_Api::_()->getDbTable('details', 'sescredit');
          $userCreditDetailTable->update(array('total_credit' => new Zend_Db_Expr('total_credit - ' . $sessionCredit->credit_value)), array('owner_id =?' => $order->user_id));
        }
        // send notification
        if ($item->didStatusChange()) {
          /* Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
            Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
            )); */
        }
        if($bankTransfer)
          return 'pending';
        return 'active';
      } else if ($paymentStatus == 'pending') {
        // Update subscription info
        $transaction->gateway_id = $this->_gatewayInfo->gateway_id;
        $transaction->gateway_profile_id = $response->id;
        $transaction->save();
        // Payment pending
        $item->onPaymentPending();
        //For Coupon
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')){
          $transaction->ordercoupon_id = Engine_Api::_()->ecoupon()->setAppliedCouponDetails($params['couponSessionCode']);
          $transaction->save();
        }
        // send notification
        /* if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_pending', array(
          'subscription_title' => $package->title,
          'subscription_description' => $package->description,
          'subscription_terms' => $package->getPackageDescription(),
          'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
          Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
          } */
        return 'pending';
      } else if ($paymentStatus == 'failed') {
        // Cancel order and subscription?
        $order->onFailure();
        $item->onPaymentFailure();
        // Payment failed
        throw new Payment_Model_Exception('Your payment could not be ' .
        'completed. Please ensure there are sufficient available funds ' .
        'in your account.');
      } else {
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
        'transaction. Please try again later.');
      }
    }
    // Recurring
    else {

      $isExistsOrderPackageId = $orderPackageId = $item->existing_package_order ? $item->existing_package_order : false;
      if (!$orderPackageId) {
        if (!$orderPackageId) {
          $transactionsOrdersTable = Engine_Api::_()->getDbtable('orderspackages', 'sespagepackage');
          $transactionsOrdersTable->insert(array(
              'owner_id' => $order->user_id,
              'item_count' => ($package->item_count - 1 ),
              'state' => 'active',
              'package_id' => $package->getIdentity(),
              'expiration_date' => $package->getExpirationDate(),
              'ip_address' => $_SERVER['REMOTE_ADDR'],
              'creation_date' => new Zend_Db_Expr('NOW()'),
              'modified_date' => new Zend_Db_Expr('NOW()'),
          ));
          $orderPackageId = $transactionsOrdersTable->getAdapter()->lastInsertId();
        }
      } else {
        $orderPackage = Engine_Api::_()->getItem('sespagepackage_orderspackage', $orderPackageId);
        $orderPackage->item_count = $orderPackage->item_count--;
        $orderPackage->save();
      }
      $item->existing_package_order = 0;
      $item->save();
      $session = new Zend_Session_Namespace('Payment_Sespagepackage');
      $currency = $session->currency;
      $rate = $session->change_rate;
      if (!$rate)
        $rate = 1;
      $defaultCurrency = Engine_Api::_()->sespagepackage()->defaultCurrency();
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $currencyValue = 1;
      if ($currency != $defaultCurrency) {
        $currencyValue = $settings->getSetting('sesmultiplecurrency.' . $currency);
      }
      $price = @round(($params['amount'] * $currencyValue), 2);
      // Insert transaction
      $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sespagepackage');
      $transactionsTable->insert(array(
          'owner_id' => $order->user_id,
          'package_id' => $item->package_id,
          'item_count' => ($package->item_count - 1),
          'gateway_id' => $this->_gatewayInfo->gateway_id,
          'gateway_transaction_id' => '',
          'orderspackage_id' => $orderPackageId,
          'creation_date' => new Zend_Db_Expr('NOW()'),
          'modified_date' => new Zend_Db_Expr('NOW()'),
          'order_id' => $order->order_id,
          'state' => 'initial',
          'total_amount' => $params['amount'],
          'change_rate' => $rate,
          'gateway_type' => 'Stripe',
          'currency_symbol' => $currency,
          'ip_address' => $_SERVER['REMOTE_ADDR'],
      ));
      $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
      $item->transaction_id = $transaction_id;
      $item->orderspackage_id = $orderPackageId;
      $item->save();
      $transaction = Engine_Api::_()->getItem('sespagepackage_transaction', $transaction_id);
      if (!$isExistsOrderPackageId) {
        // Update order with profile info and complete status?
        $order->state = 'complete';
        $order->gateway_order_id = $response->id;
        $order->save();
        // Get benefit setting
        $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'sespagepackage')
                ->getBenefitStatus($user);
        // Check profile status
        if ($paymentStatus == 'okay' || $paymentStatus == 'active' ||
              ($paymentStatus == 'pending' && $giveBenefit)) {
          // Enable now
          $transaction->gateway_id = $this->_gatewayInfo->gateway_id;
          $transaction->gateway_profile_id = $response->id;
          $transaction->save();
          $item->onPaymentSuccess();
          //For Coupon
          if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')){
            $transaction->ordercoupon_id = Engine_Api::_()->ecoupon()->setAppliedCouponDetails($params['couponSessionCode']);
            $transaction->save();
          }
          // send notification
          /* if( $subscription->didStatusChange() ) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
            Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
            ));
            }
           */
          return 'active';
        } else if ($paymentStatus == 'pending') {
          // Enable later
          //$subscription->gateway_id = $this->_gatewayInfo->gateway_id;
          // $subscription->gateway_profile_id = $rdata['PROFILEID'];
          $item->onPaymentPending();
          //For Coupon
          if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')){
            $transaction->ordercoupon_id = Engine_Api::_()->ecoupon()->setAppliedCouponDetails($params['couponSessionCode']);
            $transaction->save();
          }
          // send notification
          /* if( $subscription->didStatusChange() ) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_pending', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
            Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
            ));
            }
           */
          return 'pending';
        } else {
          // Cancel order and subscription?
          $order->onFailure();
          $item->onPaymentFailure();
          // This is a sanity error and cannot produce information a user could use
          // to correct the problem.
          throw new Payment_Model_Exception('There was an error processing your ' .
          'transaction. Please try again later.');
        }
      }
    }
  }

  
  public function onSubscriptionTransactionReturn(Payment_Model_Order $order,array $params = array()){}
  public function onSubscriptionTransactionIpn(
      Payment_Model_Order $order,
      Engine_Payment_Ipn $ipn)
  {

  }

  public function cancelSubscription($transactionId, $note = null)
  {
        $profileId = null;

    if( $transactionId instanceof Payment_Model_Subscription ) {
      $package = $transactionId->getPackage();
      if( $package->isOneTime() ) {
        return $this;
      }
      $profileId = $transactionId->gateway_profile_id;
    }

    else if(is_string($transactionId) ) {
      $profileId = $transactionId;
    }

    else {
      // Should we throw?
      return $this;
    }
     $this->view->secretKey = $secretKey = $this->_gatewayInfo->config['sesadvpmnt_stripe_secret'];
     \Stripe\Stripe::setApiKey($secretKey);
     $sub = \Stripe\Subscription::retrieve($profileId);
   $cancel = $sub->cancel();


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
      return 'https://dashboard.stripe.com/test/search?query' . $orderId;
    } else {
      return 'https://dashboard.stripe.com/search?query' . $orderId;
    }
  }

  public function getTransactionDetailLink($transactionId)
  {
    if( $this->getGateway()->getTestMode() ) {
      // Note: it doesn't work in test mode
      return 'https://dashboard.stripe.com/test/search?query' . $transactionId;
    } else {
      return 'https://dashboard.stripe.com/search?query' . $transactionId;
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

  public function createOrderTransaction($param = array()) {
      $secretKey =   $this->_gatewayInfo->config['sesadvpmnt_stripe_secret'];;
      $currencyValue = $param['change_rate'] ? $param['change_rate'] : 1;
        try {
            \Stripe\Stripe::setApiKey($secretKey);
            $transaction = \Stripe\Charge::create([
                'amount' => $param['amount']*100,
                'currency' => $param['currency'],
                'source' => $param['token'],
                'description' => 'Credits'.$param['amount'],
                'metadata' =>['order_id'=>$param['order_id'],'type'=>$param['type'],'change_rate'=>$currencyValue]
            ]);
        } catch(\Stripe\Error\Card $e) {
          $body = $e->getJsonBody();
          $this->_session->errorMessage = $body['error'];
          throw new Payment_Model_Exception($body['error']);
        } catch (\Stripe\Error\RateLimit $e) {
            $this->_session->errorMessage  = $e->getMessage();
            throw new Payment_Model_Exception($e->getMessage());
        } catch (\Stripe\Error\InvalidRequest $e) {
            $this->_session->errorMessage = $e->getMessage();
            throw new Payment_Model_Exception($e->getMessage());
        } catch (\Stripe\Error\Authentication $e) {
            $this->_session->errorMessage = $e->getMessage();
            throw new Payment_Model_Exception($e->getMessage());
        } catch (\Stripe\Error\ApiConnection $e) {
            $this->_session->errorMessage = $e->getMessage();
            throw new Payment_Model_Exception($e->getMessage());
        } catch (\Stripe\Error\Base $e) {
            $this->_session->errorMessage = $e->getMessage();
            throw new Payment_Model_Exception($e->getMessage());
        } catch (Exception $e) {
            $this->_session->errorMessage = $e->getMessage();
            throw new Payment_Model_Exception($e->getMessage());
        }
    return $transaction;
  }

  public function createOrderTransactionReturn($order,$transaction) {
      
    return 'active';
  }
  function getSupportedCurrencies(){
      return array('USD'=>'USD','AED'=>'AED','AFN'=>'AFN','ALL'=>'ALL','AMD'=>'AMD','ANG'=>'ANG','AOA'=>'AOA','ARS'=>'ARS','AUD'=>'AUD'
      ,'AWG'=>'AWG','AZN','BAM'=>'BAM','BBD'=>'BBD','BDT'=>'BDT','BGN'=>'BGN','BIF'=>'BIF','BMD'=>'BMD','BND'=>'BND','BOB'=>'BOB','BRL'=>'BRL',
      'BSD'=>'BSD','BWP'=>'BWP','BZD'=>'BZD','CAD'=>'CAD','CDF'=>'CDF','CHF'=>'CHF','CLP'=>'CLP','CNY'=>'CNY','COP'=>'COP','CRC'=>'CRC','CVE'=>'CVE',
      'CZK'=>'CZK','DJF'=>'DJF','DKK'=>'DKK','DOP'=>'DOP','DZD'=>'DZD','EGP'=>'EGP','ETB'=>'ETB','EUR'=>'EUR','FJD'=>'FJD','FKP'=>'FKP','GBP'=>'GBP',
      'GEL'=>'GEL','GIP'=>'GIP','GMD'=>'GMD','GNF'=>'GNF','GTQ'=>'GTQ','GYD'=>'GYD','HKD'=>'HKD','HNL'=>'HNL','HRK'=>'HRK','HTG'=>'HTG','HUF'=>'HUF',
      'IDR'=>'IDR','ILS'=>'ILS','INR'=>'INR','ISK'=>'ISK','JMD'=>'JMD','JPY'=>'JPY','KES'=>'KES','KGS'=>'KGS','KHR'=>'KHR','KMF'=>'KMF','KRW'=>'KRW',
      'KYD'=>'KYD','KZT'=>'KZT','LAK'=>'LAK','LBP'=>'LBP','LKR'=>'LKR','LRD'=>'LRD','LSL'=>'LSL','MAD'=>'MAD','MDL'=>'MDL','MGA'=>'MGA','MKD','MMK'=>'MMK',
      'MNT'=>'MNT','MOP'=>'MOP','MRO'=>'MRO','MUR'=>'MUR','MVR'=>'MVR','MWK'=>'MWK','MXN'=>'MXN','MYR'=>'MYR','MZN'=>'MZN','NAD'=>'NAD','NGN'=>'NGN','NIO'=>'NIO',
      'NOK'=>'NOK','NPR'=>'NPR','NZD'=>'NZD','PAB'=>'PAB','PEN'=>'PEN','PGK'=>'PGK','PHP'=>'PHP','PKR'=>'PKR','PLN'=>'PLN','PYG'=>'PYG','QAR'=>'QAR','RON'=>'RON',
      'RSD'=>'RSD','RUB'=>'RUB','RWF'=>'RWF','SAR'=>'SAR','SBD'=>'SBD','SCR'=>'SCR','SEK'=>'SEK','SGD'=>'SGD','SHP'=>'SHP','SLL'=>'SLL','SOS'=>'SOS','SRD'=>'SRD',
      'STD'=>'STD','SZL'=>'SZL','THB'=>'THB','TJS'=>'TJS','TOP'=>'TOP','TRY'=>'TRY','TTD'=>'TTD','TWD'=>'TWD','TZS'=>'TZS','UAH'=>'UAH','UGX'=>'UGX','UYU'=>'UYU','UZS'=>'UZS','VND'=>'VND','VUV'=>'VUV','WST'=>'WST','XAF'=>'XAF','XCD'=>'XCD','XOF'=>'XOF','XPF'=>'XPF','YER'=>'YER','ZAR'=>'ZAR','ZMW'=>'ZMW');
 }
  public function getAdminGatewayForm(){
    return new Sesadvpmnt_Form_Admin_Settings_Stripe();
  }

  public function processAdminGatewayForm(array $values){
    return $values;
  }
  public function getGatewayUrl(){
  }
  function getSupportedBillingCycles(){
    return array(0=>'Day',1=>'Week',2=>'Month',3=>'Year');
  }
  // IPN

  /**
   * Process an IPN
   *
   * @param Engine_Payment_Ipn $ipn
   * @return Engine_Payment_Plugin_Abstract
   */
   public function onIpn(Engine_Payment_Ipn $ipn)
  {
  }
  public function cancelResourcePackage($transactionId, $note = null) {
  }
  public function cancelSubscriptionOnExpiry($source, $package) {
      $this->view->secretKey = $secretKey = $this->_gatewayInfo->config['sesadvpmnt_stripe_secret'];
        if($package->duration_type != "forever"){
              $durationTime = (($package->duration > 1 || $package->duration == 0) ? ("+".$package->duration." ".$package->duration_type."s") : ("+".$package->duration." ".$package->duration_type));
                $subscriptionDate = strtotime($source->creation_date);
              $date = date($subscriptionDate,strtotime($durationTime));
        if(strtotime("now") >= $date ) {
          \Stripe\Stripe::setApiKey($secretKey);
          $sub = \Stripe\Subscription::retrieve($source->gateway_profile_id);
          $sub->cancel();
          echo "Subscription canceled";
        }
      }
      echo "Subscription Continue";
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
  public function onTransactionIpn(Payment_Model_Order $order,  $rawData) {
      // Check that gateways match
      if ($order->gateway_id != $this->_gatewayInfo->gateway_id) {
          throw new Engine_Payment_Plugin_Exception('Gateways do not match');
      }
 
      // Get related info	
        $user = $order->getUser();
        $item = $order->getSource();
        $package = $item->getPackage();
        $transaction = $item->getTransaction();
        $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sespagepackage');
      // switch message_type
      switch ($rawData['type']) {
          case 'account.updated':
          case 'account.application.deauthorized':
          case 'account.external_account.created':
          case 'account.external_account.deleted':
          case 'account.external_account.updated':
          case 'application_fee.created':
          case 'application_fee.refunded':
          case 'application_fee.refund.updated':
          case 'balance.available':
          case 'bitcoin.receiver.created':
          case 'bitcoin.receiver.filled':
          case 'bitcoin.receiver.updated':
          case 'bitcoin.receiver.transaction.created':
          case 'charge.captured':
          case 'charge.failed':return false; break;
          case 'charge.refunded':
              // Payment Refunded
              $item->onRefund();
              // send notification
              return true;
              break;
          case 'charge.succeeded':
          case 'charge.updated':
          case 'charge.dispute.closed':
          case 'charge.dispute.created':
          case 'charge.dispute.funds_reinstated':
          case 'charge.dispute.funds_withdrawn':
          case 'charge.dispute.updated':
          case 'coupon.created':
          case 'coupon.deleted':
          case 'coupon.updated':
          case 'customer.created':
          case 'customer.deleted':
          case 'customer.updated':
          case 'customer.bank_account.deleted':
          case 'customer.discount.created':
          case 'customer.discount.deleted':
          case 'customer.discount.updated':
          case 'customer.source.created':
          case 'customer.source.deleted':
          case 'customer.source.updated':
          case 'customer.subscription.created': return false; break;
          case 'customer.subscription.deleted':
              $item->onCancel();
              // send notification
                return true;
              break;
          case 'customer.subscription.trial_will_end':return false; break;
          case 'customer.subscription.updated':
              $item->onPaymentSuccess();
              $this->cancelSubscriptionOnExpiry($item, $package);
                return true;
              break;
          case 'invoice.created':break;
          case 'invoice.payment_failed':
              $item->onPaymentFailure();
              break;
          case 'invoice.payment_succeeded':
              $item->onPaymentSuccess();
              $this->cancelSubscriptionOnExpiry($item, $package);
              return true;
              break;
          case 'invoice.updated':
          case 'invoiceitem.created':
          case 'invoiceitem.deleted':
          case 'invoiceitem.updated':
          case 'plan.created':
          case 'plan.deleted':
          case 'plan.updated':
          case 'recipient.created':
          case 'recipient.deleted':
          case 'recipient.updated':
          case 'transfer.created':
          case 'transfer.failed':
          case 'transfer.paid':
          case 'transfer.reversed':
          case 'transfer.updated': return false; break;
          default:
          throw new Engine_Payment_Plugin_Exception(sprintf('Unknown IPN ' .
              'type %1$s', $rawData['type']));
          break;
      }
      return $this;
  }
  function setConfig(){}
  function test(){}

}
