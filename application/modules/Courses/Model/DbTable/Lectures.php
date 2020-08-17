<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Lectures.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Lectures extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Courses_Model_Lecture";
   protected $_type = 'courses_lectures';
  public function countLectures($userId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(lecture_id)"));
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }
  public function getLecturesPaginator($params = array(),$customFields = array('*')){
    return Zend_Paginator::factory($this->getLecturesSelect($params,$customFields));
  }
  public function getLecturesSelect($params = array(),$customFields = array('*'))
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $currentTime = date('Y-m-d H:i:s');
    $lectureTableName = $this->info('name');
    $select = $this->select()->from($this->info('name'),$customFields);
    if(!empty($params['course_id']) && is_numeric($params['course_id']) )
        $select->where($lectureTableName.'.course_id = ?', $params['course_id']);
    if (isset($params['parent_id']))
      $select->where($lectureTableName . '.parent_id =?', $params['parent_id']);
    if (isset($params['as_preview']))
      $select->where($lectureTableName . '.as_preview =?', $params['as_preview']);
    if (!empty($params['user_id'])) {
      $select->where($lectureTableName . '.owner_id =?', $params['user_id']);
    }
    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$lectureTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$lectureTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				 $select->order($lectureTableName . '.' .$params['popularCol'] . ' ASC');
			}
    }
    if (isset($params['limit']))
      $select->limit($params['limit']);
    $select->order($lectureTableName . '.lecture_id ASC');
    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
  public function videoLightBox($lecture = null, $nextPreviousCondition, $getallvideos = false, $paginator = false,$type = '',$item_id = '') {
    //getSEVersion for lower version of SE
    $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
    if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.6') < 0) {
      $toArray = true;
    } else
      $toArray = false;
    $lectureTableName = $this->info('name');
    $select = $this->select()
            ->from($lectureTableName);
		// custom query as per status assign
    if ($getallvideos) {
      $select->order('creation_date DESC');
      return Zend_Paginator::factory($select);
    }
    $select->where($lectureTableName . '.as_preview =?', 1);
    $select->limit('1');
		if($type == ''){
			if ($nextPreviousCondition == '<'){
				$select->order('lecture_id ASC');
				 $select->where("$lectureTableName.lecture_id > $lecture->lecture_id");
			}else{
				$select->order('lecture_id DESC');
				 $select->where("$lectureTableName.lecture_id < $lecture->lecture_id");
			}
		}
    $select->order('creation_date DESC');
    if ($paginator)
      return Zend_Paginator::factory($select);
    if ($toArray) {
      $lecture = $this->fetchAll($select);
      if (!empty($lecture))
        $lecture = $lecture->toArray();
      else
        $lecture = '';
    }else {
      $lecture = $this->fetchRow($select);
    }
    return $lecture;
  }
}
