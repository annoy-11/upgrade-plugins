<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Plugin_Menus
{
  public function canCreateSestestimonials()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create blogs
    if( !Engine_Api::_()->authorization()->isAllowed('testimonial', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewSestestimonials()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    // Must be able to view blogs
    if( !Engine_Api::_()->authorization()->isAllowed('testimonial', $viewer, 'view') ) {
      return false;
    }

    return true;
  }
/*
  public function onMenuInitialize_SestestimonialGutterShare($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $subject = Engine_Api::_()->core()->getSubject();
    if( !($subject instanceof Sestestimonial_Model_Sestestimonial) ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  public function onMenuInitialize_SestestimonialGutterReport($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $subject = Engine_Api::_()->core()->getSubject();
    if( ($subject instanceof Sestestimonial_Model_Sestestimonial) &&
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

  public function onMenuInitialize_SestestimonialGutterCreate($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $owner = Engine_Api::_()->getItem('user', $request->getParam('user_id'));

    if( $viewer->getIdentity() != $owner->getIdentity() ) {
      return false;
    }

    if( !Engine_Api::_()->authorization()->isAllowed('blog', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_SestestimonialGutterEdit($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $blog = Engine_Api::_()->core()->getSubject('blog');

    if( !$blog->authorization()->isAllowed($viewer, 'edit') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['blog_id'] = $blog->getIdentity();
    return $params;
  }

  public function onMenuInitialize_SestestimonialGutterDelete($row)
  {
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return false;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $blog = Engine_Api::_()->core()->getSubject('blog');

    if( !$blog->authorization()->isAllowed($viewer, 'delete') ) {
      return false;
    }

    // Modify params
    $params = $row->params;
    $params['params']['blog_id'] = $blog->getIdentity();
    return $params;
  }*/
}
