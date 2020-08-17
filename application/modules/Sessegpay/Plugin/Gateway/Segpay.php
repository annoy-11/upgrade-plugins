<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Segpay.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_Plugin_Gateway_Segpay extends Engine_Payment_Plugin_Abstract
{
  protected $_gatewayInfo;

  protected $_gateway;
  // General

  /**
   * Constructor
   */
  public function __construct(Zend_Db_Table_Row_Abstract $gatewayInfo)
  {
    $this->_gatewayInfo = $gatewayInfo;
}

 
  public function createSubscriptionTransaction(User_Model_User $user,
      Zend_Db_Table_Row_Abstract $subscription,
      Payment_Model_Package $package,
      array $params = array())
  {}

  /**
   * Process return of subscription transaction
   *
   * @param Payment_Model_Order $order
   * @param array $params
   */
  public function onSubscriptionTransactionReturn(
      Payment_Model_Order $order, array $params = array())
  {}
  
  /**
   * Process ipn of subscription transaction
   *
   * @param Payment_Model_Order $order
   * @param Engine_Payment_Ipn $ipn
   */
  public function onSubscriptionTransactionIpn(
      Payment_Model_Order $order,
      Engine_Payment_Ipn $ipn)
  {}

  /**
   * Cancel a subscription (i.e. disable the recurring payment profile)
   *
   * @params $transactionId
   * @return Engine_Payment_Plugin_Abstract
   */
  public function cancelSubscription($transactionId, $note = null)
  {
    $table = Engine_Api::_()->getDbTable('fields','sessegpay');
    $profileId = null;
    if( is_string($transactionId) && $transactionId) {
      $profileId = $transactionId;
    }else{
      return $this;  
    }
    try {
      $selelct = $table->select()->where('type =?','tranid')->where('value =?',$profileId)->limit(1);
      $priceId = $table->fetchRow($selelct);
      if($priceId){
        $orderid = $priceId->order_id;
        $selelctTra = $table->select()->where('type =?','tranid')->where('order_id =?',$orderid)->limit(1);
        $transaction = $table->fetchRow($selelctTra);
        if($transaction){
            $settings = Engine_Api::_()->getApi('settings', 'core');
            $transaction_id = $transaction->value;
            $username = $settings->getSetting('sessegpay_username');
            $password = $settings->getSetting('sessegpay_password');       
            $data = $this->url_get_contents('https://srs.segpay.com/ADM.asmx/RefundTransaction?Userid='.$username.'&UserAccessKey='.$password.'&TransID='.$transaction_id.'&RefundReason=');
        }
      }else{
        return $this;  
      }
    } catch( Exception $e ) {
      // throw?
    }
    return $this;
  }
   function url_get_contents ($Url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }
  public function getService(){}
  public function getGateway(){
    if( null === $this->_gateway ) {
      $class = 'Sessegpay_Plugin_Gateway_Segpay';
      Engine_Loader::loadClass($class);
      $gateway = new $class($this->_gatewayInfo);
      $this->_gateway = $gateway;
    }
    return $this->_gateway;  
  }
  function getSupportedBillingCycles(){
    return array(0=>'Week',1=>'Month',2=>'Year');  
  }
  public function createTransaction(array $params){}
  public function createIpn(array $params){}
  
  public function getOrderDetailLink($orderId){}
  public function getTransactionDetailLink($transactionId){}
  public function getOrderDetails($orderId){}
  public function getTransactionDetails($transactionId){}
  // IPN

  /**
   * Process an IPN
   *
   * @param Engine_Payment_Ipn $ipn
   * @return Engine_Payment_Plugin_Abstract
   */
  public function onIpn(Engine_Payment_Ipn $ipn)
  {}



  // Forms

  /**
   * Get the admin form for editing the gateway info
   *
   * @return Engine_Form
   */
  public function getAdminGatewayForm()
  {
    return new Sessegpay_Form_Admin_Segpay();
  }

  public function processAdminGatewayForm(array $values)
  {
    return $values;
  }
}
