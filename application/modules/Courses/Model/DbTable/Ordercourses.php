<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Ordercourses.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Ordercourses extends Engine_Db_Table {
   protected $_rowClass = "Courses_Model_Ordercourse";
   protected $_type = 'courses_order_courses';
   protected $_name = 'courses_order_courses';
    public function coursesOrders($params = array()){
		$orderTableName = $this->info('name');
		$addressTable =   Engine_Api::_()->getDbtable('addresses', 'courses');
    $addressTableName = $addressTable->info('name');
		$select = $this->select()->from($this->info('name'));
		if($params['course_id'])
      $select->where($this->info('name').'.course_id =?',$params['course_id']);
		if($params['classroom_id'])
      $select->where($this->info('name').'.classroom_id =?',$params['classroom_id']);
		//->where("state = 'complete'");
        $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$courseTable = Engine_Api::_()->getItemTable('courses_order')->info('name');
		$select->setIntegrityCheck(false)->joinLeft($courseTable, "$courseTable.order_id = $orderTableName.order_id",array('currency_symbol','item_count','gateway_id','total_amount','gateway_transaction_id','change_rate','state','total_billingtax_cost','gateway_type'))->joinLeft($addressTableName, "$orderTableName.user_id = $addressTableName.user_id", array('buyer_name'=>'CONCAT('.$addressTableName.'.first_name," ",'.$addressTableName.'.last_name)'));
		if(!empty($params['buyer_name'])){
      $select->where('CONCAT('.$addressTableName.'.first_name," ",'.$addressTableName.'.last_name) LIKE ?', '%' . $params['buyer_name'] . '%');
    }
		$select->group($orderTableName.'.order_id');
		if (!empty($params['order_id']))
				$select->where($orderTableName . '.order_id =?', $params['order_id']);
		if (!empty($params['order_max']))
				$select->having("total <=?", $params['order_max']);
		if (!empty($params['order_min']))
				$select->having("total >=?", $params['order_min']);
		if (!empty($params['commision_min']))
				$select->where("$orderTableName.commission_amount >=?", $params['commision_min']);
		if (!empty($params['commision_max']))
				$select->where("$orderTableName.commission_amount <=?", $params['commision_max']);
		if (!empty($params['gateway']))
				$select->where($courseTable . '.gateway_type LIKE ?', '%' . $params['gateway'] . '%');
		if(!empty($params['date_to']) && !empty($params['date_from']))
			$select->where("DATE($orderTableName.creation_date) BETWEEN '".$params['date_to']."' AND '".$params['date_from']."'");
		else{
			if (!empty($params['date_to']))
        $select->where("DATE($orderTableName.creation_date) >=?", $params['date_to']);
			if (!empty($params['date_from']))
        $select->where("DATE($orderTableName.creation_date) <=?", $params['date_from']);
		}
    $select->order($orderTableName.'.order_id DESC');
		return $select;
	}
  public function orderCourses($params = array()){
		$orderTableName = $this->info('name');
		$select = $this->select()
		->from($this->info('name'));
		$courseTable = Engine_Api::_()->getItemTable('courses_order')->info('name');
		$select ->setIntegrityCheck(false)
		->joinLeft($courseTable, "$courseTable.order_id = $orderTableName.order_id",'*');
		if (!empty($params['order_id']))
				$select->where($orderTableName . '.order_id =?', $params['order_id']);
       $select->order($orderTableName.'.order_id DESC');
		return $this->fetchAll($select);;
	}
  public function getCoursePurchasedMember($course_id) {
      $courseTable = Engine_Api::_()->getItemTable('courses_order')->info('name');
      $orderTableName = $this->info('name');
      $select = $this->select()
              ->from($this->info('name'),'user_id')
              ->setIntegrityCheck(false)->joinLeft($courseTable, "$courseTable.order_id = $orderTableName.order_id",null)
              ->where('course_id =?', $course_id)
              ->where($courseTable.".state = 'complete'")
              ->group($this->info('name').'.user_id');
      return $this->fetchAll($select);
  }
}
