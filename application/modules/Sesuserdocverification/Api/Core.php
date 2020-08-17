<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Api_Core extends Core_Api_Abstract {

  public function getAdminnSuperAdmins() {
    $userTable = Engine_Api::_()->getDbTable('users', 'user');
    $select = $userTable->select()->from($userTable->info('name'), 'user_id')->where('level_id IN (?)', array(1,2));
    $results = $select->query()->fetchAll();
    return $results;
  }

  public function getSignupStep() {
    $userTable = Engine_Api::_()->getDbTable('signup', 'user');
    $select = $userTable->select()->from($userTable->info('name'), 'signup_id')->where('class = ?', 'Sesuserdocverification_Plugin_Signup_Documentverification');
    return $select->query()->fetchColumn();
  }
}
