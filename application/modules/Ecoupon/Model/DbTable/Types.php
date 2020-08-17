<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Ecoupon.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Ecoupon_Model_DbTable_Types extends Core_Model_Item_DbTable_Abstract {
  public function getIntegratedModules($isPackages = 0) {
    $select = $this->select()->from($this->info('name'),'*');
    if(!empty($isPackages))
      $select->where('is_package = ?', 1);
    return $this->fetchAll($select);
  } 
}
