<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Plugin_Menus {

  public function onMenuInitialize_SesbusinessofferGutterShare($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sesbusinessoffer_Model_Businessoffer) ) {
      return false;
    }

    $share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.allow.share', '1');
    if(empty($share))
        return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SesbusinessofferGutterReport($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.enable.report', '1'))
        return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sesbusinessoffer_Model_Businessoffer) &&
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

  public function onMenuInitialize_SesbusinessofferGutterEdit($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $offer = Engine_Api::_()->core()->getSubject('businessoffer');

    if( !$offer->authorization()->isAllowed($viewer, 'edit') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['businessoffer_id'] = $offer->getIdentity();
    $params['params']['parent_id'] = $offer->parent_id;
    return $params;
  }

  public function onMenuInitialize_SesbusinessofferGutterDelete($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $offer = Engine_Api::_()->core()->getSubject('businessoffer');

    if( !$offer->authorization()->isAllowed($viewer, 'delete') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['businessoffer_id'] = $offer->getIdentity();
    $params['params']['parent_id'] = $offer->parent_id;
    return $params;
  }
}
