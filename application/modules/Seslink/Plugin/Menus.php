<?php

class Seslink_Plugin_Menus
{
  public function canCreateLinks()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create links
    if( !Engine_Api::_()->authorization()->isAllowed('seslink_link', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewLinks()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    return true;
  }
}