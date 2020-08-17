<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Plugin_Menus {

  public function canCreateEblogs() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create eblogs
    if( !Engine_Api::_()->authorization()->isAllowed('eblog_blog', $viewer, 'create') )
    return false;

    return true;
  }

  public function canBlogsContributors() {

    if(!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmember"))
      return false;
    else
      return true;
  }

  public function canViewEblogsRequest() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create eblogs
    if( !Engine_Api::_()->authorization()->isAllowed('eblog_blog', $viewer, 'create') )
    return false;

    return true;
  }

  public function canViewEblogs() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view eblogs
    if( !Engine_Api::_()->authorization()->isAllowed('eblog_blog', $viewer, 'view') )
    return false;

    return true;
  }

  public function canViewRssblogs() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view eblogs
    if( !Engine_Api::_()->authorization()->isAllowed('eblog_blog', $viewer, 'view') )
    return false;

    return true;
  }

  public function canClaimEblogs() {

    // Must be able to view eblogs
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;
    if(Engine_Api::_()->authorization()->getPermission($viewer, 'eblog_claim', 'create') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.claim', 1))
    return true;

    return false;
  }

  public function onMenuInitialize_EblogQuickStyle($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    //if( $request->getParam('module') != 'eblog' || $request->getParam('action') != 'manage' )
    return false;

    // Must be able to style eblogs
    if( !Engine_Api::_()->authorization()->isAllowed('eblog_blog', $viewer, 'style') )
    return false;

    return true;
  }

  public function onMenuInitialize_EblogGutterList($row) {
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof User_Model_User ) {
      $user_id = $subject->getIdentity();
    } else if( $subject instanceof Eblog_Model_Blog ) {
      $user_id = $subject->owner_id;
    } else {
      return false;
    }

		return array(
        'label' => 'View All User Blogs',
				'class'=>'buttonlink icon_eblog_viewall',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'eblog_general',
        'params' => array(
            'action' => 'browse',
            'user_id' => $user_id,
        )
    );

  }

  public function onMenuInitialize_EblogGutterShare($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Eblog_Model_Blog) )
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_EblogGutterReport($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Eblog_Model_Blog) &&
        $subject->owner_id == $viewer->getIdentity() ) {
      return false;
    } else if( $subject instanceof User_Model_User &&
        $subject->getIdentity() == $viewer->getIdentity() ) {
      return false;
    }

    // Modify params
    $subject = Engine_Api::_()->core()->getSubject();
    $params = $row->params;
    $params['params']['subject'] = $subject->getGuid();
    return $params;
  }

  public function onMenuInitialize_EblogGutterSubscribe($row) {

    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() )
    return false;

    // Check subject
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof Eblog_Model_Blog ) {
      $owner = $subject->getOwner('user');
    } else if( $subject instanceof User_Model_User ) {
      $owner = $subject;
    } else {
      return false;
    }

    if( $owner->getIdentity() == $viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.subscription', 1))
    return false;

    // Modify params
    $params = $row->params;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'eblog');
    if( !$subscriptionTable->checkSubscription($owner, $viewer) ) {
      $params['label'] = 'Subscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'add';
      $params['class'] = 'buttonlink smoothbox icon_eblog_subscribe';
    } else {
      $params['label'] = 'Unsubscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'remove';
      $params['class'] = 'buttonlink smoothbox icon_eblog_unsubscribe';
    }
    return $params;
  }

  public function onMenuInitialize_EblogGutterCreate($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( $viewer->getIdentity() != $owner->getIdentity() )
    return false;

    if( !Engine_Api::_()->authorization()->isAllowed('eblog_blog', $viewer, 'create') )
    return false;

    return true;
  }

  public function onMenuInitialize_EblogGutterSubblogCreate($row) {

    if( !Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.subblog', 1))
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $eblog = Engine_Api::_()->core()->getSubject('eblog_blog');
    $isBlogAdmin = Engine_Api::_()->eblog()->isBlogAdmin($eblog, 'edit');
    if( !$isBlogAdmin)
    return false;

    $params = $row->params;
    $params['params']['parent_id'] = $eblog->blog_id;
    return $params;
  }

  public function onMenuInitialize_EblogGutterStyle($row){
			return true;
	}
	public function onMenuInitialize_EblogGutterEdit($row){
		 return true;
	}
  public function onMenuInitialize_EblogGutterDashboard($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $eblog = Engine_Api::_()->core()->getSubject('eblog_blog');
    $isBlogAdmin = Engine_Api::_()->eblog()->isBlogAdmin($eblog, 'edit');
    if( !$isBlogAdmin)
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['blog_id'] = $eblog->custom_url;
    return $params;
  }

  public function onMenuInitialize_EblogGutterDelete($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $eblog = Engine_Api::_()->core()->getSubject('eblog_blog');

    if( !$eblog->authorization()->isAllowed($viewer, 'delete'))
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['blog_id'] = $eblog->getIdentity();
    return $params;
  }

  public function onMenuInitialize_EblogreviewProfileEdit() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if($review->owner_id != $viewer->getIdentity())
	  return false;

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.allow.review', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;

    if (!$review->authorization()->isAllowed($viewer, 'edit'))
    return false;

    return array(
        'label' => 'Edit Review',
        'route' => 'eblogreview_view',
        'params' => array(
            'action' => 'edit',
            'review_id' => $review->getIdentity(),
            'slug' => $review->getSlug(),
        )
    );
  }

  public function onMenuInitialize_EblogreviewProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.show.report', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1))
    return false;

    if($review->owner_id == $viewer->getIdentity())
	  return false;

    if (!$viewer->getIdentity())
    return false;

    return array(
        'label' => 'Report',
        'icon' => 'application/modules/Sesbasic/externals/images/report.png',
        'class' => 'smoothbox',
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

  public function onMenuInitialize_EblogreviewProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.allow.share', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;

    return array(
        'label' => 'Share',
        'class' => 'smoothbox',
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

  public function onMenuInitialize_EblogreviewProfileDelete() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!$viewer->getIdentity())
    return false;

    if($review->owner_id != $viewer->getIdentity())
	  return false;

		if (!$review->authorization()->isAllowed($viewer, 'delete'))
    return false;

    return array(
        'label' => 'Delete Review',
        'class' => 'smoothbox',
        'route' => 'eblogreview_view',
        'params' => array(
            'action' => 'delete',
            'review_id' => $review->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function reviewEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.allow.review', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('eblog_review', 'view')) {
      return false;
    }
    return true;
  }

  public function locationEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.location', 1)) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_EblogProfileMember()
  {

    $menu = array();

    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject->getType() !== 'eblog_blog' )
    {
      throw new Core_Model_Exception('Whoops, not a blog!');
    }

    if( !$viewer->getIdentity() )
    {
      return false;
    }

    $checkBlogUserAdmin = Engine_Api::_()->eblog()->checkBlogUserAdmin($subject->getIdentity());
    if(empty($checkBlogUserAdmin))
        return false;

    $row = $checkBlogUserAdmin; //$subject->membership()->getRow($viewer);

    if($viewer->getIdentity() != $subject->owner_id) {
        if(!empty($row) && empty($row->resource_approved)) {

            $menu[] = array(
                'label' => 'Accept Admin Request',
                'class' => 'smoothbox eblog_icon_accept buttonlink',
                'route' => 'eblog_extended',
                'params' => array(
                    'controller' => 'index',
                    'action' => 'accept',
                    'blog_id' => $subject->getIdentity()
                ),
            );

            $menu[] =  array(
                'label' => 'Decline Admin Request',
                'class' => 'smoothbox eblog_icon_reject buttonlink',
                'route' => 'eblog_extended',
                'params' => array(
                    'controller' => 'index',
                    'action' => 'reject',
                    'blog_id' => $subject->getIdentity()
                ),
            );



        } else if(!empty($row) && !empty($row->resource_approved)) {

            $menu[] =  array(
                'label' => 'Remove As Admin',
                'class' => 'smoothbox eblog_icon_reject buttonlink',
                'route' => 'eblog_extended',
                'params' => array(
                    'controller' => 'index',
                    'action' => 'removeasadmin',
                    'blog_id' => $subject->getIdentity()
                ),
            );
        }
    }

    if( count($menu) == 1 ) {
      return $menu[0];
    }
    return $menu;
  }
}
