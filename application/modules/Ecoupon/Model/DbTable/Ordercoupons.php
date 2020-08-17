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
class Ecoupon_Model_DbTable_Ordercoupons extends Core_Model_Item_DbTable_Abstract {
  protected $_rowClass = "Ecoupon_Model_Ordercoupon";
  
  public function getOrderCouponCount(array $params = array()) {
    $select = $this->select()->from($this->info('name'),array("coupon_count"=>"COUNT(coupon_id)"));
    if(isset($params['coupon_id']))
      $select->where('coupon_id = ?',$params['coupon_id']);
    return $select->query()->fetchColumn();
  }
}
