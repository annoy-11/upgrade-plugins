<?php

class Booking_Model_Usergateway extends Core_Model_Item_Abstract
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
  public function getPlugin($class = 'booking')
  {
    if( null === $this->_plugin ) {
      try{
        $class = 'Booking_Plugin_Gateway_Booking_PayPal';
      Engine_Loader::loadClass('Booking_Plugin_Gateway_Booking_PayPal');
      }catch(Exception $e){
        echo $e->getMessage();
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
  public function getGateway($class = 'booking')
  {
   if($this->_plugin == 'Booking_Plugin_Gateway_Booking_PayPal')
    	return $this->getPlugin($class)->getGateway();
		else
			return $this->getPlugin($class)->getGateway();
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