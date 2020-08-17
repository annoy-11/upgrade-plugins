<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Plugin_Menus {

  public function canCreateSeslistings() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create seslistings
    if( !Engine_Api::_()->authorization()->isAllowed('seslisting', $viewer, 'create') )
    return false;

    return true;
  }

  public function canListingsContributors() {

    if(!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmember"))
      return false;
    else
      return true;
  }

  public function canViewSeslistingsRequest() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create seslistings
    if( !Engine_Api::_()->authorization()->isAllowed('seslisting', $viewer, 'create') )
    return false;

    return true;
  }

  public function canViewSeslistings() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view seslistings
    if( !Engine_Api::_()->authorization()->isAllowed('seslisting', $viewer, 'view') )
    return false;

    return true;
  }

  public function canViewRsslistings() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view seslistings
    if( !Engine_Api::_()->authorization()->isAllowed('seslisting', $viewer, 'view') )
    return false;

    return true;
  }

  public function canClaimSeslistings() {

    // Must be able to view seslistings
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;
    if(Engine_Api::_()->authorization()->getPermission($viewer, 'seslisting_claim', 'create') && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.claim', 1))
    return true;

    return false;
  }

  public function onMenuInitialize_SeslistingQuickStyle($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    //if( $request->getParam('module') != 'seslisting' || $request->getParam('action') != 'manage' )
    return false;

    // Must be able to style seslistings
    if( !Engine_Api::_()->authorization()->isAllowed('seslisting', $viewer, 'style') )
    return false;

    return true;
  }

  public function onMenuInitialize_SeslistingGutterList($row) {
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof User_Model_User ) {
      $user_id = $subject->getIdentity();
    } else if( $subject instanceof Seslisting_Model_Listing ) {
      $user_id = $subject->owner_id;
    } else {
      return false;
    }

		return array(
        'label' => 'View All User Listings',
				'class'=>'buttonlink icon_seslisting_viewall',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'seslisting_general',
        'params' => array(
            'action' => 'browse',
            'user_id' => $user_id,
        )
    );

  }

  public function onMenuInitialize_SeslistingGutterShare($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Seslisting_Model_Listing) )
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SeslistingGutterReport($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.report', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Seslisting_Model_Listing) &&
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

  public function onMenuInitialize_SeslistingGutterSubscribe($row) {

    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() )
    return false;

    // Check subject
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof Seslisting_Model_Listing ) {
      $owner = $subject->getOwner('user');
    } else if( $subject instanceof User_Model_User ) {
      $owner = $subject;
    } else {
      return false;
    }

    if( $owner->getIdentity() == $viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.subscription', 1))
    return false;

    // Modify params
    $params = $row->params;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'seslisting');
    if( !$subscriptionTable->checkSubscription($owner, $viewer) ) {
      $params['label'] = 'Subscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'add';
      $params['class'] = 'buttonlink smoothbox icon_seslisting_subscribe';
    } else {
      $params['label'] = 'Unsubscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'remove';
      $params['class'] = 'buttonlink smoothbox icon_seslisting_unsubscribe';
    }
    return $params;
  }

  public function onMenuInitialize_SeslistingGutterCreate($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( $viewer->getIdentity() != $owner->getIdentity() )
    return false;

    if( !Engine_Api::_()->authorization()->isAllowed('seslisting', $viewer, 'create') )
    return false;

    return true;
  }

  public function onMenuInitialize_SeslistingGutterSublistingCreate($row) {

    if( !Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sublisting', 1))
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $seslisting = Engine_Api::_()->core()->getSubject('seslisting');
    $isListingAdmin = Engine_Api::_()->seslisting()->isListingAdmin($seslisting, 'edit');
    if( !$isListingAdmin)
    return false;

    $params = $row->params;
    $params['params']['parent_id'] = $seslisting->listing_id;
    return $params;
  }

  public function onMenuInitialize_SeslistingGutterStyle($row){
			return true;
	}
	public function onMenuInitialize_SeslistingGutterEdit($row){
		 return true;
	}
  public function onMenuInitialize_SeslistingGutterDashboard($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $seslisting = Engine_Api::_()->core()->getSubject('seslisting');
    $isListingAdmin = Engine_Api::_()->seslisting()->isListingAdmin($seslisting, 'edit');
    if( !$isListingAdmin)
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['listing_id'] = $seslisting->custom_url;
    return $params;
  }

  public function onMenuInitialize_SeslistingGutterDelete($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $seslisting = Engine_Api::_()->core()->getSubject('seslisting');

    if( !$seslisting->authorization()->isAllowed($viewer, 'delete'))
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['listing_id'] = $seslisting->getIdentity();
    return $params;
  }

  public function onMenuInitialize_SeslistingreviewProfileEdit() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if($review->owner_id != $viewer->getIdentity())
	  return false;

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.allow.review', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;

    if (!$review->authorization()->isAllowed($viewer, 'edit'))
    return false;

    return array(
        'label' => 'Edit Review',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'seslistingreview_view',
        'params' => array(
            'action' => 'edit',
            'review_id' => $review->getIdentity(),
            'slug' => $review->getSlug(),
        )
    );
  }

  public function onMenuInitialize_SeslistingreviewProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.show.report', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.report', 1))
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

  public function onMenuInitialize_SeslistingreviewProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.allow.share', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;

    return array(
        'label' => 'Share',
        'icon' => 'application/modules/Sesbasic/externals/images/share.png',
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

  public function onMenuInitialize_SeslistingreviewProfileDelete() {
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
        'icon' => 'application/modules/Sesbasic/externals/images/delete.png',
        'class' => 'smoothbox',
        'route' => 'seslistingreview_view',
        'params' => array(
            'action' => 'delete',
            'review_id' => $review->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function reviewEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.allow.review', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('seslistingreview', 'view')) {
      return false;
    }
    return true;
  }

  public function locationEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)) {
      return false;
    }
    return true;
  }

}
