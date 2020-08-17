<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Plugin_Menus {

  public function canCreatePages() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_SespageMainManage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_SespageMainCreate($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      //return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('sespage_page', null, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_SespageMainBrowselocations($row) {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.enable.location', 1)) {
      return false;
    }
    return true;
  }

  public function canClaimSespages() {
  
    // Must be able to view sespages
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) 
      return false;

    if(Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'auth_claim')) 
      return true;
    
    return false;
  }

  public function onMenuInitialize_SespageProfileDashboard() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sespage_page') {
      throw new Sespage_Model_Exception('Whoops, not a page!');
    }
    if (!$viewer->getIdentity()) {
      return false;
    }
    $allowPromotion = Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_promotions', 'edit');
    $manage_dashboard = Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'edit');
    $manage_apps = Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_apps', 'edit');
    $manage_styling = Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_styling', 'edit');
    $manage_insight = Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_insight', 'edit');
    $allowDashboard = $allowPromotion || $manage_dashboard || $manage_styling || $manage_insight;

    if (!$allowDashboard) {
      return false;
    }

    $action = "edit";
    if (!$manage_dashboard) {
      if ($allowPromotion) {
        $action = "contact";
      } else if ($manage_apps) {
        $action = "manage-pageapps";
      } else if ($manage_styling) {
        $action = "style";
      } else if ($manage_insight) {
        $action = "insights";
      }
    }
    return array(
        'label' => 'Dashboard',
        'class' => 'sesbasic_icon_edit',
        'route' => 'sespage_dashboard',
        'params' => array(
            'controller' => 'dashboard',
            'action' => $action,
            'page_id' => $subject->custom_url
        )
    );
  }

  public function onMenuInitialize_SespageProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $sespage = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.report', 1))
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
            'subject' => $sespage->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SespageProfileUnlike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sespage_page') {
      throw new Sespage_Model_Exception('This page does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('pageroles', 'sespage');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('page_id !=?', $subject->getIdentity())
            ->where('page_id IN (SELECT page_id FROM engine4_sespage_likepages WHERE like_page_id = ' . $subject->page_id . ")");
    $count = count($table->fetchAll($selelct));
    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Unlike As Your Page',
        'class' => 'sessmoothbox sesbasic_icon_unlike',
        'route' => 'default',
        'params' => array(
            'module' => 'sespage',
            'controller' => 'index',
            'action' => 'unlike-as-page',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SespageProfileLike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sespage_page') {
      throw new Sespage_Model_Exception('This page does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('pageroles', 'sespage');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('page_id !=?', $subject->getIdentity())
            ->where('page_id NOT IN (SELECT page_id FROM engine4_sespage_likepages WHERE like_page_id = ' . $subject->page_id . ")");
    $count = count($table->fetchAll($selelct));

    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Like As Your Page',
        'class' => 'sessmoothbox sesbasic_icon_like',
        'route' => 'default',
        'params' => array(
            'module' => 'sespage',
            'controller' => 'index',
            'action' => 'like-as-page',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SespageProfileAddtoshortcut() {

    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesshortcut')) {

      $viewer = Engine_Api::_()->user()->getViewer();
      if (!$viewer->getIdentity())
        return false;

      $subject = Engine_Api::_()->core()->getSubject();
      if ($subject->getType() !== 'sespage_page') {
        throw new Sespage_Model_Exception('This page does not exist.');
      }

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1))
        return false;

      $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $subject->getType(), 'resource_id' => $subject->getIdentity()));
      if (empty($isShortcut)) {
        return array(
            'label' => 'Add to Shortcuts',
            'class' => 'smoothbox sespage_icon_addbookmark',
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
            'class' => 'smoothbox sespage_icon_removebookmark',
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

  public function onMenuInitialize_SespageProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sespage_page') {
      throw new Sespage_Model_Exception('This page does not exist.');
    }
    if (!$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.share', 1)) {
      return false;
    }
    return array(
        'label' => 'Share This Page',
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

  public function onMenuInitialize_SespageProfileDelete() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sespage_page') {
      throw new Sespage_Model_Exception('This page does not exist.');
    } else if (!$subject->authorization()->isAllowed($viewer, 'delete') && !Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'delete')) {
      return false;
    }
    return array(
        'label' => 'Delete Page',
        'class' => 'smoothbox sesbasic_icon_delete',
        'route' => 'sespage_general',
        'params' => array(
            'action' => 'delete',
            'page_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_SespageProfileSubpage() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    $subject = Engine_Api::_()->core()->getSubject();
    if ((!Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sespage_page', 'auth_subpage') || ($subject->parent_id)) || !Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_page')) {
      return false;
    }
    return array(
        'label' => 'Create New Associated Sub Page',
        'class' => 'sesbasic_icon_edit',
        'route' => 'sespage_general',
        'params' => array(
            'action' => 'create',
            'parent_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_SespageProfileMember() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sespage_page') {
      throw new Sespage_Model_Exception('Whoops, not a page!');
    }
    if (!$viewer->getIdentity() || !(Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.join', 1)) || !($subject->can_join) || !(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sespage_page', 'page_can_join'))) {
      return false;
    }
    $row = $subject->membership()->getRow($viewer);
    // Not yet associated at all
    if (null === $row) {
      if ($subject->membership()->isResourceApprovalRequired()) {
        return array(
            'label' => 'Request Membership',
            'class' => 'smoothbox sespage_icon_page_join',
            'route' => 'sespage_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'request',
                'page_id' => $subject->getIdentity(),
            ),
        );
      } else {
        return array(
            'label' => 'Join Page',
            'class' => 'smoothbox sespage_icon_page_join',
            'route' => 'sespage_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'join',
                'page_id' => $subject->getIdentity()
            ),
        );
      }
    }
    // Full member
    // @todo consider owner
    else if ($row->active) {
      if (!$subject->isOwner($viewer)) {
        return array(
            'label' => 'Leave Page',
            'class' => 'smoothbox sespage_icon_page_leave',
            'route' => 'sespage_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'leave',
                'page_id' => $subject->getIdentity()
            ),
        );
      } else {
        return false;
      }
    } else if (!$row->resource_approved && $row->user_approved) {
      return array(
          'label' => 'Cancel Membership Request',
          'class' => 'smoothbox sespage_icon_page_cancel',
          'route' => 'sespage_extended',
          'params' => array(
              'controller' => 'member',
              'action' => 'cancel',
              'page_id' => $subject->getIdentity()
          ),
      );
    } else if (!$row->user_approved && $row->resource_approved) {
      return array(
          array(
              'label' => 'Accept Membership Request',
              'class' => 'smoothbox sespage_icon_page_accept',
              'route' => 'sespage_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'accept',
                  'page_id' => $subject->getIdentity()
              ),
          ), array(
              'label' => 'Ignore Membership Request',
              'class' => 'smoothbox sespage_icon_page_reject',
              'route' => 'sespage_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'reject',
                  'page_id' => $subject->getIdentity()
              ),
          )
      );
    } else {
      throw new Sespage_Model_Exception('An error has occurred.');
    }
    return false;
  }

  public function onMenuInitialize_SespageProfileInvite() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'sespage_page') {
      throw new Sespage_Model_Exception('This page does not exist.');
    }
    if (!$viewer->getIdentity() || !$subject->can_invite) {
      return false;
    }
    return array(
        'label' => 'Invite Members',
        'class' => 'sessmoothbox',
        'route' => 'sespage_extended',
        'params' => array(
            'module' => 'sespage',
            'controller' => 'member',
            'action' => 'invite',
            'page_id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }
  
  public function onMenuInitialize_SespageMainManagePackage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagepackage') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 0)) {
      return false;
    }
    return true;
  }

}
