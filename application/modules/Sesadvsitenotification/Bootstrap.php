<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvsitenotification_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
    parent::__construct($application);
		$baseURL = Zend_Registry::get('StaticBaseUrl');	
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		
		 if(strpos(str_replace('/','',$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']),str_replace('/','',$_SERVER['SERVER_NAME'].'admin'))=== FALSE){
       if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.notification',1)){
        $headScript = new Zend_View_Helper_HeadScript();
        $headScript->appendFile($baseURL
                   .'application/modules/Sesadvsitenotification/externals/scripts/notification.js');			
       }
     }
  }
	
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesadvsitenotification/controllers/Checklicense.php';
  }
}