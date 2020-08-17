<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Plugin_Menus {

  public function canCreateSesrecipes() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) 
    return false;
    
    // Must be able to create sesrecipes
    if( !Engine_Api::_()->authorization()->isAllowed('sesrecipe_recipe', $viewer, 'create') )
    return false;
   
    return true;
  }
  
  public function canRecipesContributors() {
    
    if(!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmember"))
      return false;
    else
      return true;
  }
  
  public function canViewSesrecipesRequest() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) 
    return false;
    
    // Must be able to create sesrecipes
    if( !Engine_Api::_()->authorization()->isAllowed('sesrecipe_recipe', $viewer, 'create') ) 
    return false;
   
    return true;
  }

  public function canViewSesrecipes() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view sesrecipes
    if( !Engine_Api::_()->authorization()->isAllowed('sesrecipe_recipe', $viewer, 'view') ) 
    return false;
    
    return true;
  }
  
  public function canViewRssrecipes() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view sesrecipes
    if( !Engine_Api::_()->authorization()->isAllowed('sesrecipe_recipe', $viewer, 'view') ) 
    return false;

    return true;
  }
  
  public function canClaimSesrecipes() {
  
    // Must be able to view sesrecipes
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) 
    return false;
    if(Engine_Api::_()->authorization()->getPermission($viewer, 'sesrecipe_claim', 'create') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.claim', 1)) 
    return true;
    
    return false;
  }

  public function onMenuInitialize_SesrecipeQuickStyle($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    //if( $request->getParam('module') != 'sesrecipe' || $request->getParam('action') != 'manage' ) 
    return false;
    
    // Must be able to style sesrecipes
    if( !Engine_Api::_()->authorization()->isAllowed('sesrecipe_recipe', $viewer, 'style') ) 
    return false;
    
    return true;
  }

  public function onMenuInitialize_SesrecipeGutterList($row) {
    if( !Engine_Api::_()->core()->hasSubject() ) 
    return false;
    
    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof User_Model_User ) {
      $user_id = $subject->getIdentity();
    } else if( $subject instanceof Sesrecipe_Model_Recipe ) {
      $user_id = $subject->owner_id;
    } else {
      return false;
    }

		return array(
        'label' => 'View All User Recipes',
				'class'=>'buttonlink icon_sesrecipe_viewall',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'sesrecipe_general',
        'params' => array(
            'action' => 'browse',
            'user_id' => $user_id,
        )
    );
		
  }

  public function onMenuInitialize_SesrecipeGutterShare($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) 
    return false;
    
    if( !Engine_Api::_()->core()->hasSubject() ) 
    return false;
    
    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sesrecipe_Model_Recipe) ) 
    return false;
    
    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SesrecipeGutterReport($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.report', 1)) 
    return false;
    
    if( !Engine_Api::_()->core()->hasSubject() ) 
    return false;
    
    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sesrecipe_Model_Recipe) &&
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

  public function onMenuInitialize_SesrecipeGutterSubscribe($row) {
  
    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) 
    return false;
    
    // Check subject
    if( !Engine_Api::_()->core()->hasSubject() ) 
    return false;
    
    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof Sesrecipe_Model_Recipe ) {
      $owner = $subject->getOwner('user');
    } else if( $subject instanceof User_Model_User ) {
      $owner = $subject;
    } else {
      return false;
    }

    if( $owner->getIdentity() == $viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.subscription', 1)) 
    return false;

    // Modify params
    $params = $row->params;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'sesrecipe');
    if( !$subscriptionTable->checkSubscription($owner, $viewer) ) {
      $params['label'] = 'Subscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'add';
      $params['class'] = 'buttonlink smoothbox icon_sesrecipe_subscribe';
    } else {
      $params['label'] = 'Unsubscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'remove';
      $params['class'] = 'buttonlink smoothbox icon_sesrecipe_unsubscribe';
    }
    return $params;
  }

  public function onMenuInitialize_SesrecipeGutterCreate($row) {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( $viewer->getIdentity() != $owner->getIdentity() ) 
    return false;
    
    if( !Engine_Api::_()->authorization()->isAllowed('sesrecipe_recipe', $viewer, 'create') ) 
    return false;
    
    return true;
  }
  
  public function onMenuInitialize_SesrecipeGutterSubrecipeCreate($row) {
  
    if( !Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.subrecipe', 1))
    return false;
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $sesrecipe = Engine_Api::_()->core()->getSubject('sesrecipe_recipe');
    $isRecipeAdmin = Engine_Api::_()->sesrecipe()->isRecipeAdmin($sesrecipe, 'edit');
    if( !$isRecipeAdmin)
    return false;
    
    $params = $row->params;
    $params['params']['parent_id'] = $sesrecipe->recipe_id;
    return $params;
  }
  
  public function onMenuInitialize_SesrecipeGutterStyle($row){
			return true;
	}
	public function onMenuInitialize_SesrecipeGutterEdit($row){
		 return true;
	}
  public function onMenuInitialize_SesrecipeGutterDashboard($row) {
  
    if( !Engine_Api::_()->core()->hasSubject())
    return false;
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $sesrecipe = Engine_Api::_()->core()->getSubject('sesrecipe_recipe');
    $isRecipeAdmin = Engine_Api::_()->sesrecipe()->isRecipeAdmin($sesrecipe, 'edit');
    if( !$isRecipeAdmin)
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['recipe_id'] = $sesrecipe->custom_url;
    return $params;
  }

  public function onMenuInitialize_SesrecipeGutterDelete($row) {
  
    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesrecipe = Engine_Api::_()->core()->getSubject('sesrecipe_recipe');

    if( !$sesrecipe->authorization()->isAllowed($viewer, 'delete'))
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['recipe_id'] = $sesrecipe->getIdentity();
    return $params;
  }

  public function onMenuInitialize_SesrecipereviewProfileEdit() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();
    
    if($review->owner_id != $viewer->getIdentity())
	  return false;

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.allow.review', 1))
    return false;

    if (!$viewer->getIdentity())
    return false;
      
    if (!$review->authorization()->isAllowed($viewer, 'edit'))
    return false;

    return array(
        'label' => 'Edit Review',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'sesrecipereview_view',
        'params' => array(
            'action' => 'edit',
            'review_id' => $review->getIdentity(),
            'slug' => $review->getSlug(),
        )
    );
  }

  public function onMenuInitialize_SesrecipereviewProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.show.report', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.report', 1))
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

  public function onMenuInitialize_SesrecipereviewProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.allow.share', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1))
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

  public function onMenuInitialize_SesrecipereviewProfileDelete() {
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
        'route' => 'sesrecipereview_view',
        'params' => array(
            'action' => 'delete',
            'review_id' => $review->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }
  
  public function reviewEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.allow.review', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view')) {
      return false;
    }
    return true;
  }
  
  public function locationEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)) {
      return false;
    }
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1))
      return false;
    return true;
  }

}
