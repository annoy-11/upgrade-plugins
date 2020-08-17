<?php

class Sesvideosell_Plugin_Menus {

  public function onMenuInitialize_SesvideosellProfileVideoorder($row) {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();

    if( $subject->authorization()->isAllowed($viewer, 'edit') ) {
      return array(
        'label' => "Video Orders",
        'icon' => 'application/modules/Sesvideosell/externals/images/order.png',
        'route' => 'sesvideosell_extended',
        'params' => array(
          'module' => 'sesvideosell',
          'controller' => 'index',
          'action' => 'orders',
          'user_id' => $subject->getIdentity(),
        )
      );
    }

    return false;
  }
}
