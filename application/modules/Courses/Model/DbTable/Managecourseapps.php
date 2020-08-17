<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Manageclassroomapps.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Managecourseapps extends Engine_Db_Table {

  protected $_rowClass = "Courses_Model_Managecourseapp";
  protected $_name = "courses_managecourseapps";

  public function isCheck($params = array()) {
    $select = $this->select()
            ->from($this->info('name'), $params['columnname'])
            ->where('course_id = ?', $params['course_id']);

    if(isset($params['limit']) && !empty($params['limit']))
        $select->limit($params['limit']);

    return   $select->query()
                ->fetchColumn();
  }
  public function getManagecourseId($params = array()) {
    return $this->select()
            ->from($this->info('name'), 'managecourseapp_id')
            ->where('course_id = ?', $params['course_id'])
            ->query()
            ->fetchColumn();
  }
}
