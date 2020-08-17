<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Plugin_Menus {

  public function onMenuInitialize_SespagenoteGutterShare($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sespagenote_Model_Pagenote) ) {
      return false;
    }

    $share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.allow.share', '1');
    if(empty($share))
        return false;

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SespagenoteGutterReport($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.enable.report', '1'))
        return false;

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sespagenote_Model_Pagenote) &&
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

  public function onMenuInitialize_SespagenoteGutterEdit($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $note = Engine_Api::_()->core()->getSubject('pagenote');

    if( !$note->authorization()->isAllowed($viewer, 'edit') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['pagenote_id'] = $note->getIdentity();
    $params['params']['parent_id'] = $note->parent_id;
    return $params;
  }

  public function onMenuInitialize_SespagenoteGutterDelete($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $note = Engine_Api::_()->core()->getSubject('pagenote');

    if( !$note->authorization()->isAllowed($viewer, 'delete') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['pagenote_id'] = $note->getIdentity();
    $params['params']['parent_id'] = $note->parent_id;
    return $params;
  }
}
