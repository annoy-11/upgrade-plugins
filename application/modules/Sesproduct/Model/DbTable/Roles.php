<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Roles.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_DbTable_Roles extends Engine_Db_Table {
  /**
   * Gets a paginator for sesproducts
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getProductAdmins($params = array()) {

    $select = $this->select()->where('product_id =?', $params['product_id']);
    return Zend_Paginator::factory($select);
  }

  public function isProductAdmin($productId = null, $productAdminId = null) {
    return $this->select()->from($this->info('name'), 'role_id')
    ->where('user_id =?', $productAdminId)
    ->where('product_id =?', $productId)->query()->fetchColumn();
  }
}
