<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Api_Core extends Core_Api_Abstract {

  public function getTeamMembers($params = array()) {

    $teamTable = Engine_Api::_()->getDbtable('teams', 'sesteam');
    $teamTableName = $teamTable->info('name');

    $designationTable = Engine_Api::_()->getDbtable('designations', 'sesteam');
    $designationTableName = $designationTable->info('name');

    $designations = $designationTable->getDesignations();

    $select = $teamTable->select()
            ->from($teamTableName)
            ->where('enabled = ?', 1);

    if (!empty($params)) {

      if (!empty($params['designation_id']) && count($designations) > 1)
        $select->join($designationTableName, $designationTableName . '.designation_id = ' . $teamTableName . '.designation_id', null);

      if (!empty($params['title']))
        $select->where('name  LIKE ? ', '%' . $params['title'] . '%');

      if (!empty($params['designation_id'])) {
        $select->where($teamTableName . '.designation_id IN(?)', $params['designation_id']);
        //->where($teamTableName . '.designation_id = ?', $params['designation_id']);
      }

      if (!empty($params['popularity']) && $params['popularity'] == 'featured')
        $select->where($teamTableName . '.featured = ?', 1);
      elseif (!empty($params['popularity']) && $params['popularity'] == 'sponsored')
        $select->where($teamTableName . '.sponsored = ?', 1);

      if (!empty($params['type']))
        $select->where($teamTableName . '.type = ?', $params['type']);
    }

    if (count($designations) > 1)
      $select->order('order ASC');
    else
      $select->order('order ASC');

    if(!isset($params['widget']) && $params['widget'] != 'browse')
    return $teamTable->fetchAll($select);
  }

  public function getTeamPaginator($params = array()) {
    $paginator = Zend_Paginator::factory($this->getTeamMembers($params));
    if (!empty($params['page']))
      $paginator->setCurrentPageNumber($params['page']);

    if (!empty($params['limit']))
      $paginator->setItemCountPerPage($params['limit']);

    return $paginator;
  }

  //Get member profile type according to user.
  public function getProfileType($subject) {

    $fieldsByAlias = Engine_Api::_()->fields()->getFieldsObjectsByAlias($subject);
    if (!empty($fieldsByAlias['profile_type'])) {
      $optionId = $fieldsByAlias['profile_type']->getValue($subject);
      if ($optionId) {
        $optionObj = Engine_Api::_()->fields()
                ->getFieldsOptions($subject)
                ->getRowMatching('option_id', $optionId->value);
        if ($optionObj) {
          $memberType = $optionObj->label;
        }
      }
    }
    return $memberType;
  }

  public function getBlock($params = array()) {

    $table = Engine_Api::_()->getDbtable('block', 'user');
    $select = $table->select()
            ->where('user_id = ?', $params['user_id'])
            ->where('blocked_user_id = ?', $params['blocked_user_id'])
            ->limit(1);
    $row = $table->fetchRow($select);
  }

  public function hasCheckMessage($user) {

    // Not logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity() || $viewer->getGuid(false) === $user->getGuid(false)) {
      return false;
    }

    // Get setting?
    $permission = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'messages', 'create');
    if (Authorization_Api_Core::LEVEL_DISALLOW === $permission) {
      return false;
    }
    $messageAuth = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'messages', 'auth');
    if ($messageAuth == 'none') {
      return false;
    } else if ($messageAuth == 'friends') {
      // Get data
      $direction = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.direction', 1);
      if (!$direction) {
        //one way
        $friendship_status = $viewer->membership()->getRow($user);
      }
      else
        $friendship_status = $user->membership()->getRow($viewer);

      if (!$friendship_status || $friendship_status->active == 0) {
        return false;
      }
    }
    return true;
  }

}
