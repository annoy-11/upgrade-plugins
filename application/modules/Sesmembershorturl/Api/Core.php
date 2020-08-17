<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershorturl_Api_Core extends Core_Api_Abstract {

  public function getUserName($username) {
    $username = str_replace('+', ' ', $username);
    $user = Engine_Api::_()->getDbTable('users', 'user');
    $select = $user->select()
                    ->from($user->info('name'), array('user_id'));
    if(intval($username) == 0) {
      $select->where('username =?', $username);
    } else {
      $select->where('user_id =?', $username);
    }
                  return  $select->query()
                    ->fetchColumn();
  }

  public function getLevelValue($level_id, $name, $columnName) {

    $authorization = Engine_Api::_()->getDbTable('permissions', 'authorization');
    return $authorization->select()
                    ->from($authorization->info('name'), $columnName)
                    ->where('level_id =?', $level_id)
                    ->where('type =?', 'sesmerurl')
                    ->where('name =?', $name)
                    ->query()
                    ->fetchColumn();
  }


  public function getUserId($username) {

    $usersTable = Engine_Api::_()->getDbTable('users', 'user');
    return $usersTable->select()
                    ->from($usersTable->info('name'), 'user_id')
                    ->where('username =?', $username)
                    ->query()
                    ->fetchColumn();
  }
}
