<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Plugin_Menus {

  public function canCreateGroups() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_SesgroupMainManage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_SesgroupMainCreate($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      //return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', null, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_SesgroupMainBrowselocations($row) {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.enable.location', 1)) {
      return false;
    }
    return true;
  }

  public function canClaimSesgroups() {
  
    // Must be able to view sesgroups
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) 
      return false;

    if(Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'auth_claim')) 
      return true;
    
    return false;
  }

  public function onMenuInitialize_SesgroupProfileDashboard() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sesgroup_group') {
      throw new Sesgroup_Model_Exception('Whoops, not a group!');
    }
    if (!$viewer->getIdentity()) {
      return false;
    }
    $allowPromotion = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_promotions', 'edit');
    $manage_dashboard = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'edit');
    $manage_apps = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_apps', 'edit');
    $manage_styling = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_styling', 'edit');
    $manage_insight = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_insight', 'edit');
    $allowDashboard = $allowPromotion || $manage_dashboard || $manage_styling || $manage_insight;

    if (!$allowDashboard) {
      return false;
    }

    $action = "edit";
    if (!$manage_dashboard) {
      if ($allowPromotion) {
        $action = "contact";
      } else if ($manage_apps) {
        $action = "manage-groupapps";
      } else if ($manage_styling) {
        $action = "style";
      } else if ($manage_insight) {
        $action = "insights";
      }
    }
    return array(
        'label' => 'Dashboard',
        'class' => 'sesbasic_icon_edit',
        'route' => 'sesgroup_dashboard',
        'params' => array(
            'controller' => 'dashboard',
            'action' => $action,
            'group_id' => $subject->custom_url
        )
    );
  }

  public function onMenuInitialize_SesgroupProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $group = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.report', 1))
    return false;

    if($review->owner_id == $viewer->getIdentity())
	  return false;

    if (!$viewer->getIdentity())
    return false;

    return array(
        'label' => 'Report',
        'class' => 'smoothbox sesbasic_icon_report',
        'route' => 'default',
        'params' => array(
            'module' => 'core',
            'controller' => 'report',
            'action' => 'create',
            'subject' => $group->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesgroupProfileUnlike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sesgroup_group') {
      throw new Sesgroup_Model_Exception('This group does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('group_id !=?', $subject->getIdentity())
            ->where('group_id IN (SELECT group_id FROM engine4_sesgroup_likegroups WHERE like_group_id = ' . $subject->group_id . ")");
    $count = count($table->fetchAll($selelct));
    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Unlike As Your Group',
        'class' => 'sessmoothbox sesbasic_icon_unlike',
        'route' => 'default',
        'params' => array(
            'module' => 'sesgroup',
            'controller' => 'index',
            'action' => 'unlike-as-group',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesgroupProfileLike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sesgroup_group') {
      throw new Sesgroup_Model_Exception('This group does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('group_id !=?', $subject->getIdentity())
            ->where('group_id NOT IN (SELECT group_id FROM engine4_sesgroup_likegroups WHERE like_group_id = ' . $subject->group_id . ")");
    $count = count($table->fetchAll($selelct));

    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Like As Your Group',
        'class' => 'sessmoothbox sesbasic_icon_like',
        'route' => 'default',
        'params' => array(
            'module' => 'sesgroup',
            'controller' => 'index',
            'action' => 'like-as-group',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesgroupProfileAddtoshortcut() {

    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesshortcut')) {

      $viewer = Engine_Api::_()->user()->getViewer();
      if (!$viewer->getIdentity())
        return false;

      $subject = Engine_Api::_()->core()->getSubject();
      if ($subject->getType() !== 'sesgroup_group') {
        throw new Sesgroup_Model_Exception('This group does not exist.');
      }

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1))
        return false;

      $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $subject->getType(), 'resource_id' => $subject->getIdentity()));
      if (empty($isShortcut)) {
        return array(
            'label' => 'Add to Shortcuts',
            'class' => 'smoothbox sesgroup_icon_addbookmark',
            'route' => 'default',
            'params' => array(
                'module' => 'sesshortcut',
                'controller' => 'index',
                'action' => 'addshortcuts',
                'resource_type' => $subject->getType(),
                'resource_id' => $subject->getIdentity(),
                'format' => 'smoothbox',
            ),
        );
      } else {
        return array(
            'label' => 'Remove From Shortcuts',
            'class' => 'smoothbox sesgroup_icon_removebookmark',
            'route' => 'default',
            'params' => array(
                'module' => 'sesshortcut',
                'controller' => 'index',
                'action' => 'removeshortcuts',
                'resource_type' => $subject->getType(),
                'resource_id' => $subject->getIdentity(),
                'shortcut_id' => $isShortcut,
                'format' => 'smoothbox',
            ),
        );
      }
    } else {
      return false;
    }
  }

  public function onMenuInitialize_SesgroupProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sesgroup_group') {
      throw new Sesgroup_Model_Exception('This group does not exist.');
    }
    if (!$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.share', 1)) {
      return false;
    }
    return array(
        'label' => 'Share This Group',
        'class' => 'smoothbox sesbasic_icon_share',
        'route' => 'default',
        'params' => array(
            'module' => 'activity',
            'controller' => 'index',
            'action' => 'share',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesgroupProfileDelete() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sesgroup_group') {
      throw new Sesgroup_Model_Exception('This group does not exist.');
    } else if (!$subject->authorization()->isAllowed($viewer, 'delete') && !Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'delete')) {
      return false;
    }
    return array(
        'label' => 'Delete Group',
        'class' => 'smoothbox sesbasic_icon_delete',
        'route' => 'sesgroup_general',
        'params' => array(
            'action' => 'delete',
            'group_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_SesgroupProfileSubgroup() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    $subject = Engine_Api::_()->core()->getSubject();
    if ((!Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroup_group', 'auth_subgroup') || ($subject->parent_id)) || !Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_group')) {
      return false;
    }
    return array(
        'label' => 'Create New Associated Sub Group',
        'class' => 'sesbasic_icon_edit',
        'route' => 'sesgroup_general',
        'params' => array(
            'action' => 'create',
            'parent_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_SesgroupProfileMember() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sesgroup_group') {
      throw new Sesgroup_Model_Exception('Whoops, not a group!');
    }
    if (!$viewer->getIdentity() || !(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.join', 1)) || !($subject->can_join) || !(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroup_group', 'group_can_join'))) {
      return false;
    }
    $row = $subject->membership()->getRow($viewer);
    // Not yet associated at all
    if (null === $row) {
      if ($subject->membership()->isResourceApprovalRequired()) {
        return array(
            'label' => 'Request Membership',
            'class' => 'smoothbox sesgroup_icon_group_join',
            'route' => 'sesgroup_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'request',
                'group_id' => $subject->getIdentity(),
            ),
        );
      } else {
        return array(
            'label' => 'Join Group',
            'class' => 'smoothbox sesgroup_icon_group_join',
            'route' => 'sesgroup_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'join',
                'group_id' => $subject->getIdentity()
            ),
        );
      }
    }
    // Full member
    // @todo consider owner
    else if ($row->active) {
      if (!$subject->isOwner($viewer)) {
        return array(
            'label' => 'Leave Group',
            'class' => 'smoothbox sesgroup_icon_group_leave',
            'route' => 'sesgroup_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'leave',
                'group_id' => $subject->getIdentity()
            ),
        );
      } else {
        return false;
      }
    } else if (!$row->resource_approved && $row->user_approved) {
      return array(
          'label' => 'Cancel Membership Request',
          'class' => 'smoothbox sesgroup_icon_group_cancel',
          'route' => 'sesgroup_extended',
          'params' => array(
              'controller' => 'member',
              'action' => 'cancel',
              'group_id' => $subject->getIdentity()
          ),
      );
    } else if (!$row->user_approved && $row->resource_approved) {
      return array(
          array(
              'label' => 'Accept Membership Request',
              'class' => 'smoothbox sesgroup_icon_group_accept',
              'route' => 'sesgroup_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'accept',
                  'group_id' => $subject->getIdentity()
              ),
          ), array(
              'label' => 'Ignore Membership Request',
              'class' => 'smoothbox sesgroup_icon_group_reject',
              'route' => 'sesgroup_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'reject',
                  'group_id' => $subject->getIdentity()
              ),
          )
      );
    } else {
      throw new Sesgroup_Model_Exception('An error has occurred.');
    }
    return false;
  }

  public function onMenuInitialize_SesgroupProfileInvite() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sesgroup_group') {
      throw new Sesgroup_Model_Exception('This group does not exist.');
    }
    if (!$viewer->getIdentity() || !$subject->can_invite) {
      return false;
    }
    return array(
        'label' => 'Add Members',
        'class' => 'sessmoothbox',
        'route' => 'sesgroup_extended',
        'params' => array(
            'module' => 'sesgroup',
            'controller' => 'member',
            'action' => 'invite',
            'group_id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }
  
  public function onMenuInitialize_SesgroupMainManagePackage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesgrouppackage') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.enable.package', 0)) {
      return false;
    }
    return true;
  }

}
