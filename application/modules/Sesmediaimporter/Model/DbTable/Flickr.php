<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Flickr.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

require_once(APPLICATION_PATH.'/application/modules/Sesmediaimporter/Api/Flickr/Flickr.php');

class Sesmediaimporter_Model_DbTable_Flickr extends Engine_Db_Table
{
  protected $_name = 'user_flickr';
  protected $_api;
  public function enable(){
    $settings['flickr_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientid','');
    $settings['flickr_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientsecret','');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.enable','1');
    if( empty($settings['flickr_client']) ||
        empty($settings['flickr_secret']) || !$enable) {
      return false;
    }
    return true;  
  }
  public static function getFlInstance()
  {
    return Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter')->getApi();
  }

  public function getApi()
  {
    // Already initialized
    if( null !== $this->_api ) {
      return $this->_api;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    // Need to initialize
    $settings['flickr_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientid','');
    $settings['flickr_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientsecret','');
    
    if( empty($settings['flickr_client']) ||
        empty($settings['flickr_secret']) ) {
      $this->_api = null;
      Zend_Registry::set('flickr_Api', $this->_api);
      return false;
    }
    
   $siteURL = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST']).Zend_Registry::get('StaticBaseUrl').'sesmediaimporter/auth/flickr';
     $this->_api = new Flickr($settings['flickr_client'],$settings['flickr_secret'],$siteURL);
    Zend_Registry::set('flickr_Api', $this->_api);

    // Try to log viewer in?
    if (!empty($_SESSION['phpFlickr_auth_token'])) {
      $_SESSION['flickr_lock'] = true;
      $inst_uid = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter')
          ->fetchRow(array('user_id = ?' => $viewer->getIdentity()));
      if($inst_uid){
        $user = $this->_api->getOauthData(Flickr::USER_NSID);
        if(empty($user))
          return false;
      }
   }else
     $_SESSION['flickr_lock']  = '';
   return $this->_api;
 }
   public function isConnected(){
     // Need to initialize
    $settings['flickr_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientid','');
    $settings['flickr_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientsecret','');
    if( empty($settings['flickr_client']) || empty($settings['flickr_secret']) ) 
      return false;
     return true;
   }
  
  public static function loginButton()
  {
     return Zend_Controller_Front::getInstance()->getRouter()
        ->assemble(array('module' => 'sesmediaimporter', 'controller' => 'auth',
          'action' => 'flickr'), 'default', true); 
  }
}
