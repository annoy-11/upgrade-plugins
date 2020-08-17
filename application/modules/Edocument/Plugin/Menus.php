<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Plugin_Menus {

  public function canCreateEdocuments() {

    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();

    if( !$viewer || !$viewer->getIdentity() )
        return false;

    // Must be able to create edocuments
    if( !Engine_Api::_()->authorization()->isAllowed('edocument', $viewer, 'create') )
        return false;

    return true;
  }

  public function canViewEdocuments() {

    $viewer = Engine_Api::_()->user()->getViewer();
    // Must be able to view edocuments
    if( !Engine_Api::_()->authorization()->isAllowed('edocument', $viewer, 'view') )
    return false;

    return true;
  }

  public function onMenuInitialize_EdocumentGutterShare($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Edocument_Model_Edocument) )
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_EdocumentGutterReport($row) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.report', 1))
    return false;

    if( !Engine_Api::_()->core()->hasSubject() )
    return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Edocument_Model_Edocument) &&
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

  public function onMenuInitialize_EdocumentGutterEmail($row) {

    if( !Engine_Api::_()->core()->hasSubject())
        return false;

    $viewer = Engine_Api::_()->user()->getViewer();

    if(!$viewer->getIdentity())
        return false;

    $edocument = Engine_Api::_()->core()->getSubject('edocument');

    if( !Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'edocument', 'emailattachment'))
      return false;
      
    if(!$edocument->attachment)
      return false;

    return array(
      'label' => 'Email Document',
      'class' => 'smoothbox edocument_icon_email',
      'route' => 'edocument_dashboard',
      'params' => array(

        'action' => 'email',
        'edocument_id' => $edocument->custom_url,
        'format' => 'smoothbox',
      ),
    );
  }

  public function onMenuInitialize_EdocumentGutterDownload($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();

    if(!$viewer->getIdentity())
        return false;

    $edocument = Engine_Api::_()->core()->getSubject('edocument');

    if( !Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'edocument', 'download'))
      return false;
      
    if(!$edocument->download)
      return false;
      
    // Modify params
    $params = $row->params;
    $params['params']['edocument_id'] = $edocument->custom_url;
    return $params;
  }

  public function onMenuInitialize_EdocumentGutterDashboard($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $edocument = Engine_Api::_()->core()->getSubject('edocument');

    if( !$edocument->authorization()->isAllowed($viewer, 'edit'))
      return false;
    // Modify params
    $params = $row->params;
    $params['params']['edocument_id'] = $edocument->custom_url;
    return $params;
  }

  public function onMenuInitialize_EdocumentGutterDelete($row) {

    if( !Engine_Api::_()->core()->hasSubject())
    return false;

    $viewer = Engine_Api::_()->user()->getViewer();
    $edocument = Engine_Api::_()->core()->getSubject('edocument');

    if( !$edocument->authorization()->isAllowed($viewer, 'delete'))
    return false;

    // Modify params
    $params = $row->params;
    $params['params']['edocument_id'] = $edocument->getIdentity();
    return $params;
  }
}
