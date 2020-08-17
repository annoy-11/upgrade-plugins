<?php

class Sespaymentapi_Plugin_Menus
{
  public function onMenuInitialize_SespaymentapiProfilePayment($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    
    if(empty($viewer->getIdentity()))
      return false;
    
    if( $subject->authorization()->isAllowed($viewer, 'edit') ) {
      return true;
    }
    return false;
  }
}
