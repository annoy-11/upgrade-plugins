<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Plugin_Menus
{
  public function canCreateDiscussions()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create discussions
    if( !Engine_Api::_()->authorization()->isAllowed('discussion', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewDiscussions()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    return true;
  }

  public function onMenuInitialize_SesdiscussionGutterShare($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sesdiscussion_Model_Discussion) ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SesdiscussionGutterReport($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sesdiscussion_Model_Discussion) &&
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

  public function onMenuInitialize_SesdiscussionGutterEdit($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesdiscussion = Engine_Api::_()->core()->getSubject('discussion');

    if( !$sesdiscussion->authorization()->isAllowed($viewer, 'edit') ) {
      return false;
    }


    $createform = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.createform', 1);

    if(!empty($createform)) {
        return array(
            'label' => 'Edit Discussion',
            'class'=>'buttonlink sessmoothbox',
            'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
            'route' => 'sesdiscussion_specific',
            'params' => array(
                'action' => 'edit',
                'discussion_id' => $sesdiscussion->getIdentity(),
            )
        );
    } else {
        return array(
            'label' => 'Edit Discussion',
            'class'=>'buttonlink',
            'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
            'route' => 'sesdiscussion_specific',
            'params' => array(
                'action' => 'edit',
                'discussion_id' => $sesdiscussion->getIdentity(),
            )
        );
    }
  }

  public function onMenuInitialize_SesdiscussionGutterDelete($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $sesdiscussion = Engine_Api::_()->core()->getSubject('discussion');

    if( !$sesdiscussion->authorization()->isAllowed($viewer, 'delete') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['discussion_id'] = $sesdiscussion->getIdentity();
    return $params;
  }
}
