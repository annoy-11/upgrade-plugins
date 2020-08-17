<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Api_Core extends Core_Api_Abstract {

  public function getAdminSuperAdmins() {
    $userTable = Engine_Api::_()->getDbTable('users', 'user');
    $select = $userTable->select()->from($userTable->info('name'), 'user_id')->where('level_id IN (?)', array(1,2));
    $results = $select->query()->fetchAll();
    return $results;
  }
}
