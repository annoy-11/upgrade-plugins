<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Orderspackages.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppackage_Model_DbTable_Orderspackages extends Engine_Db_Table {

  protected $_rowClass = 'Sesgrouppackage_Model_Orderspackage';

  public function getLastOrdersTransaction($params = array()) {
    $select = $this->select()->from($this->info('name'))->order('orderspackage_id DESC')->limit(1);
    if (isset($params['owner_id']))
      $select->where('owner_id =?', $params['owner_id']);
    return $this->fetchRow($select);
  }

  public function getLeftPackages($params = array()) {
    $select = $this->select()->from($this->info('name'))->order('orderspackage_id ASC');
    $select->where('item_count != 0 || item_count < 0');
    if (isset($params['owner_id']))
      $select->where('owner_id =?', $params['owner_id']);
    return $this->fetchAll($select);
  }

  public function checkUserPackage($packageId = null, $ownerId = null) {
    $select = $this->select()->from($this->info('name'))
            ->where('owner_id =?', $ownerId)
            ->where('orderspackage_id =?', $packageId);
    $package = $this->fetchRow($select);
    if (($package) && $package->item_count)
      return 1;
    else
      return 0;
  }

}
