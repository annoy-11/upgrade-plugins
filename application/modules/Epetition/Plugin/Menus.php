<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Menus.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Plugin_Menus
{

  public function mustLogin()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    { return false; }
    return true;
  }

  public function canCreateEpetitions($row) {

    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
      return false;

    // Must be able to create sesblogs
    if( !Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'create') )
    { return false; }

    return true;
  }
  public function onMenuInitialize_EpetitionGutterCanCreateEpetitions()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }

    // Must be able to create epetitions
    if (!Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'create')) {
      return false;
    }

  }

  public function onMenuInitialize_EpetitionGutterVictory($row)
  {
    return false;
  }


  public function canPetitionsContributors()
  {

    if (!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmember"))
      return false;
    else
      return true;
  }

  public function canViewEpetitionsRequest()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity())
      return false;

    // Must be able to create epetitions
    if (!Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'create'))
      return false;

    return true;
  }

  public function canViewEpetitions()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view epetitions
    if (!Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'view'))
      return false;

    return true;
  }

  public function canViewRsspetitions()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view epetitions
    if (!Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'view'))
      return false;

    return true;
  }


  public function onMenuInitialize_EpetitionQuickStyle($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    //if( $request->getParam('module') != 'epetition' || $request->getParam('action') != 'manage' )
    return false;

    // Must be able to style epetitions
    if (!Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'style'))
      return false;

    return true;
  }

  public function onMenuInitialize_EpetitionGutterList($row)
  {
    if (!Engine_Api::_()->core()->hasSubject())
      return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject instanceof User_Model_User) {
      $user_id = $subject->getIdentity();
    } else if ($subject instanceof Epetition_Model_Petition) {
      $user_id = $subject->owner_id;
    } else {
      return false;
    }

    return array(
      'label' => 'View All User Petitions',
      'class' => 'buttonlink icon_epetition_viewall',
      'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
      'route' => 'epetition_general',
      'params' => array(
        'action' => 'browse',
        'user_id' => $user_id,
      )
    );

  }

  public function onMenuInitialize_EpetitionGutterShare($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1))
      return false;

    if (!Engine_Api::_()->core()->hasSubject())
      return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if (!($subject instanceof Epetition_Model_Petition))
      return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_EpetitionGutterReport($row)
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $settings_report=$settings->getSetting('epetition.allow.report',1);
    if($settings_report!=1)
    {
      return false;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $epetition = Engine_Api::_()->core()->getSubject('epetition');
    if (!$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.report', 1))
      return false;

    if (!Engine_Api::_()->core()->hasSubject())
      return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if (($subject instanceof Epetition_Model_Petition) &&
      $subject->owner_id == $viewer->getIdentity()) {
      return false;
    } else if ($subject instanceof User_Model_User &&
      $subject->getIdentity() == $viewer->getIdentity()) {
      return false;
    }



    // Modify params
    $subject = Engine_Api::_()->core()->getSubject();

    return array(
      'label' => 'Report',
      'class' => 'smoothbox sesbasic_icon_report',
      'route' => 'default',
      'params' => array(
        'module' => 'core',
        'controller' => 'report',
        'action' => 'create',
        'subject' => $epetition->getGuid(),
        'format' => 'smoothbox',
      ),
    );

  }

  public function onMenuInitialize_EpetitionGutterSubscribe($row)
  {

    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity())
      return false;

    // Check subject
    if (!Engine_Api::_()->core()->hasSubject())
      return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject instanceof Epetition_Model_Petition) {
      $owner = $subject->getOwner('user');
    } else if ($subject instanceof User_Model_User) {
      $owner = $subject;
    } else {
      return false;
    }

    if ($owner->getIdentity() == $viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.subscription', 1))
      return false;

    // Modify params
    $params = $row->params;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'epetition');
    if (!$subscriptionTable->checkSubscription($owner, $viewer)) {
      $params['label'] = 'Subscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'add';
      $params['class'] = 'buttonlink smoothbox icon_epetition_subscribe';
    } else {
      $params['label'] = 'Unsubscribe';
      $params['params']['user_id'] = $owner->getIdentity();
      $params['action'] = 'remove';
      $params['class'] = 'buttonlink smoothbox icon_epetition_unsubscribe';
    }
    return $params;
  }

  public function onMenuInitialize_EpetitionGutterCreate($row)
  {

    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if ($viewer->getIdentity() != $owner->getIdentity())
      return false;

    if (!Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'create'))
      return false;

    return true;
  }

  public function onMenuInitialize_EpetitionGutterSubpetitionCreate($row)
  {

    if (!Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.subpetition', 1))
      return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $epetition = Engine_Api::_()->core()->getSubject('epetition');
    $isPetitionAdmin = Engine_Api::_()->epetition()->isPetitionAdmin($epetition, 'edit');
    if (!$isPetitionAdmin)
      return false;

    $params = $row->params;
    $params['params']['parent_id'] = $epetition->epetition_id;
    return $params;
  }

  public function onMenuInitialize_EpetitionGutterStyle($row)
  {
    return true;
  }

  public function onMenuInitialize_EpetitionGutterEdit($row)
  {
    return true;
  }


  public function onMenuInitialize_EpetitionGutterDecisionmaker($row)
  {
    $settings = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.signlimit', 3);
    if (!Engine_Api::_()->core()->hasSubject() || $settings == 1)
      return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $epetition = Engine_Api::_()->core()->getSubject('epetition');
    $epetition_id = $epetition->epetition_id;
    $user_id = $viewer->user_id;



    $table = Engine_Api::_()->getDbTable('decisionmakers', 'epetition')
      ->select()
      ->where('user_id =?', $user_id)
      ->where('epetition_id =?', $epetition_id)
      ->query()
      ->fetch();
    if (count($table) == 0 || $user_id!=$epetition['owner_id']) {
      return false;
    }
    //select blog in package with our transaction id.

//    $isPetitionAdmin = Engine_Api::_()->epetition()->isPetitionAdmin($epetition, 'decisionmaker');
//    if( !$isPetitionAdmin)
//      return false;

    // Modify params

    $params = $row->params;
    $params['class'] = 'sessmoothbox';
    $params['params']['epetition_id'] = $epetition->custom_url;
    return $params;
  }


  public function onMenuInitialize_EpetitionGutterDashboard($row)
  {
    if (!Engine_Api::_()->core()->hasSubject()) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'epetition', 'edit');
    $epetition = Engine_Api::_()->core()->getSubject('epetition');
    if($epetition['owner_id']==$viewer->getIdentity() && $quota)
    {
      $params = $row->params;
      $params['params']['epetition_id'] = $epetition->custom_url;
      return $params;
    }
    else if($epetition['owner_id']==$viewer->getIdentity())
    {
      return array(
        'label' => 'Dashboard',
        'route' => 'epetition_dashboard',
        'params' => array(
          'action' => 'petition-signature',
          'epetition_id' => $epetition->custom_url,
        )
      );
    }
    else if($epetition['owner_id']!=$viewer->getIdentity() && $quota==2)
    {
      return array(
        'label' => 'Dashboard',
        'route' => 'epetition_dashboard',
        'params' => array(
          'action' => 'petition-signature',
          'epetition_id' => $epetition->custom_url,
        )
      );
    }
    else
    {
     return false;
    }
    // Modify params

  }

  public function onMenuInitialize_EpetitionGutterDelete($row)
  {

    if( !Engine_Api::_()->core()->hasSubject())
      return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $epetition = Engine_Api::_()->core()->getSubject('epetition');

    if( !$epetition->authorization()->isAllowed($viewer, 'delete'))
      return false;

    //$params = $row->params;
    $params['route'] = 'epetition_specific';
    $params['class'] = 'smoothbox';
    $params['params']['action'] = 'delete';
    $params['params']['epetition_id'] = $epetition->getIdentity();
    return $params;
    
//     // Modify params
//     $params = $row->params;
//     $params['params']['epetition_id'] = $epetition->getIdentity();
//     return $params;
  }

  public function onMenuInitialize_EpetitionsignatureProfileEdit()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $signature = Engine_Api::_()->core()->getSubject();


    if ($signature->owner_id != $viewer->getIdentity())
      return false;

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.signature', 1))
      return false;

    if (!$viewer->getIdentity())
      return false;

    if (!$signature->authorization()->isAllowed($viewer, 'edit'))
      return false;

    return array(
      'label' => 'Edit Signature',
      'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
      'route' => 'epetitionsignature_view',
      'params' => array(
        'action' => 'edit',
        'signature_id' => $signature->getIdentity(),
        'slug' => $signature->getSlug(),
      )
    );
  }

  public function onMenuInitialize_EpetitionsignatureProfileReport()
  {

    $viewer = Engine_Api::_()->user()->getViewer();
    $signature = Engine_Api::_()->core()->getSubject();


    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.show.report', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.report', 1))
      return false;

    if ($signature->owner_id == $viewer->getIdentity())
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
        'subject' => $signature->getGuid(),
        'format' => 'smoothbox',
      ),
    );
  }

  public function onMenuInitialize_EpetitionsignatureProfileShare()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $signature = Engine_Api::_()->core()->getSubject();

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.share', 1) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1))
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
        'type' => $signature->getType(),
        'id' => $signature->getIdentity(),
        'format' => 'smoothbox',
      ),
    );
  }

  public function onMenuInitialize_EpetitionsignatureProfileDelete()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $signature = Engine_Api::_()->core()->getSubject();

    if (!$viewer->getIdentity())
      return false;

    if ($signature->owner_id != $viewer->getIdentity())
      return false;

    if (!$signature->authorization()->isAllowed($viewer, 'delete'))
      return false;

    return array(
      'label' => 'Delete Signature',
      'icon' => 'application/modules/Sesbasic/externals/images/delete.png',
      'class' => 'smoothbox',
      'route' => 'epetitionsignature_view',
      'params' => array(
        'action' => 'delete',
        'signature_id' => $signature->getIdentity(),
        'format' => 'smoothbox',
      ),
    );
  }

  public function signatureEnable()
  {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.signature', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('epetition_signature', 'view')) {
      return false;
    }
    return true;
  }

  public function locationEnable()
  {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.location', 1)) {
      return false;
    }
    return true;
  }

  public function onMenuInitialize_EpetitionProfileMember()
  {

    $menu = array();

    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($subject->getType() !== 'epetition') {
      throw new Core_Model_Exception('Whoops, not a petition!');
    }

    if (!$viewer->getIdentity()) {
      return false;
    }

    $checkPetitionUserAdmin = Engine_Api::_()->epetition()->checkPetitionUserAdmin($subject->getIdentity());
    if (empty($checkPetitionUserAdmin))
      return false;

    $row = $checkPetitionUserAdmin; //$subject->membership()->getRow($viewer);

    if ($viewer->getIdentity() != $subject->owner_id) {
      if (!empty($row) && empty($row->resource_approved)) {

        $menu[] = array(
          'label' => 'Accept Admin Request',
          'class' => 'smoothbox epetition_icon_accept buttonlink',
          'route' => 'epetition_extended',
          'params' => array(
            'controller' => 'index',
            'action' => 'accept',
            'epetition_id' => $subject->getIdentity()
          ),
        );

        $menu[] = array(
          'label' => 'Decline Admin Request',
          'class' => 'smoothbox epetition_icon_reject buttonlink',
          'route' => 'epetition_extended',
          'params' => array(
            'controller' => 'index',
            'action' => 'reject',
            'epetition_id' => $subject->getIdentity()
          ),
        );


      } else if (!empty($row) && !empty($row->resource_approved)) {

        $menu[] = array(
          'label' => 'Remove As Admin',
          'class' => 'smoothbox epetition_icon_reject buttonlink',
          'route' => 'epetition_extended',
          'params' => array(
            'controller' => 'index',
            'action' => 'removeasadmin',
            'epetition_id' => $subject->getIdentity()
          ),
        );
      }
    }

    if (count($menu) == 1) {
      return $menu[0];
    }
    return $menu;
  }
}
