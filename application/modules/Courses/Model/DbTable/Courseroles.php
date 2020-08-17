<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Courseroles.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Courseroles extends Engine_Db_Table {

  protected $_edit;
  protected $_levelId;
  public function getAllCourseAdmins($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('course_id =?', $params['course_id'])
            ->where('user_id != ?', $params['user_id']);
    return $this->fetchAll($select);
  }
  function adminCount($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('course_id =?', $params['course_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'courses')->info('name');
    $select->setIntegrityCheck(false);
    $select->joinLeft($memberroles, $memberroles . '.memberrole_id =' . $this->info('name') . '.memberrole_id', null);
    $select->where($memberroles . '.type =?', 1);
    $res = $this->fetchAll($select);
    return count($res);
  }
  function isAdmin($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('course_id =?', $params['course_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'courses')->info('name');
    $select->setIntegrityCheck(false);
    $select->joinLeft($memberroles, $memberroles . '.memberrole_id =' . $this->info('name') . '.memberrole_id', null);
    $select->where($memberroles . '.type =?', 1)
            ->where($this->info('name') . '.user_id =?', $params['user_id']);
    $res = $this->fetchRow($select);
    return ($res);
  }
  public function toCheckUserCourseRole($user_id = "", $course_id = "", $role = "", $permissionType = "", $canEdit = true) {
    if (!$course_id || !$role)
      return false;
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewId = $viewer->getIdentity();
    if (!$user_id && !$viewId)
      return false;
    else if (!$user_id)
      $user_id = $viewId;

    if ($this->_edit == null) {
      $user = Engine_Api::_()->getItem('user', Engine_Api::_()->getItem('courses', $course_id)->owner_id);
      $this->_levelId = !is_null($user) ? $user->level_id : 0;
      $this->_edit = Engine_Api::_()->authorization()->isAllowed('courses', $this->_levelId, 'edit');
    }
    if ($permissionType) {
      if ((!$this->_edit && $permissionType != 'delete' && $canEdit) || !Engine_Api::_()->authorization()->isAllowed('courses', $this->_levelId, $permissionType))
        return false;
      if ($permissionType == 'seb_attribution') {
        if (!Engine_Api::_()->authorization()->isAllowed('courses', $this->_levelId, 'auth_defattribut'))
          return false;
      }
    }
    if ($viewer->isAdminOnly())
       return true;
    $classroomAdmin = Engine_Api::_()->courses()->checkCourseAdmin($course_id);
    if($classroomAdmin)
      return true;
    //check admin
    $isAdmin = $this->isAdmin(array('user_id' => $viewId, 'course_id' => $course_id));
     if ($isAdmin)
       return true;
    $permissionTableName = Engine_Api::_()->getDbTable('memberrolepermissions', 'courses')->info('name');
    $select = $this->select()->from($this->info('name'), 'courserole_id')->where('course_id =?', $course_id)->where('user_id =?', $user_id);
    $select->setIntegrityCheck(false);
    $select->joinLeft($permissionTableName, $permissionTableName . '.memberrole_id =' . $this->info('name') . '.memberrole_id', 'memberrolepermission_id')
            ->where($permissionTableName . '.type =?', $role)
            ->where($permissionTableName . '.memberrolepermission_id IS NOT NULL');
    $result = $this->fetchRow($select);
    if ($result)
      return true;
    else
      return false;
  }

}
