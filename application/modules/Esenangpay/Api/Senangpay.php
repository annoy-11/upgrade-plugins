<?php

class Esenangpay_Api_Senangpay extends Core_Api_Abstract
{
  public $merchantId;
  public $secretKey;
  public $test_mode;
  protected $detail;
  protected $amount;
  protected $orderId;
  protected $name;
  protected $email;
  protected $phone;
  const KEY = "senangPaySession";

  public function init()
  {
    $session = new Zend_Session_Namespace(self::KEY);
    print_r($session);die;
    $gatewayId = $session->gateway_id;
    $gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId);
    $senangPayUserDetails = (object) $gateway->config;
    $this->merchantId = $senangPayUserDetails->esenangpay_merchant_id;
    $this->secretKey = $senangPayUserDetails->esenangpay_secret_key;
    $this->test_mode = $gateway->test_mode;
  }

  /**
   * @description function description
   * @param       $request "$request object from controller"
   * @return 
   */
  public function setSendPaymentDetails($request, $detail, $orderId, $amount)
  {
    $this->detail = $detail;
    $this->amount = $amount;
    $this->orderId = $orderId;
    $this->name = $request->displayname;
    $this->email = $request->email;
    $this->phone = "";
    return $this;
  }

  /**
   *	@description  This will generate hash
   */
  public function generateHash()
  {
    return md5($this->secretKey . $this->detail . $this->amount . $this->orderId);
  }

  /**
   *	@description	This will generate the HTTP query
   */
  public function generateHttpQuery()
  {
    $httpQuery = http_build_query([
      'detail' => $this->detail,
      'amount' => $this->amount,
      'hash' => $this->generateHash(),
      'order_id' => $this->orderId,
      'phone' => $this->phone,
      'email' => $this->email,
      'name' => $this->name
    ]);
    return $httpQuery;
  }

  /**
   * @description  This will send details of payment to SenangPay
   * @return 
   */
  public function processPayment()
  {
    $senangPayApiUrl = 'https://app.senangpay.my/payment/';
    if ($this->test_mode) {
      $senangPayApiUrl = 'https://sandbox.senangpay.my/payment/';
    }

    $data = $this->generateHttpQuery();
    $context = stream_context_create(array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded",
        'method'  => 'POST',
        'content' => $data,
      )
    ));

    $requestType = "GET";

    if ($requestType == "GET")
      $returnUrl = $senangPayApiUrl . $this->merchantId . "?" . $this->generateHttpQuery();
    else if ($requestType == "POST")
      $returnUrl = file_get_contents($senangPayApiUrl . $this->merchantId, false, $context);
    return $returnUrl;
  }

  /**
   *	@description  This will generate the return Hash to match with incoming transaction
   *	@param        $request  "request object from controller"
   */
  protected function generateReturnHash($request)
  {
    $returnHash = md5($this->secretKey . $request->status_id . $request->order_id . $request->transaction_id . $request->msg);
    return $returnHash;
  }

  /**
   *	@description  This will check if the parametered hash is correct and not mess by MITM (Men In The Middle)
   *	@param        $request  "request object from controller"
   */
  public function checkIfReturnHashCorrect($request)
  {
    $parameterHash = $request->hash;
    if ($this->generateReturnHash($request) == $parameterHash) {
      return true;
    } else {
      return false;
    }
  }
}
