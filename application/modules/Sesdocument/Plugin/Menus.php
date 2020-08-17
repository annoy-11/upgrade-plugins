<?php

class Sesdocument_Plugin_Menus {
 
  public function canCreateDocuments() {
    // Must be logged in
  
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }
    // Must be able to create events
    if (!Engine_Api::_()->authorization()->isAllowed('sesdocument', $viewer, 'create')) {
      return false;
    }
    return true;
  }

    public function onMenuInitialize_SesdocumentMainCreate() {
    $viewer = Engine_Api::_()->user()->getViewer();

    if (!$viewer->getIdentity()) {
      return false;
    }

    if (!Engine_Api::_()->authorization()->isAllowed('sesdocument', null, 'create')) {
      return false;
    }
    return true;
   
  }

}