<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    User
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Facebook.php 9747 2012-07-26 02:08:08Z john $
 * @author     Steve
 */

/**
 * @category   Application_Core
 * @package    User
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class User_Model_DbTable_Weibo extends Engine_Db_Table
{  
  /**
   * Generates the button used for Facebook Connect
   *
   * @param mixed $fb_params A string or array of Facebook parameters for login
   * @param string $connect_with_facebook The string to display inside the button
   * @return String Generates HTML code for facebook login button
   */
  public static function loginButton($connect_text = 'Connect with Weibo')
  {
    $settings  = Engine_Api::_()->getApi('settings', 'core');
    //$facebook  = self::getFBInstance();

    /*if( !$facebook ) {
      return;
    }*/

    $href = Zend_Controller_Front::getInstance()->getRouter()
        ->assemble(array('module' => 'user', 'controller' => 'auth',
          'action' => 'weibo'), 'default', true);
    $imgHref = ''; //Zend_Registry::get('StaticBaseUrl')
        //. 'application/modules/User/externals/images/facebook-sign-in.gif';
    //$imgHref = 'http://static.ak.fbcdn.net/rsrc.php/z38X1/hash/6ad3z8m6.gif';
    return '
      <a href="'.$href.'">
        <img src="' . $imgHref . '" border="0" alt="'.$connect_text.'" />
      </a>
    ';
  }
  
  public static function signup(User_Form_Account $form)
  {
    
  }
}
