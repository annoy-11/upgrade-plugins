<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Businessroles.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Businessroles extends Engine_Db_Table {

  protected $_edit;
  protected $_levelId;

  public function getAllBusinessAdmins($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('business_id =?', $params['business_id'])
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
            ->where('business_id =?', $params['business_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'sesbusiness')->info('name');
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
            ->where('business_id =?', $params['business_id']);
    $memberroles = Engine_Api::_()->getDbTable('memberroles', 'sesbusiness')->info('name');
    $select->setIntegrityCheck(false);
    $select->joinLeft($memberroles, $memberroles . '.memberrole_id =' . $this->info('name') . '.memberrole_id', null);
    $select->where($memberroles . '.type =?', 1);
    $res = $this->fetchAll($select);
    return count($res);
  }

  public function toCheckUserBusinessRole($user_id = "", $business_id = "", $role = "", $permissionType = "", $canEdit = true) {
    if (!$business_id || !$role)
      return false;
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewId = $viewer->getIdentity();
    if (!$user_id && !$viewId)
      return false;
    else if (!$user_id)
      $user_id = $viewId;
    if ($this->_edit == null) {
        $business = Engine_Api::_()->getItem('businesses', $business_id);
        $user = $business && $business->getIdentity() ? Engine_Api::_()->getItem('user', Engine_Api::_()->getItem('businesses', $business_id)->owner_id) : 0;
        $this->_levelId = $user && $user->getIdentity() ? $user->level_id : 0;

        $this->_edit = Engine_Api::_()->authorization()->isAllowed('businesses', $this->_levelId, 'edit');
    }
    if ($permissionType) {
      if ((!$this->_edit && $permissionType != 'delete' && $canEdit) || !Engine_Api::_()->authorization()->isAllowed('businesses', $this->_levelId, $permissionType))
        return false;
      if ($permissionType == 'seb_attribution') {
        if (!Engine_Api::_()->authorization()->isAllowed('businesses', $this->_levelId, 'auth_defattribut'))
          return false;
      }
    }

    if ($viewer->isAdminOnly())
      return true;

    $package = false;
    //package
    if (!$package) {
      //member level
      //$permissionLevel = Engine_Api::_()->getItem('businesses',$business_id)->authorization()->getAllowed($viewer,$permissionType);
      //if($permissionLevel)
      //return true;
    }

    //check admin
    $isAdmin = $this->isAdmin(array('user_id' => $viewId, 'business_id' => $business_id));
    if ($isAdmin)
      return true;
    $permissionTableName = Engine_Api::_()->getDbTable('memberrolepermissions', 'sesbusiness')->info('name');
    $select = $this->select()->from($this->info('name'), 'businessrole_id')->where('business_id =?', $business_id)->where('user_id =?', $user_id);
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
