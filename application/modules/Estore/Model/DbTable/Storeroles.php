<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Storeroles.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Storeroles extends Engine_Db_Table {

  protected $_edit;
  protected $_levelId;

  public function getAllStoreAdmins($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('store_id =?', $params['store_id'])
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
            ->where('store_id =?', $params['store_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'estore')->info('name');
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
            ->where('store_id =?', $params['store_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'estore')->info('name');
    $select->setIntegrityCheck(false);
    $select->joinLeft($memberroles, $memberroles . '.memberrole_id =' . $this->info('name') . '.memberrole_id', null);
    $select->where($memberroles . '.type =?', 1);
    $res = $this->fetchAll($select);
    return count($res);
  }
  public function toCheckUserStoreRole($user_id = "", $store_id = "", $role = "", $permissionType = "", $canEdit = true) {
    if (!$store_id || !$role)
      return false;
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewId = $viewer->getIdentity();
    if (!$user_id && !$viewId)
      return false;
    else if (!$user_id)
      $user_id = $viewId;
    if ($this->_edit == null) {
      $user = Engine_Api::_()->getItem('user', Engine_Api::_()->getItem('stores', $store_id)->owner_id);
      $this->_levelId = !is_null($user) ? $user->level_id : 0;
      $this->_edit = Engine_Api::_()->authorization()->isAllowed('stores', $this->_levelId, 'edit');
    }
    if ($permissionType) {
      if ((!$this->_edit && $permissionType != 'delete' && $canEdit) || !Engine_Api::_()->authorization()->isAllowed('stores', $this->_levelId, $permissionType))
        return false;
      if ($permissionType == 'seb_attribution') {
        if (!Engine_Api::_()->authorization()->isAllowed('stores', $this->_levelId, 'auth_defattribut'))
          return false;
      }
    }

    if ($viewer->isAdminOnly())
      return true;

    $package = false;
    //package
    if (!$package) {
      //member level
      //$permissionLevel = Engine_Api::_()->getItem('stores',$store_id)->authorization()->getAllowed($viewer,$permissionType);
      //if($permissionLevel)
      //return true;
    }

    //check admin
    $isAdmin = $this->isAdmin(array('user_id' => $viewId, 'store_id' => $store_id));
    if ($isAdmin)
      return true;
    $permissionTableName = Engine_Api::_()->getDbTable('memberrolepermissions', 'estore')->info('name');
    $select = $this->select()->from($this->info('name'), 'storerole_id')->where('store_id =?', $store_id)->where('user_id =?', $user_id);
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
