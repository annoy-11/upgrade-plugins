<?php

class Sessubscribeuser_Plugin_Menus {

  public function onMenuInitialize_SessubscribeuserProfileSubscribeuser($row) {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();

    if( $subject->authorization()->isAllowed($viewer, 'edit') ) {
      return array(
        'label' => "Subscriber",
        'icon' => 'application/modules/Sessubscribeuser/externals/images/order.png',
        'route' => 'sessubscribeuser_extended',
        'params' => array(
          'module' => 'sessubscribeuser',
          'controller' => 'index',
          'action' => 'orders',
          'user_id' => $subject->getIdentity(),
        )
      );
    }
    return false;
  }
}
