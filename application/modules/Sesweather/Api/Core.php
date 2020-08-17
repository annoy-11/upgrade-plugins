<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
include 'DarkSky.php';
class Sesweather_Api_Core extends Core_Api_Abstract {
  protected $_darkApi;
  public function __construct() {
    if($this->_darkApi == null) {
       $this->_darkApi = new Darksky(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesweather.apikey'));
	}
  }
  public function getApi() {
	  return $this->_darkApi;
  }
}
