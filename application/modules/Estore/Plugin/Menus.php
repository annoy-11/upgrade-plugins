<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Plugin_Menus {

  public function canCreateStores() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_EstoreMainManage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }

    return true;
  }
  public function onMenuInitialize_EstoreMainAccount($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_EstoreMainCreate($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      //return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('stores', null, 'create')) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_EstoreMainBrowselocations($row) {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1))
      return false;

    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1))
      return false;
    return true;
  }

  public function canClaimEstores() {

    // Must be able to view estores
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
      return false;

    if(Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'auth_claim'))
      return true;

    return false;
  }

  public function onMenuInitialize_EstoreProfileDashboard() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'stores') {
      throw new Estore_Model_Exception('Whoops, not a store!');
    }
    if (!$viewer->getIdentity()) {
      return false;
    }
    $allowPromotion = Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_promotions', 'edit');
    $manage_dashboard = Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'edit');
    $manage_apps = Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_apps', 'edit');
    $manage_styling = Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_styling', 'edit');
    $manage_insight = Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_insight', 'edit');
    $allowDashboard = $allowPromotion || $manage_dashboard || $manage_styling || $manage_insight;

    if (!$allowDashboard) {
      return false;
    }

    $action = "edit";
    if (!$manage_dashboard) {
      if ($allowPromotion) {
        $action = "contact";
      } else if ($manage_apps) {
        $action = "manage-storeapps";
      } else if ($manage_styling) {
        $action = "style";
      } else if ($manage_insight) {
        $action = "insights";
      }
    }
    return array(
        'label' => 'Dashboard',
        'class' => 'sesbasic_icon_edit',
        'route' => 'estore_dashboard',
        'params' => array(
            'controller' => 'dashboard',
            'action' => $action,
            'store_id' => $subject->custom_url
        )
    );
  }

  public function onMenuInitialize_EstoreProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $store = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.report', 1))
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
            'subject' => $store->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_EstoreProfileUnlike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'stores') {
      throw new Estore_Model_Exception('This store does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('store_id !=?', $subject->getIdentity())
            ->where('store_id IN (SELECT store_id FROM engine4_estore_likestores WHERE like_store_id = ' . $subject->store_id . ")");
    $count = count($table->fetchAll($selelct));
    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Unlike As Your Store',
        'class' => 'sessmoothbox sesbasic_icon_unlike',
        'route' => 'default',
        'params' => array(
            'module' => 'estore',
            'controller' => 'index',
            'action' => 'unlike-as-store',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_EstoreProfileLike() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'stores') {
      throw new Estore_Model_Exception('This store does not exist.');
    }

    $table = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('store_id !=?', $subject->getIdentity())
            ->where('store_id NOT IN (SELECT store_id FROM engine4_estore_likestores WHERE like_store_id = ' . $subject->store_id . ")");
    $count = count($table->fetchAll($selelct));

    if (!$viewer->getIdentity() || $count < 2) {
      return false;
    }
    return array(
        'label' => 'Like As Your Store',
        'class' => 'sessmoothbox sesbasic_icon_like',
        'route' => 'default',
        'params' => array(
            'module' => 'estore',
            'controller' => 'index',
            'action' => 'like-as-store',
            'type' => $subject->getType(),
            'id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_EstoreProfileAddtoshortcut() {

    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesshortcut')) {

      $viewer = Engine_Api::_()->user()->getViewer();
      if (!$viewer->getIdentity())
        return false;

      $subject = Engine_Api::_()->core()->getSubject();
      if ($subject->getType() !== 'stores') {
        throw new Estore_Model_Exception('This store does not exist.');
      }

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1))
        return false;

      $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $subject->getType(), 'resource_id' => $subject->getIdentity()));
      if (empty($isShortcut)) {
        return array(
            'label' => 'Add to Shortcuts',
            'class' => 'smoothbox estore_icon_addbookmark',
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
            'class' => 'smoothbox estore_icon_removebookmark',
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

  public function onMenuInitialize_EstoreProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'stores') {
      throw new Estore_Model_Exception('This store does not exist.');
    }
    if (!$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.share', 1)) {
      return false;
    }
    return array(
        'label' => 'Share This Store',
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

  public function onMenuInitialize_EstoreProfileDelete() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'stores') {
      throw new Estore_Model_Exception('This store does not exist.');
    } else if (!$subject->authorization()->isAllowed($viewer, 'delete') && !Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'manage_dashboard', 'delete')) {
      return false;
    }
    return array(
        'label' => 'Delete Store',
        'class' => 'smoothbox sesbasic_icon_delete',
        'route' => 'estore_general',
        'params' => array(
            'action' => 'delete',
            'store_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_EstoreProfileSubstore() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    $subject = Engine_Api::_()->core()->getSubject();
    if ((!Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'stores', 'auth_substore') || ($subject->parent_id)) || !Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_store')) {
      return false;
    }
    return array(
        'label' => 'Create New Associated Sub Store',
        'class' => 'sesbasic_icon_edit',
        'route' => 'estore_general',
        'params' => array(
            'action' => 'create',
            'parent_id' => $subject->getIdentity(),
        ),
    );
  }

  public function onMenuInitialize_EstoreProfileMember() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'stores') {
      throw new Estore_Model_Exception('Whoops, not a store!');
    }
    if (!$viewer->getIdentity() || !(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.join', 1)) || !($subject->can_join) || !(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'stores', 'bs_can_join'))) {
      return false;
    }
    $row = $subject->membership()->getRow($viewer);
    // Not yet associated at all
    if (null === $row) {
      if ($subject->membership()->isResourceApprovalRequired()) {
        return array(
            'label' => 'Request Membership',
            'class' => 'smoothbox estore_icon_store_join',
            'route' => 'estore_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'request',
                'store_id' => $subject->getIdentity(),
            ),
        );
      } else {
        return array(
            'label' => 'Join Store',
            'class' => 'smoothbox estore_icon_store_join',
            'route' => 'estore_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'join',
                'store_id' => $subject->getIdentity()
            ),
        );
      }
    }
    // Full member
    // @todo consider owner
    else if ($row->active) {
      if (!$subject->isOwner($viewer)) {
        return array(
            'label' => 'Leave Store',
            'class' => 'smoothbox estore_icon_store_leave',
            'route' => 'estore_extended',
            'params' => array(
                'controller' => 'member',
                'action' => 'leave',
                'store_id' => $subject->getIdentity()
            ),
        );
      } else {
        return false;
      }
    } else if (!$row->resource_approved && $row->user_approved) {
      return array(
          'label' => 'Cancel Membership Request',
          'class' => 'smoothbox estore_icon_store_cancel',
          'route' => 'estore_extended',
          'params' => array(
              'controller' => 'member',
              'action' => 'cancel',
              'store_id' => $subject->getIdentity()
          ),
      );
    } else if (!$row->user_approved && $row->resource_approved) {
      return array(
          array(
              'label' => 'Accept Membership Request',
              'class' => 'smoothbox estore_icon_store_accept',
              'route' => 'estore_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'accept',
                  'store_id' => $subject->getIdentity()
              ),
          ), array(
              'label' => 'Ignore Membership Request',
              'class' => 'smoothbox estore_icon_store_reject',
              'route' => 'estore_extended',
              'params' => array(
                  'controller' => 'member',
                  'action' => 'reject',
                  'store_id' => $subject->getIdentity()
              ),
          )
      );
    } else {
      throw new Estore_Model_Exception('An error has occurred.');
    }
    return false;
  }

  public function onMenuInitialize_EstoreProfileInvite() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'stores') {
      throw new Estore_Model_Exception('This store does not exist.');
    }
    if (!$viewer->getIdentity() || !$subject->can_invite) {
      return false;
    }
    return array(
        'label' => 'Invite Members',
        'class' => 'sessmoothbox',
        'route' => 'estore_extended',
        'params' => array(
            'module' => 'estore',
            'controller' => 'member',
            'action' => 'invite',
            'store_id' => $subject->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_EstoreMainManagePackage($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('estorepackage') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.enable.package', 0)) {
      return false;
    }
    return true;
  }




    public function onMenuInitialize_EstoreReviewProfileEdit() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.review', 0)))
            return false;
        if (!$viewer->getIdentity())
            return false;
        if (!$review->authorization()->isAllowed($viewer, 'edit'))
            return false;
        return array(
            'label' => $view->translate('Edit Review'),
            'class' => 'smoothbox sesbasic_icon_edit',
            'route' => 'estorereview_view',
            'params' => array(
                'action' => 'edit-review',
                'review_id' => $review->getIdentity(),
                'slug' => $review->getSlug(),
            )
        );
    }

    public function onMenuInitialize_EstoreReviewProfileReport() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.show.report', 1)))
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

    public function onMenuInitialize_EstoreReviewProfileShare() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.share', 1)))
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

    public function onMenuInitialize_EstoreReviewProfileDelete() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!$viewer->getIdentity())
            return false;
        if (!$review->authorization()->isAllowed($viewer, 'delete'))
            return false;
        return array(
            'label' => $view->translate('Delete Review'),
            'class' => 'smoothbox sesbasic_icon_delete',
            'route' => 'estorereview_view',
            'params' => array(
                'action' => 'delete',
                'review_id' => $review->getIdentity(),
                'format' => 'smoothbox',
            ),
        );
    }

}
