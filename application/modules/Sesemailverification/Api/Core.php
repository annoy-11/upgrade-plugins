<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemailverification_Api_Core extends Core_Api_Abstract {

  public function getUserEmail($user_id) {
  
    $userTeable = Engine_Api::_()->getDbTable('users', 'user');
    
    return $userTeable->select()->from($userTeable->info('name'), 'email')
                      ->where('user_id =?', $user_id)
                      ->limit(1)
                      ->query()
                      ->fetchColumn();
  }
}