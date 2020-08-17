<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: px500.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

require_once(APPLICATION_PATH.'/application/modules/Sesmediaimporter/Api/500px/OAuth.php');
require_once(APPLICATION_PATH.'/application/modules/Sesmediaimporter/Api/500px/500px.php');
class Sesmediaimporter_Model_DbTable_Px500 extends Engine_Db_Table
{
  protected $_name = 'user_px500';
  protected $_api;
  public function enable(){
    $settings['px500_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumerkey','');
    $settings['px500_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumersecret','');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.enable','1');
    if( empty($settings['px500_client']) ||
        empty($settings['px500_secret']) || !$enable) {
      return false;
    }
    return true;  
  }
  
  public function getApi()
  {
    // Already initialized
    if( null !== $this->_api ) {
      return $this->_api;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    // Need to initialize
    $settings['px500_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumerkey','');
    $settings['px500_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumersecret','');
    
    if( empty($settings['px500_client']) ||
        empty($settings['px500_secret']) ) {
      $this->_api = null;
      Zend_Registry::set('px500_Api', $this->_api);
      return false;
    }
    
   $siteURL = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST']).Zend_Registry::get('StaticBaseUrl').'sesmediaimporter/auth/px500';
     
    // Try to log viewer in?
    if (empty($_SESSION['px500_access_token']) || empty($_SESSION['px500_access_token']['oauth_token']) || empty($_SESSION['px500_access_token']['oauth_token_secret'])) {
       $_SESSION['px500_lock']  = '';
       $this->_api = null;
    }else{
      $this->_api = new FHpxOAuth($settings['px500_client'], $settings['px500_secret'],$_SESSION['px500_access_token']['oauth_token'],$_SESSION['px500_access_token']['oauth_token_secret']);
      Zend_Registry::set('px500_Api', $this->_api);
      $_SESSION['px500_lock'] = true;
      $inst_uid = Engine_Api::_()->getDbtable('px500', 'sesmediaimporter')
          ->fetchRow(array('user_id = ?' => $viewer->getIdentity()));
      if($inst_uid){
        $user = $this->_api->get('users', array());
        if(empty($user->user->id))
          return false;
      }
    }
    
   return $this->_api;
 }
   public function isConnected(){
      return $this->enable();
   }
  
  public static function loginButton()
  {
     return Zend_Controller_Front::getInstance()->getRouter()
        ->assemble(array('module' => 'sesmediaimporter', 'controller' => 'auth',
          'action' => 'px500'), 'default', true); 
  }
}
