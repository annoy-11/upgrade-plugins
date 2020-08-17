<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Orders.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Orders extends Engine_Db_Table {
  protected $_rowClass = "Courses_Model_Order";
  protected $_type = 'courses_orders';
  public function getOrder($params = array()){
		$select = $this->select()->where('owner_id =?',$params['owner_id'])->where('is_delete =?',0);
		return $this->fetchAll($select);
	}
	public function getOrderStatus($order_id = ''){
		return $this->select()
          ->from($this->info('name'), new Zend_Db_Expr('COUNT(*)'))
          //->where('state =?', 'complete')
          ->where('order_id =?',$order_id)
          ->query()
          ->fetchColumn();
	}
	public function getOrders($params = array()){
		$orderTableName = $this->info('name');
		$courseTableName = Engine_Api::_()->getItemTable('courses')->info('name');
		$select = $this->select()->from($orderTableName)->where($orderTableName.'.is_delete = ?',0)->where($courseTableName.'.is_delete = ?',0)->setIntegrityCheck(false)
		 						->joinLeft($courseTableName, "$orderTableName.course_id = $courseTableName.course_id", array());
		//$select->where('state =?','complete');
		 if(isset($params['viewer_id']))
		 	$select->where('owner_id =?',$params['viewer_id']);
		 if(isset($params['course_id']))
		 	$select->where($orderTableName.'.course_id =?',$params['course_id']);
		 if(isset($params['groupBy']))
		 	$select->group($params['groupBy']);
			if (isset($params['view_type'])) {
				$now = date("Y-m-d H:i:s");
				if ($params['view_type'] == 'current')
						$select->where("$courseTableName.endtime >= '$now'");
			  else
						$select->where("$courseTableName.endtime < ?", $now);
        $select->order('creation_date DESC');
			}
			$paginator = Zend_Paginator::factory($select);
			if (!empty($params['page']))
					$paginator->setCurrentPageNumber($params['page']);
			if (!empty($params['limit']))
					$paginator->setItemCountPerPage($params['limit']);
			return $paginator;
	}
	public function getSaleStats($params = array()){
    $orderTableName = $this->info('name');
		 $select = $this->select()
                    ->from($this->info('name'), array('total_amount'=>new Zend_Db_Expr("sum(total)"),'total_billingtax_cost' => new 
                    Zend_Db_Expr("sum(total_billingtax_cost)"),'totalAmountSale' => new Zend_Db_Expr("(sum(total_billingtax_cost) + sum(total))")))
                  ->setIntegrityCheck(false)
                  ->joinLeft('engine4_courses_order_courses', "$orderTableName.order_id = engine4_courses_order_courses.order_id",null)
                  ->where($this->info('name').".state = 'complete'");
    if ($params['course_id'])
      $select->where('engine4_courses_order_courses.course_id =?',$params['course_id']);
    if ($params['classroom_id'])
      $select->where('engine4_courses_order_courses.classroom_id =?',$params['classroom_id']);
    if ($params['stats'] == 'year')
          $select->where("YEAR(".$orderTableName.".creation_date) = YEAR(NOW())");
    if ($params['stats'] == 'month')
          $select->where("YEAR(".$orderTableName.".creation_date) = YEAR(NOW()) AND MONTH(".$orderTableName.".creation_date) = MONTH(NOW())");
    if ($params['stats'] == 'week')
          $select->where("YEARWEEK(".$orderTableName.".creation_date) = YEARWEEK(CURRENT_DATE)");
    if ($params['stats'] == 'today')
            $select->where("DATE(".$orderTableName.".creation_date) = DATE(NOW())"); 
  
    return $select->query()->fetchColumn();
	}
	public function getCourseStats($params = array()) {
        $orderTableName = $this->info('name');
        $select = $this->select()
            ->from($this->info('name'), array('total_amount'=>new Zend_Db_Expr("sum(total)"),'totalOrder'=> new Zend_Db_Expr("COUNT(engine4_courses_order_courses.order_id)"),"commission_amount" => new Zend_Db_Expr("SUM(commission_amount)"), 'total_billingtax_cost' => new Zend_Db_Expr("sum(total_billingtax_cost)"),'total_courses' => new Zend_Db_Expr("COUNT(ordercourse_id)")))
            ->setIntegrityCheck(false)
            ->joinLeft('engine4_courses_order_courses', "$orderTableName.order_id = engine4_courses_order_courses.order_id",null)
            ->where($this->info('name').".state = 'complete' OR state = 'processing'");
            if ($params['course_id'])
              $select->where('engine4_courses_order_courses.course_id =?',$params['course_id']);
            if ($params['classroom_id'])
              $select->where('engine4_courses_order_courses.classroom_id =?',$params['classroom_id']);
        return $select->query()->fetch();
	}
	public function manageOrders($params = array()){
    $addressTable =   Engine_Api::_()->getDbtable('addresses', 'courses');
    $addressTableName = $addressTable->info('name');
		$orderTableName = $this->info('name');
		$select = $this->select()
		->from($this->info('name'));
		//->where("state = 'complete'");
		$userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$select ->setIntegrityCheck(false)->joinLeft($userTableName, "$orderTableName.user_id = $userTableName.user_id", array())
		->joinLeft($addressTableName, "$orderTableName.user_id = $addressTableName.user_id", array('buyer_name'=>'CONCAT('.$addressTableName.'.first_name," ",'.$addressTableName.'.last_name)'))
		->joinLeft('engine4_courses_order_courses', "$orderTableName.order_id = engine4_courses_order_courses.order_id",array('total','commission_amount'));

    if (!empty($params['course_id']))
      $select->where($orderTableName . '.course_id =?', $params['course_id']);
    if(!empty($params['buyer_name'])){
      $select->where('CONCAT('.$addressTableName.'.first_name," ",'.$addressTableName.'.last_name) LIKE ?', '%' . $params['buyer_name'] . '%');
    }
		if (!empty($params['order_id']))
            $select->where($orderTableName . '.order_id =?', $params['order_id']);
        if (!empty($params['user_id']))
            $select->where($orderTableName . '.user_id =?', $params['user_id']);
		if (!empty($params['order_max']))
            $select->having("engine4_courses_order_courses.total <=?", $params['order_max']);
		if (!empty($params['order_min']))
            $select->having("engine4_courses_order_courses.total >=?", $params['order_min']);
		if (!empty($params['commision_min']))
            $select->where("engine4_courses_order_courses.commission_amount >=?", $params['commision_min']);
		if (!empty($params['commision_max']))
            $select->where("engine4_courses_order_courses.commission_amount <=?", $params['commision_max']);
		if (!empty($params['gateway']))
            $select->where($orderTableName . '.gateway_type LIKE ?', '%' . $params['gateway'] . '%');
		if(!empty($params['date_to']) && !empty($params['date_from']))
			$select->where("DATE($orderTableName.creation_date) BETWEEN '".$params['date_to']."' AND '".$params['date_from']."'");
		else{
			if (!empty($params['date_to']))
					$select->where("DATE($orderTableName.creation_date) >=?", $params['date_to']);
			if (!empty($params['date_from']))
					$select->where("DATE($orderTableName.creation_date) <=?", $params['date_from']);
		}
		$select->group($orderTableName.'.order_id');
		$select->order('order_id DESC');
		return $select;
	}
	public function getCourseReportData($params = array()){
		$orderTableName = $this->info('name');
		$select = $this->select()->from($orderTableName,array('total_orders'=>"COUNT(*)",'commission_amount' => new Zend_Db_Expr("sum(commission_amount)") ,'total_amount'=>new Zend_Db_Expr("sum(total)"),'total_billingtax_cost' => new Zend_Db_Expr("sum(total_billingtax_cost)"),'totalAmountSale' => new Zend_Db_Expr("(sum(total_billingtax_cost) + sum(total) - SUM(commission_amount))"),"$orderTableName.creation_date"))
		->setIntegrityCheck(false)
    ->joinLeft('engine4_courses_order_courses', "$orderTableName.order_id = engine4_courses_order_courses.order_id",null);
		if(!empty($params['course_id']))
			$select->where('engine4_courses_order_courses.course_id =?',$params['course_id']);
    if(!empty($params['classroom_id']))
			$select->where('engine4_courses_order_courses.classroom_id =?',$params['classroom_id']);
		$select->where($orderTableName.'.state =?','complete');
		if(isset($params['type'])){
			if($params['type'] == 'month'){
				$select->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m') <= ?", $params['enddate'])
							 ->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m') >= ?", $params['startdate'])
							 ->group("engine4_courses_order_courses.course_id")
							 ->group("YEAR($orderTableName.creation_date)")
							 ->group("MONTH($orderTableName.creation_date)");
			}else{
				$select->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m-%d') <= ?", $params['enddate'])
							 ->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m-%d') >= ?", $params['startdate'])
							 ->group("engine4_courses_order_courses.course_id")
							 ->group("YEAR($orderTableName.creation_date)")
							 ->group("MONTH($orderTableName.creation_date)")
							 ->group("DAY($orderTableName.creation_date)");
			}
		}
		return $this->fetchAll($select);
	}
  public function getCourseOrderReport($params = array()){
		$orderTableName = $this->info('name');
		$select = $this->select()->from($orderTableName,array('total_orders'=>"COUNT(*)",'commission_amount' => new Zend_Db_Expr("sum(commission_amount)") ,'total_amount'=>new Zend_Db_Expr("sum(total)"),'total_billingtax_cost' => new Zend_Db_Expr("sum(total_billingtax_cost)"),'totalAmountSale' => new Zend_Db_Expr("(sum(total_billingtax_cost) + sum(total) - SUM(commission_amount))"),"$orderTableName.creation_date"))
		->setIntegrityCheck(false)
    ->joinLeft('engine4_courses_order_courses', "$orderTableName.order_id = engine4_courses_order_courses.order_id",null);
		if(!empty($params['course_id'])){
			$select->where('engine4_courses_order_courses.course_id =?',$params['course_id']);
    }
    if(!empty($params['classroom_id']))
			$select->where('engine4_courses_order_courses.classroom_id =?',$params['classroom_id']);
		$select->where($orderTableName.'.state =?','complete');
		if(isset($params['type'])){
			if($params['type'] == 'monthly'){ 
				$select->group("MONTH($orderTableName.creation_date)");
			}elseif($params['type'] == 'weekly'){
        $select->group("WEEK($orderTableName.creation_date)");
			}elseif($params['type'] == 'daily'){
        $select->group("date_format($orderTableName.creation_date, '%Y-%m-%d' )");
			}elseif($params['type'] == 'hourly'){ 
        $select->group("hour($orderTableName.creation_date)");
			}
		}
		if(!empty($params['earning'])){
      $select->group("engine4_courses_order_courses.course_id");
      return $this->fetchRow($select);
    }
		return $this->fetchAll($select);
	}
}
