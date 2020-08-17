<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Usergateway.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_Usergateway extends Core_Model_Item_Abstract
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
    if(null === $this->_plugin) {
			$settings = Engine_Api::_()->getApi('settings', 'core');
   	        $userGatewayEnable = $settings->getSetting('sesevent.userGateway', 'paypal');
			if($userGatewayEnable == 'paypal' && $this->plugin == "Sesproduct_Plugin_Gateway_PayPal"){
        $class = 'Sesproduct_Plugin_Gateway_Store_PayPal';
			} elseif(empty($class)) {
        $class = $this->plugin;
			}
      Engine_Loader::loadClass($class);
      $plugin = new $this->plugin($this);
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
   if($this->_plugin == 'Sesevent_Plugin_Gateway_Sponsorship_Owner')
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
