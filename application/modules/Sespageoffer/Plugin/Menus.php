<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Plugin_Menus {

  public function onMenuInitialize_SespageofferGutterShare($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sespageoffer_Model_Pageoffer) ) {
      return false;
    }

    $share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.allow.share', '1');
    if(empty($share))
        return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SespageofferGutterReport($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.enable.report', '1'))
        return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sespageoffer_Model_Pageoffer) &&
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

  public function onMenuInitialize_SespageofferGutterEdit($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $offer = Engine_Api::_()->core()->getSubject('pageoffer');

    if( !$offer->authorization()->isAllowed($viewer, 'edit') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['pageoffer_id'] = $offer->getIdentity();
    $params['params']['parent_id'] = $offer->parent_id;
    return $params;
  }

  public function onMenuInitialize_SespageofferGutterDelete($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $offer = Engine_Api::_()->core()->getSubject('pageoffer');

    if( !$offer->authorization()->isAllowed($viewer, 'delete') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['pageoffer_id'] = $offer->getIdentity();
    $params['params']['parent_id'] = $offer->parent_id;
    return $params;
  }
}
