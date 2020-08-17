<?php

class Sesinviter_Widget_IntroduceYourselfController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->allWidgetParams = $allWidgetParams = $this->_getAllParams();
    
    //Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->result = Engine_Api::_()->getDbTable('introduces', 'sesinviter')->getDescription();
    

  }
}