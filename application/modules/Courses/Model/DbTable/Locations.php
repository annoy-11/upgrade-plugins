<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Locations.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Locations extends Engine_Db_Table {
  protected $_rowClass = "Courses_Model_Location";
  public function getCourseLocationPaginator($params = array()) {
    return Zend_Paginator::factory($this->getCourseLocationSelect($params));
  }
  public function getCourseLocationSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('course_id =?', $params['course_id']);
    if(isset($params['content']) && !empty($params['content'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
  function getLocationData($params=array()) {
    $lName = $this->info('name');
    $select = $this->select()
            ->from($lName)
            ->where('location_id =?', $params['location_id']);
    $row = $this->fetchRow($select);
    return $row;
  }
}
