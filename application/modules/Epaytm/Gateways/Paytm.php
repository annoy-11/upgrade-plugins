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

class Epaytm_Gateways_Paytm extends Engine_Payment_Gateway
{
  // Support
  protected $_supportedCurrencies = array(
    // 'ARS', // Supported by 2Checkout, but not by PayPal
    'INR', // Supported by 2Checkout
  );
  protected $_supportedLanguages = array(
    'in',

  );
  protected $_supportedRegions = array(
    'HI',
  );
  protected $_supportedBillingCycles = array(
     'Day','Month', 'Year',
  );
  // Translation
  protected $_transactionMap = array(
    Engine_Payment_Transaction::REGION => 'LOCALECODE',
    Engine_Payment_Transaction::RETURN_URL => 'RETURNURL',
    Engine_Payment_Transaction::CANCEL_URL => 'CANCELURL',

    // Deprecated?
    Engine_Payment_Transaction::IPN_URL => 'NOTIFYURL',
    Engine_Payment_Transaction::VENDOR_ORDER_ID => 'INVNUM',
    Engine_Payment_Transaction::CURRENCY => 'CURRENCYCODE',
    Engine_Payment_Transaction::REGION => 'LOCALECODE',
  );

  public function  __construct(array $options = null)
  {
    parent::__construct($options);

    if( null === $this->getGatewayMethod() ) {
      $this->setGatewayMethod('POST');
    }
  }

  /**
   * Get the service API
   *
   * @return Engine_Service_PayPal
   */
  public function getService()
  {
    if( null === $this->_service ) {
      $this->_service = new Engine_Service_PayPal(array_merge(
        $this->getConfig(),
        array(
          'testMode' => $this->getTestMode(),
          'log' => ( true ? $this->getLog() : null ),
        )
      ));
    }
    return $this->_service;
  }
  public function getGatewayUrl()
  {

  }
  // IPN
  public function processIpn(Engine_Payment_Ipn $ipn)
  {
    // Validate ----------------------------------------------------------------
    // Get raw data
    $rawData = $ipn->getRawData();

    // Log raw data
    //if( 'development' === APPLICATION_ENV ) {
      $this->_log(print_r($rawData, true), Zend_Log::DEBUG);
    //}
    // Check a couple things in advance
    if( !empty($rawData['test_ipn']) && !$this->getTestMode() ) {
      throw new Engine_Payment_Gateway_Exception('Test IPN sent in non-test mode');
    }
    // @todo check the email address of the account?
    // Build url and post data
    $parsedUrl = parse_url($this->getGatewayUrl());
    $rawData = array_merge(array(
      'cmd' => '_notify-validate',
    ), $rawData);
    foreach ($rawData as $key => $value) {
      $rawData[$key] = stripslashes($value);
    }
    $postString = http_build_query($rawData, '', '&');
    if( empty($parsedUrl['host']) ) {
      $this->_throw(sprintf('Invalid host in gateway url: %s', $this->getGatewayUrl()));
      return false;
    }
    if( empty($parsedUrl['path']) ) {
      $parsedUrl['path'] = '/';
    }
    // Open socket
    $fp = fsockopen('ssl://' . $parsedUrl['host'], 443, $errNum, $errStr, 30);
    if( !$fp ) {
      $this->_throw(sprintf('Unable to open socket: [%d] %s', $errNum, $errStr));
    }
    stream_set_blocking($fp, true);
    fputs($fp, "POST {$parsedUrl['path']} HTTP/1.1\r\n");
    fputs($fp, "Host: {$parsedUrl['host']}\r\n");
    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: " . strlen($postString) . "\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $postString . "\r\n\r\n");
    $response = '';
    while( !feof($fp) ) {
      $response .= fgets($fp, 1024);
    }
    fclose($fp);
    if( !stripos($response, 'VERIFIED') ) {
      $this->_log($response);
      $this->_throw(sprintf('IPN Validation Failed: %s %s', $parsedUrl['host'], $parsedUrl['path']));
      return false;
    }
    // Success!
    $this->_log('IPN Validation Succeeded');
    // Process -----------------------------------------------------------------
    $rawData = $ipn->getRawData();

    $data = $rawData;

    return $data;
  }
  // Transaction
  public function processTransaction(Engine_Payment_Transaction $transaction)
  {
    $data = array();
    $rawData = $transaction->getRawData();
    // Driver-specific params
    if( isset($rawData['driverSpecificParams']) ) {
      if( isset($rawData['driverSpecificParams'][$this->getDriver()]) ) {
        $data = array_merge($data, $rawData['driverSpecificParams'][$this->getDriver()]);
      }
      unset($rawData['driverSpecificParams']);
    }
    // Add default region?
    if( empty($rawData['region']) && ($region = $this->getRegion()) ) {
      $rawData['region'] = $region;
    }
    // Add default currency
    if( empty($rawData['currency']) && ($currency = $this->getCurrency()) ) {
      $rawData['currency'] = $currency;
    }
    // Process abtract translation map
    $tmp = array();
    $data = array_merge($data, $this->_translateTransactionData($rawData, $tmp));
    $rawData = $tmp;


    // Call setExpressCheckout
    $token = $this->getService()->setExpressCheckout($data);

    $data = array();
    $data['cmd'] = '_express-checkout';
    $data['token'] = $token;

    return $data;
  }
  // Admin
  public function test()
  {
    return true;
  }
}
