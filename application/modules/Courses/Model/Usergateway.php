<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Usergateway.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_Usergateway extends Core_Model_Item_Abstract
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
  public function getPlugin($class = '')
  {
    if( null === $this->_plugin ) {
			$settings = Engine_Api::_()->getApi('settings', 'core');
   	        $userGatewayEnable = $settings->getSetting('courses.userGateway', 'paypal');
			if($userGatewayEnable == 'paypal' && $class == "Courses_Plugin_Gateway_PayPal"){
			    $class = 'Courses_Plugin_Gateway_Courses_PayPal';
			} elseif(empty($class)) {
        $class = $this->plugin;
			}
			 Engine_Loader::loadClass($class);
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
  public function getGateway($class)
  {
   if($this->_plugin == 'Courses_Plugin_Gateway_Sponsorship_Owner')
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
