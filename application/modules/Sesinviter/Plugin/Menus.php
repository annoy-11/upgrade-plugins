<?php

class Sesinviter_Plugin_Menus
{
  public function canCreateInvites()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }
    return true;
  }
}
