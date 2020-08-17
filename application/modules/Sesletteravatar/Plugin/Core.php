<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesletteravatar_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onUserCreateAfter($event) {

    $user = $event->getPayload();
    if($_SESSION['User_Plugin_Signup_Photo']['skip']) {
    
      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessociallogin')) {
        $profile_type = $_SESSION["Sessociallogin_Plugin_Signup_Account"]["data"]["profile_type"];
      } else {
        $profile_type = $_SESSION["User_Plugin_Signup_Account"]["data"]["profile_type"];
      }
      $firstNameFieldId = Engine_Api::_()->sesletteravatar()->getFieldId(array('first_name'), $profile_type);
      $lastNameFieldId = Engine_Api::_()->sesletteravatar()->getFieldId(array('last_name'), $profile_type);
      
      $firstName = $_SESSION['User_Plugin_Signup_Fields']['data'][$firstNameFieldId];
      $lastName = $_SESSION['User_Plugin_Signup_Fields']['data'][$lastNameFieldId];
      $displayName = $firstName . ' ' . $lastName;
      Engine_Api::_()->sesletteravatar()->letterAvatar($user, $displayName);
    }
  }
  
  public function onUserUpdateAfter($event) {
  
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();
		
    $user = $event->getPayload();
    
    if(empty($user->photo_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.replacephoto', 1)) {
      $displayName = $user->getTitle();
      Engine_Api::_()->sesletteravatar()->letterAvatar($user, $displayName);
    }
  }
}
