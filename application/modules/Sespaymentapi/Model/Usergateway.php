<?php

class Sespaymentapi_Model_Usergateway extends Core_Model_Item_Abstract
{
  protected $_searchTriggers = false;

  protected $_modifiedTriggers = false;
  
  /**
   * @var Engine_Payment_Plugin_Abstract
   */
  protected $_plugin;
  
  /**
   * Get the payment plugin
   *
   * @return Engine_Payment_Plugin_Abstract
   */
  public function getPlugin($is_sponsorship = 'user')
  {

    if( null === $this->_plugin ) {

      if($is_sponsorship == 'refund'){
        $class = 'Sespaymentapi_Plugin_Gateway_Refund_PayPal';
        Engine_Loader::loadClass('Sespaymentapi_Plugin_Gateway_Refund_PayPal');
      } else {
        $class = 'Sespaymentapi_Plugin_Gateway_User_PayPal';
        Engine_Loader::loadClass('Sespaymentapi_Plugin_Gateway_User_PayPal');
      }

      $plugin = new $class($this);
      if( !($plugin instanceof Engine_Payment_Plugin_Abstract) ) {
        throw new Engine_Exception(sprintf('Payment plugin "%1$s" must ' .
            'implement Engine_Payment_Plugin_Abstract', $class));
      }
      $this->_plugin = $plugin;
    }
    return $this->_plugin;
  }

  /**
   * Get the payment gateway
   * 
   * @return Engine_Payment_Gateway
   */
  public function getGateway($is_sponsorship = 'user') {
  
    return $this->getPlugin($is_sponsorship)->getGateway();
  }

  /**
   * Get the payment service api
   * 
   * @return Zend_Service_Abstract
   */
  public function getService()
  {
    return $this->getPlugin()->getService();
  }
}