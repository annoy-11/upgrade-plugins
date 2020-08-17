<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Announcements.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_DbTable_Announcements extends Engine_Db_Table {
  protected $_rowClass = 'Courses_Model_Announcement';
  public function getCourseAnnouncementPaginator($params = array()) {
    return Zend_Paginator::factory($this->getCourseAnnouncementSelect($params));
  }
  public function getCourseAnnouncementSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('course_id =?', $params['course_id']);
    return $select;
  }
}
