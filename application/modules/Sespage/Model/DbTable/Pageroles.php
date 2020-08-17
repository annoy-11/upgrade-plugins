<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pageroles.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Pageroles extends Engine_Db_Table {

  protected $_edit;
  protected $_levelId;

  public function getAllPageAdmins($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('page_id =?', $params['page_id'])
            ->where('user_id != ?', $params['user_id']);
    return $this->fetchAll($select);
  }

  public function getRolesMember($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('memberrole_id =?', $params['memberrole_id']);
    return $this->fetchAll($select);
  }

  function isAdmin($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('page_id =?', $params['page_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'sespage')->info('name');
    $select->setIntegrityCheck(false);
    $select->joinLeft($memberroles, $memberroles . '.memberrole_id =' . $this->info('name') . '.memberrole_id', null);
    $select->where($memberroles . '.type =?', 1)
            ->where($this->info('name') . '.user_id =?', $params['user_id']);
    $res = $this->fetchRow($select);
    return ($res);
  }

  function adminCount($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('page_id =?', $params['page_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'sespage')->info('name');
    $select->setIntegrityCheck(false);
    $select->joinLeft($memberroles, $memberroles . '.memberrole_id =' . $this->info('name') . '.memberrole_id', null);
    $select->where($memberroles . '.type =?', 1);
    $res = $this->fetchAll($select);
    return count($res);
  }

  public function toCheckUserPageRole($user_id = "", $page_id = "", $role = "", $permissionType = "", $canEdit = true) {
    if (!$page_id || !$role)
      return false;
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewId = $viewer->getIdentity();
    if (!$user_id && !$viewId)
      return false;
    else if (!$user_id)
      $user_id = $viewId;
    if ($this->_edit == null) {
      $user = Engine_Api::_()->getItem('user', Engine_Api::_()->getItem('sespage_page', $page_id)->owner_id);
      if(!$user->getIdentity())
        return false;
      $this->_levelId = $user->level_id;
      $this->_edit = Engine_Api::_()->authorization()->isAllowed('sespage_page', $this->_levelId, 'edit');
    }
    if ($permissionType) {
      if ((!$this->_edit && $permissionType != 'delete' && $canEdit) || !Engine_Api::_()->authorization()->isAllowed('sespage_page', $this->_levelId, $permissionType))
        return false;
      if ($permissionType == 'page_attribution') {
        if (!Engine_Api::_()->authorization()->isAllowed('sespage_page', $this->_levelId, 'auth_defattribut'))
          return false;
      }
    }

    if ($viewer->isAdminOnly())
      return true;

    $package = false;
    //package     
    if (!$package) {
      //member level
      //$permissionLevel = Engine_Api::_()->getItem('sespage_page',$page_id)->authorization()->getAllowed($viewer,$permissionType);
      //if($permissionLevel)
      //return true;
    }

    //check admin
    $isAdmin = $this->isAdmin(array('user_id' => $viewId, 'page_id' => $page_id));
    if ($isAdmin)
      return true;
    $permissionTableName = Engine_Api::_()->getDbTable('memberrolepermissions', 'sespage')->info('name');
    $select = $this->select()->from($this->info('name'), 'pagerole_id')->where('page_id =?', $page_id)->where('user_id =?', $user_id);
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
