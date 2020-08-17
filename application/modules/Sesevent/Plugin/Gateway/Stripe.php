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
class Sesevent_Plugin_Gateway_Stripe extends Engine_Payment_Plugin_Abstract
{
  protected $_gatewayInfo;
  protected $_gateway;
  public function __construct(Zend_Db_Table_Row_Abstract $gatewayInfo)
  {
      $this->_gatewayInfo = $gatewayInfo;
      \Stripe\Stripe::setApiKey($this->_gatewayInfo->config['sesadvpmnt_stripe_secret']);
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

  public function createSubscriptionTransaction(User_Model_User $user,Zend_Db_Table_Row_Abstract $subscription,Payment_Model_Package $package,array $params = array()){}
  public function onSubscriptionReturn(Payment_Model_Order $order,$params){}
  public function onSubscriptionTransactionReturn(Payment_Model_Order $order,array $params = array()){}
  public function onSubscriptionTransactionIpn(Payment_Model_Order $order,Engine_Payment_Ipn $ipn){}
  public function cancelSubscription($transactionId, $note = null)
  {
    $profileId = null;
    if( $transactionId instanceof Payment_Model_Subscription ) {
      $package = $transactionId->getPackage();
      if( $package->isOneTime() ) {
        return $this;
      }
      $profileId = $transactionId->gateway_profile_id;
    }else if(is_string($transactionId) ) {
      $profileId = $transactionId;
    }else {
      // Should we throw?
      return $this;
    }
    $secretKey = $this->_gatewayInfo->config['sesadvpmnt_stripe_secret'];
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

  public function createOrderTransaction($viewer,$order,$event,array $params = array()) {
    $description = $event->title;
    if( strlen($description) > 128 ) {
      $description = substr($description, 0, 125) . '...';
    } else if( !$description || !strlen($description) ) {
      $description = 'N/A';
    }
    if( function_exists('iconv') && strlen($description) != iconv_strlen($description) ) {
      // PayPal requires that DESC be single-byte characters
      $description = @iconv("UTF-8", "ISO-8859-1//TRANSLIT", $description);
    }
    $currentCurrency = Engine_Api::_()->sesevent()->getCurrentCurrency();
    $defaultCurrency = Engine_Api::_()->sesevent()->defaultCurrency();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $currencyValue = 1;
    if($currentCurrency != $defaultCurrency){
        $currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
    }
    $ticket_order = array();
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
      $ticket_order[] = array(
        'NAME' => $ticket->name,
        'AMT' => $price,
        'QTY' => $val['quantity'],
      );
    }
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')):
      $couponSessionCode = '-'.'-'.$event->getType().'-'.$event->event_id.'-0'; 
      $priceTotal = @isset($_SESSION[$couponSessionCode]) ? round($priceTotal - $_SESSION[$couponSessionCode]['discount_amount']) : $priceTotal;
    endif;
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescredit')):
      $creditCode =  'credit'.'-sesevent-'.$this->event->event_id.'-'.$this->event->event_id;
      $sessionCredit = new Zend_Session_Namespace($creditCode);
      if(isset($sessionCredit->total_amount) && $sessionCredit->total_amount > 0): 
        $priceTotal = $sessionCredit->total_amount;
      endif;
    endif;
    $totalTaxtAmt = @round($service_tax+$entertainment_tax,2);
    $subTotal = @round($priceTotal-$totalTaxtAmt,2);
    $order->total_amount = @round(($priceTotal/$currencyValue),2);
    $order->change_rate = $currencyValue;
    $order->total_service_tax = @round(($service_tax/$currencyValue),2);
    $order->total_entertainment_tax = @round(($entertainment_tax/$currencyValue),2);
    $order->creation_date = date('Y-m-d H:i:s');
    $totalAmount = round($priceTotal+$service_tax+$entertainment_tax,2);
    $order->total_tickets = $totalTicket;
    $order->gateway_type = 'Strip';
    $commissionType = Engine_Api::_()->authorization()->getPermission($viewer,'sesevent_event','event_admincomn');
    $commissionTypeValue = Engine_Api::_()->authorization()->getPermission($viewer,'sesevent_event','event_commission');
    //%age wise
    if($commissionType == 1 && $commissionTypeValue > 0){
        $order->commission_amount = round(($priceTotal/$currencyValue) * ($commissionTypeValue/100),2);
    }else if($commissionType == 2 && $commissionTypeValue > 0){
        $order->commission_amount = $commissionTypeValue;
    }
    $order->save();
    $logo = !empty($this->_gatewayInfo->config['sesadvpmnt_stripe_logo']) ? $this->_gatewayInfo->config['sesadvpmnt_stripe_logo'] : "https://";
    return \Stripe\Checkout\Session::create([
      'payment_method_types' => ['card'],
      'line_items' => [[
        'name'=>$this->_gatewayInfo->config['sesadvpmnt_stripe_title']." ",
        'description' => $this->_gatewayInfo->config['sesadvpmnt_stripe_description']." ",
        'images' => [$logo],
        'amount' => @round($priceTotal, 2)*100,
        'currency' => $currentCurrency,
        'quantity' => 1,
      ]],
      'metadata'=>['order_id'=>$params['order_id'],'change_rate'=>$currencyValue],
      'success_url' => $params['return_url'].'&session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => $params['cancel_url'],
    ]);
  }
  public function orderTicketTransactionReturn($order,$params = array()) {
    $user = $order->getUser();
    $viewer = Engine_Api::_()->user()->getViewer();
    $orderPayment = $order->getSource();
    $paymentOrder = $order;
    $paymentStatus = 'okay';
    $orderStatus = 'complete';

    $session = \Stripe\Checkout\Session::retrieve($params['session_id']);
    $transaction = \Stripe\PaymentIntent::retrieve($session['payment_intent']);
    // Update order with profile info and complete status?
    $order->state = $orderStatus;
    $order->gateway_transaction_id = $transaction->id;
    return Engine_Api::_()->sesevent()->orderTicketTransactionReturn($order,$transaction,$this->_gatewayInfo);
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

  public function processAdminGatewayForm(array $values){ return $values; }
  public function getGatewayUrl(){}
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
  public function onIpn(Engine_Payment_Ipn $ipn){}
  public function cancelResourcePackage($transactionId, $note = null) {}
  public function cancelSubscriptionOnExpiry($source, $package) {}
  public function onIpnTransaction($rawData){}
  public function onTransactionIpn(Payment_Model_Order $order,  $rawData) {}
  function setConfig(){}
  function test(){}

}
