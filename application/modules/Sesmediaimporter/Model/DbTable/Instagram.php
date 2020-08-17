<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Instagram.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

require_once(APPLICATION_PATH.'/application/modules/Sesmediaimporter/Api/Instagram/Instagram.php');
class Sesmediaimporter_Model_DbTable_Instagram extends Engine_Db_Table
{
  protected $_name = 'user_instagram';
  protected $_api;
  public function enable(){
    $settings['instagram_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientid','');
    $settings['instagram_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientsecret','');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.enable','1');
    if( empty($settings['instagram_client']) ||
        empty($settings['instagram_secret']) || !$enable) {
      return false;
    }  
    return true;
  }
  public static function getInInstance()
  {
    return Engine_Api::_()->getDbtable('likedin', 'sesadvancedactivity')->getApi();
  }

  public function getApi($auth = false)
  {
    // Already initialized
    if( null !== $this->_api ) {
      return $this->_api;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    // Need to initialize
    $settings['instagram_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientid','');
    $settings['instagram_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientsecret','');
    if( empty($settings['instagram_client']) ||
        empty($settings['instagram_secret']) ) {
      $this->_api = null;
      Zend_Registry::set('Instagram_Api', $this->_api);
      return false;
    }
    
    $this->_api = new Instagram(array(
                    'apiKey'      => $settings['instagram_client'],
                    'apiSecret'   => $settings['instagram_secret'],
                    'apiCallback' => (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST']).Zend_Registry::get('StaticBaseUrl').'sesmediaimporter/auth/instagram'
                  ));
    Zend_Registry::set('Instagram_Api', $this->_api);
    if($auth)
      return $this->_api;
    // Try to log viewer in?
    if (!empty($_SESSION['sesmediaimporter_instagram'])) {
      $_SESSION['instagram_lock'] = true;
      $inst_uid = Engine_Api::_()->getDbtable('instagram', 'sesmediaimporter')
          ->fetchRow(array('user_id = ?' => $viewer->getIdentity()));
      if($inst_uid){
        $this->_api->setAccessToken($inst_uid->access_token); 
        $user = $this->_api->getUser();
        if(empty($user->data->username))
          return false;
      }
   }else
     $_SESSION['instagram_lock']  = '';
   
   return $this->_api;
 }
   public function isConnected(){
     // Need to initialize
    $settings['instagram_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientid','');
    $settings['instagram_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientsecret','');
    if( empty($settings['instagram_client']) || empty($settings['instagram_secret']) ) 
      return false;
     return true;
   }
  
  public static function loginButton()
  {
     return Zend_Controller_Front::getInstance()->getRouter()
        ->assemble(array('module' => 'sesmediaimporter', 'controller' => 'auth',
          'action' => 'instagram'), 'default', true); 
  }
}
