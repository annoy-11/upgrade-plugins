<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Tests.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Tests extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Courses_Model_Test";
   protected $_type = 'courses_tests';
  public function countTests($userId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(test_id)"))->where('is_delete !=?', 1);
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }
  public function getTestsPaginator($params = array())
  {
    return Zend_Paginator::factory($this->getTestsSelect($params));
  }
  public function getTestsSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $currentTime = date('Y-m-d H:i:s');
    $testTableName = $this->info('name');
    $select = $this->select();
    $select->where($testTableName.'.is_delete != ?',1);
    if( !empty($params['course_id']) && is_numeric($params['course_id']) )
        $select->where($testTableName.'.course_id = ?', $params['course_id']);

    if (!empty($params['user_id'])) {
      $select->where($testTableName . '.owner_id =?', $params['user_id']);
    }
    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$testTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$testTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				 $select->order($testTableName . '.' .$params['popularCol'] . ' DESC');
			}
    }
    if (isset($params['limit']))
      $select->limit($params['limit']);
    $select->order($testTableName . '.creation_date DESC');
    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
}
