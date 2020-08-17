<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Plugin_Menus {

  public function canCreateSesarticles() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create sesarticles
    if( !Engine_Api::_()->authorization()->isAllowed('sesarticle', $viewer, 'create') )
    return false;

    return true;
  }

  public function canViewSesarticlesRequest() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create sesarticles
    if( !Engine_Api::_()->authorization()->isAllowed('sesarticle', $viewer, 'create') )
    return false;

    return true;
  }

  public function canViewSesarticles() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view sesarticles
    if( !Engine_Api::_()->authorization()->isAllowed('sesarticle', $viewer, 'view') )
    return false;

    return true;
  }

  public function canViewRssarticles() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view sesarticles
    if( !Engine_Api::_()->authorization()->isAllowed('sesarticle', $viewer, 'view') )
    return false;

    return true;
  }

  public function canClaimSesarticles() {

    // Must be able to view sesarticles
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;
    if(Engine_Api::_()->authorization()->getPermission($viewer, 'sesarticle_claim', 'create') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.claim', 1))
    return true;

    return false;
  }

  public function onMenuInitialize_SesarticleQuickStyle($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    //if( $request->getParam('module') != 'sesarticle' || $request->getParam('action') != 'manage' )
    return false;

    // Must be able to style sesarticles
    if( !Engine_Api::_()->authorization()->isAllowed('sesarticle', $viewer, 'style') )
    return false;

    return true;
  }

  public function onMenuInitialize_SesarticleGutterList($row) {
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof User_Model_User ) {
      $user_id = $subject->getIdentity();
    } else if( $subject instanceof Sesarticle_Model_Article ) {
      $user_id = $subject->owner_id;
    } else {
      return false;
    }

		return array(
        'label' => 'View All User Articles',
				'class'=>'buttonlink icon_sesarticle_viewall',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'sesarticle_general',
        'params' => array(
            'action' => 'browse',
            'user_id' => $user_id,
        )
    );

  }

  public function onMenuInitialize_SesarticleGutterShare($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sesarticle_Model_Article) )
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SesarticleGutterReport($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.report', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sesarticle_Model_Article) &&
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

  public function onMenuInitialize_SesarticleGutterSubscribe($row) {

    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() )
    return false;

    // Check subject
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof Sesarticle_Model_Article ) {
      $owner = $subject->getOwner('user');
    } else if( $subject instanceof User_Model_User ) {
      $owner = $subject;
    } else {
      return false;
    }

    if( $owner->getIdentity() == $viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.subscription', 1))
    return false;

    // Modify params
    $params = $row->params;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'sesarticle');
    if( !$subscriptionTable->checkSubscription($owner, $viewer) ) {
      $params['label'] = 'Subscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'add';
      $params['class'] = 'buttonlink smoothbox icon_sesarticle_subscribe';
    } else {
      $params['label'] = 'Unsubscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'remove';
      $params['class'] = 'buttonlink smoothbox icon_sesarticle_unsubscribe';
    }
    return $params;
  }

  public function onMenuInitialize_SesarticleGutterCreate($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( $viewer->getIdentity() != $owner->getIdentity() )
    return false;

    if( !Engine_Api::_()->authorization()->isAllowed('sesarticle', $viewer, 'create') )
    return false;

    return true;
  }

  public function onMenuInitialize_SesarticleGutterSubarticleCreate($row) {

    if( !Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.subarticle', 1))
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesarticle = Engine_Api::_()->core()->getSubject('sesarticle');
    $isArticleAdmin = Engine_Api::_()->sesarticle()->isArticleAdmin($sesarticle, 'edit');
    if( !$isArticleAdmin)
    return false;

    $params = $row->params;
    $params['params']['parent_id'] = $sesarticle->article_id;
    return $params;
  }

  public function onMenuInitialize_SesarticleGutterStyle($row){
			return true;
	}
	public function onMenuInitialize_SesarticleGutterEdit($row){
		 return true;
	}
  public function onMenuInitialize_SesarticleGutterDashboard($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesarticle = Engine_Api::_()->core()->getSubject('sesarticle');
    $isArticleAdmin = Engine_Api::_()->sesarticle()->isArticleAdmin($sesarticle, 'edit');
    if( !$isArticleAdmin)
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['article_id'] = $sesarticle->custom_url;
    return $params;
  }

  public function onMenuInitialize_SesarticleGutterDelete($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesarticle = Engine_Api::_()->core()->getSubject('sesarticle');

    if( !$sesarticle->authorization()->isAllowed($viewer, 'delete'))
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['article_id'] = $sesarticle->getIdentity();
    return $params;
  }

  public function onMenuInitialize_SesarticlereviewProfileEdit() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if($review->owner_id != $viewer->getIdentity())
	  return false;

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.allow.review', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;

    if (!$review->authorization()->isAllowed($viewer, 'edit'))
    return false;

    return array(
        'label' => 'Edit Review',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'sesarticlereview_view',
        'params' => array(
            'action' => 'edit',
            'review_id' => $review->getIdentity(),
            'slug' => $review->getSlug(),
        )
    );
  }

  public function onMenuInitialize_SesarticlereviewProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.show.report', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.report', 1))
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

  public function onMenuInitialize_SesarticlereviewProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.allow.share', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1))
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

  public function onMenuInitialize_SesarticlereviewProfileDelete() {
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
        'route' => 'sesarticlereview_view',
        'params' => array(
            'action' => 'delete',
            'review_id' => $review->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function reviewEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.allow.review', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('sesarticlereview', 'view')) {
      return false;
    }
    return true;
  }

  public function locationEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.location', 1)) {
      return false;
    }
    return true;
  }

}
