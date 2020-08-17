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
class Ecoupon_Model_DbTable_Coupons extends Core_Model_Item_DbTable_Abstract {
  protected $_rowClass = "Ecoupon_Model_Coupon";
  public function isAvailable($coupon = '') {
    $select = $this->select('coupon_id')->where('coupon_code = ?', $coupon);
    return $select->query()->fetchColumn();
  }
  public function getCouponDetails($params = array()) {
    $select = $this->select()->from($this->info('name'),'*');
    if(!empty($params['coupon_code']))
      $select->where('coupon_code = ?', $params['coupon_code']);
    if(isset($params['resource_type']) && !empty($params['resource_type']) && isset($params['is_package']) && !empty($params['is_package'])) {
      $select->where("item_type = '".$params['resource_type']."' OR item_type = 'all'");
    }
    if(@(isset($params['is_package']) && !empty($params['is_package'])) || $params['resource_type'] == 'sescredit')
      $select->where('is_package = ?', 1);
    else
      $select->where('is_package = ?', 0);
    return $this->fetchRow($select);
  } 
  public function getItems(array  $params = array('column_name'=>array('*'))) {
    $select = $this->select()->from($this->info('name'),$params['column_name']);
    $select->group('resource_type');
    return $this->fetchAll($select);
  } 
  public function getCouponsPaginator($params = array(),$customFields = array('*')){
    return Zend_Paginator::factory($this->getCouponsSelect($params,$customFields));
  }
  public function getCouponsSelect($params = array(),$customFields = array('*'))
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $currentTime = date('Y-m-d H:i:s');
    $couponTableName = $this->info('name');
    $select = $this->select()->from($this->info('name'),$customFields);
    if(!empty($params['resource_id']) && is_numeric($params['resource_id']) )
        $select->where($couponTableName.'.resource_id = ?', $params['resource_id']);
    if (isset($params['resource_type']))
      $select->where($couponTableName . '.resource_type =?', $params['resource_type']);
    if (!empty($params['text']))
      $select->where($couponTableName . ".title LIKE ? OR " . $couponTableName . ".description LIKE ?", '%' . $params['text'] . '%');
    if (!empty($params['alphabet']) && $params['alphabet'] !='all')
      $select->where($couponTableName . '.title LIKE ?', '%'.$params['alphabet'].'%');
    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$couponTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$couponTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				 $select->order($couponTableName . '.' .$params['popularCol'] . ' ASC');
			}
    } 
    if($params['widget'] == 'manage-coupons'){
      $select->where($couponTableName . '.owner_id = ?',$viewerId);
    }
    if (isset($params['limit']))
      $select->limit($params['limit']);
    $select->order($couponTableName . '.coupon_id ASC');
    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
  public function getOfTheDayResults($categoryId = null,$customFields = array('*')) {
    $select = $this->select()
            ->from($this->info('name'),$customFields)
            ->where('offtheday =?', 1)
            ->where('startdate <= DATE(NOW())')
            ->where('enddate >= DATE(NOW())');
    $select->order('RAND()');
    return $this->fetchRow($select);
  }
}
