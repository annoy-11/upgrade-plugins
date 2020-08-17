<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Plugin_Menus {

  public function canViewMultipleCurrency() {
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmultiplecurrency'))
      return true;
    else
      return false;
  }

  public function canCreateSescrowdfundings() {

    //Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
      return false;

    //Must be able to create sescrowdfundings
    if( !Engine_Api::_()->authorization()->isAllowed('crowdfunding', $viewer, 'create') )
      return false;

    return true;
  }

  public function canMyDonation() {

    //Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
      return false;

    return true;
  }

  public function canViewSescrowdfundings() {

    $viewer = Engine_Api::_()->user()->getViewer();

    // Must be able to view sescrowdfundings
    if( !Engine_Api::_()->authorization()->isAllowed('crowdfunding', $viewer, 'view') )
      return false;

    return true;
  }

  public function onMenuInitialize_SescrowdfundingGutterShare($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity())
      return false;

    if( !Engine_Api::_()->core()->hasSubject() )
      return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sescrowdfunding_Model_Crowdfunding) )
      return false;

    $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1);
    if(empty($enableShare))
        return false;

    //Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SescrowdfundingGutterReport($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity())
      return false;

    if( !Engine_Api::_()->core()->hasSubject() )
      return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sescrowdfunding_Model_Crowdfunding) && $subject->owner_id == $viewer->getIdentity() ) {
      return false;
    } else if( $subject instanceof User_Model_User && $subject->getIdentity() == $viewer->getIdentity() ) {
      return false;
    }

    //Modify params
    $subject = Engine_Api::_()->core()->getSubject();
    $params = $row->params;
    $params['params']['subject'] = $subject->getGuid();
    return $params;
  }

  public function onMenuInitialize_SescrowdfundingGutterCreate($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( !Engine_Api::_()->authorization()->isAllowed('crowdfunding', $viewer, 'create') )
      return false;

    return true;
  }

  public function onMenuInitialize_SescrowdfundingGutterDashboard($row) {

    if( !Engine_Api::_()->core()->hasSubject())
      return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sescrowdfunding = Engine_Api::_()->core()->getSubject('crowdfunding');

    if( !$sescrowdfunding->authorization()->isAllowed($viewer, 'edit') )
      return false;

    // Modify params
    $params = $row->params;
    $params['params']['crowdfunding_id'] = $sescrowdfunding->custom_url;
    return $params;
  }

  public function onMenuInitialize_SescrowdfundingGutterDelete($row) {

    if( !Engine_Api::_()->core()->hasSubject())
      return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sescrowdfunding = Engine_Api::_()->core()->getSubject('crowdfunding');

    if( !$sescrowdfunding->authorization()->isAllowed($viewer, 'delete'))
      return false;

    // Modify params
    $params = $row->params;
    $params['params']['crowdfunding_id'] = $sescrowdfunding->getIdentity();
    return $params;
  }

  public function onMenuInitialize_SescrowdfundingGutterTellafriend($row) {

    if( !Engine_Api::_()->core()->hasSubject())
      return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $sescrowdfunding = Engine_Api::_()->core()->getSubject('crowdfunding');

    // Modify params
    $params = $row->params;
    $params['params']['crowdfunding_id'] = $sescrowdfunding->crowdfunding_id;
    return $params;
  }

  public function onMenuInitialize_SescrowdfundingGutterMessageowner($row) {

    if( !Engine_Api::_()->core()->hasSubject())
      return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $sescrowdfunding = Engine_Api::_()->core()->getSubject('crowdfunding');

    if ($sescrowdfunding->owner_id == $viewer_id || empty($viewer_id))
      return false;

    $essageowner = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'messages', 'auth');
    if ($essageowner == 'none')
      return false;

    // Modify params
    $params = $row->params;
    $params['params']['crowdfunding_id'] = $sescrowdfunding->crowdfunding_id;
    return $params;
  }
}
