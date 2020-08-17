<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Menus.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Plugin_Menus {

  public function canCreateClassrooms() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('classroom', $viewer, 'create')) {
      return false;
    }
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.open.smoothbox', 0)) {
      return array(
          'class' => 'sessmoothbox',
          'route' => 'eclassroom_general',
          'action' => 'create',
          'params' => array(
              'format' => 'sessmoothbox',
          ),
      );
    } else 
      return true;
  }

//   public function onMenuInitialize_EclassroomMainManage($row) {
//     $viewer = Engine_Api::_()->user()->getViewer();
//     if (!$viewer->getIdentity()) {
//       return false;
//     }
//
//     return true;
//   }
//   public function onMenuInitialize_EclassroomMainAccount($row) {
//     $viewer = Engine_Api::_()->user()->getViewer();
//     if (!$viewer->getIdentity()) {
//       return false;
//     }
//
//     return true;
//   }
//
//   public function onMenuInitialize_EclassroomMainCreate($row) {
//     $viewer = Engine_Api::_()->user()->getViewer();
//     if (!$viewer->getIdentity()) {
//       //return false;
//     }
//     if (!Engine_Api::_()->authorization()->isAllowed('classrooms', null, 'create')) {
//       return false;
//     }
//     return true;
//   }
//
//   public function onMenuInitialize_EclassroomMainBrowselocations($row) {
//     if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1)) {
//       return false;
//     }
//     return true;
//   }

  public function canClaimEclassroom() { 
    // Must be able to view eclassroom
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
      return false;
    if(Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'auth_claim'))
      return true;
    return false;
  }

  public function onMenuInitialize_EclassroomProfileDashboard() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'classroom') {
      throw new Eclassroom_Model_Exception('Whoops, not a classroom!');
    }
    if (!$viewer->getIdentity()) {
      return false;
    }
    $allowPromotion = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_promotions', 'edit');
    $manage_dashboard = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'edit');
    $manage_apps = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_apps', 'edit');
    $manage_styling = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_styling', 'edit');
    $manage_insight = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_insight', 'edit');
    $allowDashboard = $allowPromotion || $manage_dashboard || $manage_styling || $manage_insight;

    if (!$allowDashboard) {
      return false;
    }

    $action = "edit";
    if (!$manage_dashboard) {
      if ($allowPromotion) {
        $action = "contact";
      } else if ($manage_apps) {
        $action = "manage-classroomapps";
      } else if ($manage_styling) {
        $action = "style";
      } else if ($manage_insight) {
        $action = "insights";
      }
    }
    return array(
        'label' => 'Dashboard',
        'class' => 'sesbasic_icon_edit',
        'route' => 'eclassroom_dashboard',
        'params' => array(
            'controller' => 'dashboard',
            'action' => $action,
            'classroom_id' => $subject->custom_url
        )
    );
  }
  public function onMenuInitialize_EclassroomProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $classroom = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.report', 1))
    return false;

    if($classroom->owner_id == $viewer->getIdentity())
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
            'subject' => $classroom->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_EclassroomProfileUnlike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'classroom') {
      throw new Eclassroom_Model_Exception('This classroom does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('classroom_id !=?', $subject->getIdentity())
            ->where('classroom_id IN (SELECT classroom_id FROM engine4_eclassroom_likeclassrooms WHERE like_classroom_id = ' . $subject->classroom_id . ")");
    $count = count($table->fetchAll($selelct));
    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Unlike As Your Classroom',
        'class' => 'sessmoothbox sesbasic_icon_unlike',
        'route' => 'default',
        'params' => array(
            'module' => 'eclassroom',
            'controller' => 'index',
            'action' => 'unlike-as-classroom',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_EclassroomProfileLike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'classroom') {
      throw new Eclassroom_Model_Exception('This classroom does not exist.');
    }
    $table = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('classroom_id !=?', $subject->getIdentity())
            ->where('classroom_id NOT IN (SELECT classroom_id FROM engine4_eclassroom_likeclassrooms WHERE like_classroom_id = ' . $subject->classroom_id . ")");
    $count = count($table->fetchAll($selelct));
    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Like As Your Classroom',
        'class' => 'sessmoothbox sesbasic_icon_like',
        'route' => 'default',
        'params' => array(
            'module' => 'eclassroom',
            'controller' => 'index',
            'action' => 'like-as-classroom',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_EclassroomProfileAddtoshortcut() {

    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesshortcut')) {

      $viewer = Engine_Api::_()->user()->getViewer();
      if (!$viewer->getIdentity())
        return false;

      $subject = Engine_Api::_()->core()->getSubject();
      if ($subject->getType() !== 'classrooms') {
        throw new Eclassroom_Model_Exception('This classroom does not exist.');
      }

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1))
        return false;

      $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $subject->getType(), 'resource_id' => $subject->getIdentity()));
      if (empty($isShortcut)) {
        return array(
            'label' => 'Add to Shortcuts',
            'class' => 'smoothbox eclassroom_icon_addbookmark',
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
            'class' => 'smoothbox eclassroom_icon_removebookmark',
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

  public function onMenuInitialize_EclassroomProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'classrooms') {
      throw new Eclassroom_Model_Exception('This classroom does not exist.');
    }
    if (!$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.share', 1)) {
      return false;
    }
    return array(
        'label' => 'Share This Classroom',
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

  public function onMenuInitialize_EclassroomProfileDelete() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'classroom') {
      throw new Eclassroom_Model_Exception('This classroom does not exist.');
    } else if (!$subject->authorization()->isAllowed($viewer, 'delete') && !Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'delete')) {
      return false;
    }
    return array(
        'label' => 'Delete Classroom',
        'class' => 'smoothbox sesbasic_icon_delete',
        'route' => 'eclassroom_general',
        'params' => array(
            'action' => 'delete',
            'classroom_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_EclassroomProfileSubclassroom() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    $subject = Engine_Api::_()->core()->getSubject();
    if ((!Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'eclassroom', 'auth_subclassroom') || ($subject->parent_id)) || !Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_classroom')) {
      return false;
    }
    return array(
        'label' => 'Create New Associated Sub Classroom',
        'class' => 'sesbasic_icon_edit',
        'route' => 'eclassroom_general',
        'params' => array(
            'action' => 'create',
            'parent_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_EclassroomProfileMember() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'classroom') {
      throw new Eclassroom_Model_Exception('Whoops, not a classroom!');
    }
    if (!$viewer->getIdentity() || !(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.join', 1)) || !($subject->can_join) || !(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'eclassroom', 'bs_can_join'))) {
      return false;
    }
    $row = $subject->membership()->getRow($viewer);
    // Not yet associated at all
    if (null === $row) {
      if ($subject->membership()->isResourceApprovalRequired()) {
        return array(
            'label' => 'Request Membership',
            'class' => 'smoothbox eclassroom_icon_classroom_join',
            'route' => 'eclassroom_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'request',
                'classroom_id' => $subject->getIdentity(),
            ),
        );
      } else {
        return array(
            'label' => 'Join Classroom',
            'class' => 'smoothbox eclassroom_icon_classroom_join',
            'route' => 'eclassroom_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'join',
                'classroom_id' => $subject->getIdentity()
            ),
        );
      }
    }
    // Full member
    // @todo consider owner
    else if ($row->active) {
      if (!$subject->isOwner($viewer)) {
        return array(
            'label' => 'Leave Classroom',
            'class' => 'smoothbox eclassroom_icon_classroom_leave',
            'route' => 'eclassroom_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'leave',
                'classroom_id' => $subject->getIdentity()
            ),
        );
      } else {
        return false;
      }
    } else if (!$row->resource_approved && $row->user_approved) {
      return array(
          'label' => 'Cancel Membership Request',
          'class' => 'smoothbox eclassroom_icon_classroom_cancel',
          'route' => 'eclassroom_extended',
          'params' => array(
              'controller' => 'member',
              'action' => 'cancel',
              'classroom_id' => $subject->getIdentity()
          ),
      );
    } else if (!$row->user_approved && $row->resource_approved) {
      return array(
          array(
              'label' => 'Accept Membership Request',
              'class' => 'smoothbox eclassroom_icon_classroom_accept',
              'route' => 'eclassroom_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'accept',
                  'classroom_id' => $subject->getIdentity()
              ),
          ), array(
              'label' => 'Ignore Membership Request',
              'class' => 'smoothbox eclassroom_icon_classroom_reject',
              'route' => 'eclassroom_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'reject',
                  'classroom_id' => $subject->getIdentity()
              ),
          )
      );
    } else {
      throw new Eclassroom_Model_Exception('An error has occurred.');
    }
    return false;
  }

  public function onMenuInitialize_EclassroomProfileInvite() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'classroom') {
      throw new Eclassroom_Model_Exception('This classroom does not exist.');
    }
    if (!$viewer->getIdentity() || !$subject->can_invite) {
      return false;
    }
    return array(
        'label' => 'Invite Members',
        'class' => 'sessmoothbox',
        'route' => 'eclassroom_extended',
        'params' => array(
            'module' => 'eclassroom',
            'controller' => 'member',
            'action' => 'invite',
            'classroom_id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

//   public function onMenuInitialize_EclassroomMainManagePackage($row) {
//     $viewer = Engine_Api::_()->user()->getViewer();
//     if (!$viewer->getIdentity()) {
//       return false;
//     }
//     if (!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('eclassroompackage') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroompackage.enable.package', 0)) {
//       return false;
//     }
//     return true;
//   }
//
//
//
//
    public function onMenuInitialize_EclassroomReviewProfileEdit() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.review', 0)))
            return false;
        if (!$viewer->getIdentity())
            return false;
        if (!Engine_Api::_()->authorization()->isAllowed('eclass_review',$viewer, 'edit'))
            return false;
        return array(
            'label' => $view->translate('Edit Review'),
            'class' => 'smoothbox sesbasic_icon_edit',
            'route' => 'eclassroomreview_view',
            'params' => array(
                'action' => 'edit-review',
                'review_id' => $review->getIdentity(),
                'slug' => $review->getSlug(),
            )
        );
    }
    public function onMenuInitialize_EclassroomReviewProfileReport() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.show.report', 1)))
            return false;

        if (!$viewer->getIdentity())
            return false;

        return array(
            'label' => $view->translate('Report'),
            'class' => 'smoothbox sesbasic_icon_report',
            'route' => 'default',
            'params' => array(
                'module' => 'core',
                'controller' => 'report',
                'action' => 'create',
                'subject' => $review->getGuid(),
                'format' => 'smoothbox',
            ),
        );
    }
    public function onMenuInitialize_EclassroomReviewProfileShare() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.share', 1)))
            return false;

        if (!$viewer->getIdentity())
            return false;

        if (!$viewer->getIdentity())
            return false;

        return array(
            'label' => $view->translate('Share'),
            'class' => 'smoothbox sesbasic_icon_share',
            'route' => 'default',
            'params' => array(
                'module' => 'activity',
                'controller' => 'index',
                'action' => 'share',
                'type' => $review->getType(),
                'id' => $review->getIdentity(),
                'format' => 'smoothbox',
            ),
        );
    }
    public function onMenuInitialize_EclassroomReviewProfileDelete() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!$viewer->getIdentity())
            return false;
        if (!Engine_Api::_()->authorization()->isAllowed('eclass_review',$viewer, 'delete'))
            return false;
        return array(
            'label' => $view->translate('Delete Review'),
            'class' => 'smoothbox sesbasic_icon_delete',
            'route' => 'eclassroomreview_view',
            'params' => array(
                'action' => 'delete',
                'review_id' => $review->getIdentity(),
                'format' => 'smoothbox',
            ),
        );
    }

}
