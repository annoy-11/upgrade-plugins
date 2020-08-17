<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Announcements.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Model_DbTable_Announcements extends Engine_Db_Table {

  protected $_rowClass = 'Eclassroom_Model_Announcement';

  public function getClassroomAnnouncementPaginator($params = array(),$customFields = array('*')) {
    return Zend_Paginator::factory($this->getClassroomAnnouncementSelect($params, $customFields));
  }

  public function getClassroomAnnouncementSelect($params = array(),$customFields = array('*')) {
    $select = $this->select()
            ->from($this->info('name'),$customFields)
            ->where('classroom_id =?', $params['classroom_id']);
    return $select;
  }

}
