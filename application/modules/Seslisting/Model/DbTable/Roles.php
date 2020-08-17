<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Roles.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Model_DbTable_Roles extends Engine_Db_Table {
  /**
   * Gets a paginator for seslistings
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getListingAdmins($params = array()) {

    $select = $this->select()->where('listing_id =?', $params['listing_id']);
    return Zend_Paginator::factory($select);
  }

  public function isListingAdmin($listingId = null, $listingAdminId = null) {
    return $this->select()->from($this->info('name'), 'role_id')
    ->where('user_id =?', $listingAdminId)
    ->where('listing_id =?', $listingId)->query()->fetchColumn();
  }
}
