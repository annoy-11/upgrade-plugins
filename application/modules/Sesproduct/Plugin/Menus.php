<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Plugin_Menus {

  public function canCreateSesproducts() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create sesproducts
    if( !Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'create') )
    return false;

    return true;
  }
  function addtocart(){
     return true;
  }
  function canViewMultipleCurrency(){
      if(!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmultiplecurrency"))
          return false;
      else
          return true;
  }
  public function canProductsContributors() {

    if(!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmember"))
      return false;
    else
      return true;
  }

  public function canViewSesproductsRequest() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create sesproducts
    if( !Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'create') )
    return false;

    return true;
  }

  public function canViewSesproducts() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view sesproducts
    if( !Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'view') )
    return false;

    return true;
  }

  public function canViewRssproducts() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view sesproducts
    if( !Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'view') )
    return false;

    return true;
  }

  public function canClaimSesproducts() {

    // Must be able to view sesproducts
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;
    if(Engine_Api::_()->authorization()->getPermission($viewer, 'sesproduct_claim', 'create') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.claim', 1))
    return true;

    return false;
  }

  public function onMenuInitialize_SesproductQuickStyle($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    //if( $request->getParam('module') != 'sesproduct' || $request->getParam('action') != 'manage' )
    return false;

    // Must be able to style sesproducts
    if( !Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'style') )
    return false;

    return true;
  }

  public function onMenuInitialize_SesproductGutterList($row) {
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof User_Model_User ) {
      $user_id = $subject->getIdentity();
    } else if( $subject instanceof Sesproduct_Model_Sesproduct ) {
      $user_id = $subject->owner_id;
    } else {
      return false;
    }

		return array(
        'label' => 'View All User Products',
				'class'=>'buttonlink icon_sesproduct_viewall',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'sesproduct_general',
        'params' => array(
            'action' => 'browse',
            'user_id' => $user_id,
        )
    );

  }

  public function onMenuInitialize_SesproductGutterShare($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sesproduct_Model_Sesproduct) )
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SesproductGutterReport($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.report', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sesproduct_Model_Sesproduct) &&
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

  public function onMenuInitialize_SesproductGutterSubscribe($row) {

    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() )
    return false;

    // Check subject
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof Sesproduct_Model_Sesproduct ) {
      $owner = $subject->getOwner('user');
    } else if( $subject instanceof User_Model_User ) {
      $owner = $subject;
    } else {
      return false;
    }

    if( $owner->getIdentity() == $viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.subscription', 1))
    return false;

    // Modify params
    $params = $row->params;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'sesproduct');
    if( !$subscriptionTable->checkSubscription($owner, $viewer) ) {
      $params['label'] = 'Subscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'add';
      $params['class'] = 'buttonlink smoothbox icon_sesproduct_subscribe';
    } else {
      $params['label'] = 'Unsubscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'remove';
      $params['class'] = 'buttonlink smoothbox icon_sesproduct_unsubscribe';
    }
    return $params;
  }

  public function onMenuInitialize_SesproductGutterCreate($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( $viewer->getIdentity() != $owner->getIdentity() )
    return false;

    if( !Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'create') )
    return false;

    return true;
  }

  public function onMenuInitialize_SesproductGutterSubproductCreate($row) {

    if( !Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.subproduct', 1))
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesproduct = Engine_Api::_()->core()->getSubject('sesproduct');
    $isProductAdmin = Engine_Api::_()->sesproduct()->isProductAdmin($sesproduct, 'edit');
    if( !$isProductAdmin)
    return false;

    $params = $row->params;
    $params['params']['parent_id'] = $sesproduct->product_id;
    return $params;
  }

  public function onMenuInitialize_SesproductGutterStyle($row){
			return true;
	}
	public function onMenuInitialize_SesproductGutterEdit($row){
		 return true;
	}
  public function onMenuInitialize_SesproductGutterDashboard($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesproduct = Engine_Api::_()->core()->getSubject('sesproduct');
    $isProductAdmin = Engine_Api::_()->sesproduct()->isProductAdmin($sesproduct, 'edit');
    if( !$isProductAdmin)
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['product_id'] = $sesproduct->custom_url;
    return $params;
  }

  public function onMenuInitialize_SesproductGutterDelete($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesproduct = Engine_Api::_()->core()->getSubject('sesproduct');

    if( !$sesproduct->authorization()->isAllowed($viewer, 'delete'))
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['product_id'] = $sesproduct->getIdentity();
    return $params;
  }

  public function onMenuInitialize_SesproductreviewProfileEdit() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if($review->owner_id != $viewer->getIdentity())
	  return false;

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.review', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;

    if (!$review->authorization()->isAllowed($viewer, 'edit'))
    return false;

    return array(
        'label' => 'Edit Review',
				'class' => 'smoothbox sesbasic_icon_edit',
        'route' => 'sesproductreview_view',
        'params' => array(
            'action' => 'edit-review',
            'review_id' => $review->getIdentity(),
            'slug' => $review->getSlug(),
        )
    );
  }

  public function onMenuInitialize_SesproductreviewProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.show.report', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.report', 1))
    return false;

    if($review->owner_id == $viewer->getIdentity())
	  return false;

    if (!$viewer->getIdentity())
    return false;

    return array(
        'label' => 'Report',
        //'icon' => 'application/modules/Sesbasic/externals/images/report.png',
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

  public function onMenuInitialize_SesproductreviewProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.share', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;

    return array(
        'label' => 'Share',
        //'icon' => 'application/modules/Sesbasic/externals/images/share.png',
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

  public function onMenuInitialize_SesproductreviewProfileDelete() {
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
        //'icon' => 'application/modules/Sesbasic/externals/images/delete.png',
        'class' => 'smoothbox',
        'route' => 'sesproductreview_view',
        'params' => array(
            'action' => 'delete',
            'review_id' => $review->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function reviewEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.review', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'view')) {
      return false;
    }
    return true;
  }

  public function locationEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1))
      return false;
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1))
      return false;
    return true;
  }
}
