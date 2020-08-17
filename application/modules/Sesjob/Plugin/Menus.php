<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Plugin_Menus {

  public function canCreateSesjobs() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create sesjobs
    if( !Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'create') )
    return false;

    return true;
  }

  public function canViewCompany() {

    // Must be able to create sesjobs
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1))
    return false;

    return true;
  }

  public function canJobsContributors() {

    if(!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmember"))
      return false;
    else
      return true;
  }

  public function canViewSesjobsRequest() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    return false;

    // Must be able to create sesjobs
    if( !Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'create') )
    return false;

    return true;
  }

  public function canViewSesjobs() {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view sesjobs
    if( !Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'view') )
    return false;

    return true;
  }

  public function onMenuInitialize_SesjobQuickStyle($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    //if( $request->getParam('module') != 'sesjob' || $request->getParam('action') != 'manage' )
    return false;

    // Must be able to style sesjobs
    if( !Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'style') )
    return false;

    return true;
  }

  public function onMenuInitialize_SesjobGutterList($row) {
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof User_Model_User ) {
      $user_id = $subject->getIdentity();
    } else if( $subject instanceof Sesjob_Model_Job ) {
      $user_id = $subject->owner_id;
    } else {
      return false;
    }

		return array(
        'label' => 'View All User Jobs',
				'class'=>'buttonlink icon_sesjob_viewall',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'sesjob_general',
        'params' => array(
            'action' => 'browse',
            'user_id' => $user_id,
        )
    );

  }

  public function onMenuInitialize_SesjobGutterShare($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sesjob_Model_Job) )
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SesjobGutterReport($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.report', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sesjob_Model_Job) &&
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

  public function onMenuInitialize_SesjobGutterSubscribe($row) {

    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() )
    return false;

    // Check subject
    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( $subject instanceof Sesjob_Model_Job ) {
      $owner = $subject->getOwner('user');
    } else if( $subject instanceof User_Model_User ) {
      $owner = $subject;
    } else {
      return false;
    }

    if( $owner->getIdentity() == $viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.subscription', 1))
    return false;

    // Modify params
    $params = $row->params;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'sesjob');
    if( !$subscriptionTable->checkSubscription($owner, $viewer) ) {
      $params['label'] = 'Subscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'add';
      $params['class'] = 'buttonlink smoothbox icon_sesjob_subscribe';
    } else {
      $params['label'] = 'Unsubscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'remove';
      $params['class'] = 'buttonlink smoothbox icon_sesjob_unsubscribe';
    }
    return $params;
  }

  public function onMenuInitialize_SesjobGutterCreate($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( $viewer->getIdentity() != $owner->getIdentity() )
    return false;

    if( !Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'create') )
    return false;

    return true;
  }

  public function onMenuInitialize_SesjobGutterStyle($row){
			return true;
	}
	public function onMenuInitialize_SesjobGutterEdit($row){
		 return true;
	}
  public function onMenuInitialize_SesjobGutterDashboard($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesjob = Engine_Api::_()->core()->getSubject('sesjob_job');
    $isJobAdmin = Engine_Api::_()->sesjob()->isJobAdmin($sesjob, 'edit');
    if( !$isJobAdmin)
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['job_id'] = $sesjob->custom_url;
    return $params;
  }

  public function onMenuInitialize_SesjobGutterDelete($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesjob = Engine_Api::_()->core()->getSubject('sesjob_job');

    if( !$sesjob->authorization()->isAllowed($viewer, 'delete'))
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['job_id'] = $sesjob->getIdentity();
    return $params;
  }

  public function locationEnable() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.location', 1)) {
      return false;
    }
    return true;
  }

}
