<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Linkclassrooms.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Linkclassrooms extends Engine_Db_Table {
  protected $_rowClass = "Eclassroom_Model_Linkclassroom";
  public function getLinkClassroomPaginator($params = array()) {
    return Zend_Paginator::factory($this->getLinkClassroomSelect($params));
  }
  public function getLinkClassroomSelect($params = array()) {
    $classroomTable = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
    $classroomTableName = $classroomTable->info('name');
    $linkclassroomTableName = $this->info('name');
    $select = $classroomTable->select()->setIntegrityCheck(false);
    $select->from($classroomTableName);
    $select->join($linkclassroomTableName, "$linkclassroomTableName.link_classroom_id = $classroomTableName.classroom_id", 'active')
            ->where($linkclassroomTableName . '.classroom_id = ?', $params['classroom_id']);
    return $select;
  }

}
