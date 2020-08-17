<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Plugin_Menus {

  public function canCreateBusinesses() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_SesbusinessMainManage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_SesbusinessMainCreate($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      //return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('businesses', null, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_SesbusinessMainBrowselocations($row) {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.location', 1)) {
      return false;
    }
    return true;
  }

  public function canClaimSesbusinesses() {

    // Must be able to view sesbusinesses
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
      return false;

    if(Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'auth_claim'))
      return true;

    return false;
  }

  public function onMenuInitialize_SesbusinessProfileDashboard() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'businesses') {
      throw new Sesbusiness_Model_Exception('Whoops, not a business!');
    }
    if (!$viewer->getIdentity()) {
      return false;
    }
    $allowPromotion = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_promotions', 'edit');
    $manage_dashboard = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'edit');
    $manage_apps = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_apps', 'edit');
    $manage_styling = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_styling', 'edit');
    $manage_insight = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_insight', 'edit');
    $allowDashboard = $allowPromotion || $manage_dashboard || $manage_styling || $manage_insight;

    if (!$allowDashboard) {
      return false;
    }

    $action = "edit";
    if (!$manage_dashboard) {
      if ($allowPromotion) {
        $action = "contact";
      } else if ($manage_apps) {
        $action = "manage-businessapps";
      } else if ($manage_styling) {
        $action = "style";
      } else if ($manage_insight) {
        $action = "insights";
      }
    }
    return array(
        'label' => 'Dashboard',
        'class' => 'sesbasic_icon_edit',
        'route' => 'sesbusiness_dashboard',
        'params' => array(
            'controller' => 'dashboard',
            'action' => $action,
            'business_id' => $subject->custom_url
        )
    );
  }

  public function onMenuInitialize_SesbusinessProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $business = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.report', 1))
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
            'subject' => $business->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesbusinessProfileUnlike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'businesses') {
      throw new Sesbusiness_Model_Exception('This business does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('business_id !=?', $subject->getIdentity())
            ->where('business_id IN (SELECT business_id FROM engine4_sesbusiness_likebusinesses WHERE like_business_id = ' . $subject->business_id . ")");
    $count = count($table->fetchAll($selelct));
    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Unlike As Your Business',
        'class' => 'sessmoothbox sesbasic_icon_unlike',
        'route' => 'default',
        'params' => array(
            'module' => 'sesbusiness',
            'controller' => 'index',
            'action' => 'unlike-as-business',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesbusinessProfileLike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'businesses') {
      throw new Sesbusiness_Model_Exception('This business does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('business_id !=?', $subject->getIdentity())
            ->where('business_id NOT IN (SELECT business_id FROM engine4_sesbusiness_likebusinesses WHERE like_business_id = ' . $subject->business_id . ")");
    $count = count($table->fetchAll($selelct));

    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Like As Your Business',
        'class' => 'sessmoothbox sesbasic_icon_like',
        'route' => 'default',
        'params' => array(
            'module' => 'sesbusiness',
            'controller' => 'index',
            'action' => 'like-as-business',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesbusinessProfileAddtoshortcut() {

    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesshortcut')) {

      $viewer = Engine_Api::_()->user()->getViewer();
      if (!$viewer->getIdentity())
        return false;

      $subject = Engine_Api::_()->core()->getSubject();
      if ($subject->getType() !== 'businesses') {
        throw new Sesbusiness_Model_Exception('This business does not exist.');
      }

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1))
        return false;

      $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $subject->getType(), 'resource_id' => $subject->getIdentity()));
      if (empty($isShortcut)) {
        return array(
            'label' => 'Add to Shortcuts',
            'class' => 'smoothbox sesbusiness_icon_addbookmark',
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
            'class' => 'smoothbox sesbusiness_icon_removebookmark',
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

  public function onMenuInitialize_SesbusinessProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'businesses') {
      throw new Sesbusiness_Model_Exception('This business does not exist.');
    }
    if (!$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.share', 1)) {
      return false;
    }
    return array(
        'label' => 'Share This Business',
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

  public function onMenuInitialize_SesbusinessProfileDelete() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'businesses') {
      throw new Sesbusiness_Model_Exception('This business does not exist.');
    } else if (!$subject->authorization()->isAllowed($viewer, 'delete') && !Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'delete')) {
      return false;
    }
    return array(
        'label' => 'Delete Business',
        'class' => 'smoothbox sesbasic_icon_delete',
        'route' => 'sesbusiness_general',
        'params' => array(
            'action' => 'delete',
            'business_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_SesbusinessProfileSubbusiness() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    $subject = Engine_Api::_()->core()->getSubject();
    if ((!Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'businesses', 'auth_subbusiness') || ($subject->parent_id)) || !Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_business')) {
      return false;
    }
    return array(
        'label' => 'Create New Associated Sub Business',
        'class' => 'sesbasic_icon_edit',
        'route' => 'sesbusiness_general',
        'params' => array(
            'action' => 'create',
            'parent_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_SesbusinessProfileMember() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'businesses') {
      throw new Sesbusiness_Model_Exception('Whoops, not a business!');
    }
    if (!$viewer->getIdentity() || !(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.join', 1)) || !($subject->can_join) || !(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'businesses', 'bs_can_join'))) {
      return false;
    }
    $row = $subject->membership()->getRow($viewer);
    // Not yet associated at all
    if (null === $row) {
      if ($subject->membership()->isResourceApprovalRequired()) {
        return array(
            'label' => 'Request Membership',
            'class' => 'smoothbox sesbusiness_icon_business_join',
            'route' => 'sesbusiness_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'request',
                'business_id' => $subject->getIdentity(),
            ),
        );
      } else {
        return array(
            'label' => 'Join Business',
            'class' => 'smoothbox sesbusiness_icon_business_join',
            'route' => 'sesbusiness_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'join',
                'business_id' => $subject->getIdentity()
            ),
        );
      }
    }
    // Full member
    // @todo consider owner
    else if ($row->active) {
      if (!$subject->isOwner($viewer)) {
        return array(
            'label' => 'Leave Business',
            'class' => 'smoothbox sesbusiness_icon_business_leave',
            'route' => 'sesbusiness_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'leave',
                'business_id' => $subject->getIdentity()
            ),
        );
      } else {
        return false;
      }
    } else if (!$row->resource_approved && $row->user_approved) {
      return array(
          'label' => 'Cancel Membership Request',
          'class' => 'smoothbox sesbusiness_icon_business_cancel',
          'route' => 'sesbusiness_extended',
          'params' => array(
              'controller' => 'member',
              'action' => 'cancel',
              'business_id' => $subject->getIdentity()
          ),
      );
    } else if (!$row->user_approved && $row->resource_approved) {
      return array(
          array(
              'label' => 'Accept Membership Request',
              'class' => 'smoothbox sesbusiness_icon_business_accept',
              'route' => 'sesbusiness_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'accept',
                  'business_id' => $subject->getIdentity()
              ),
          ), array(
              'label' => 'Ignore Membership Request',
              'class' => 'smoothbox sesbusiness_icon_business_reject',
              'route' => 'sesbusiness_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'reject',
                  'business_id' => $subject->getIdentity()
              ),
          )
      );
    } else {
      throw new Sesbusiness_Model_Exception('An error has occurred.');
    }
    return false;
  }

  public function onMenuInitialize_SesbusinessProfileInvite() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'businesses') {
      throw new Sesbusiness_Model_Exception('This business does not exist.');
    }
    if (!$viewer->getIdentity() || !$subject->can_invite) {
      return false;
    }
    return array(
        'label' => 'Invite Members',
        'class' => 'sessmoothbox',
        'route' => 'sesbusiness_extended',
        'params' => array(
            'module' => 'sesbusiness',
            'controller' => 'member',
            'action' => 'invite',
            'business_id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesbusinessMainManagePackage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesbusinesspackage') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspackage.enable.package', 0)) {
      return false;
    }
    return true;
  }

}
