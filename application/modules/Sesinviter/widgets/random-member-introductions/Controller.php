<?php

class Sesinviter_Widget_RandomMemberIntroductionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->allWidgetParams = $allWidgetParams = $this->_getAllParams();
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->results = $result = Engine_Api::_()->getDbTable('introduces', 'sesinviter')->getWidgetResults(array('limit' => $allWidgetParams['limit'], 'order' => $allWidgetParams['criteria']));
    
    if(count($result) == 0)
      return $this->setNoRender();

  }
}