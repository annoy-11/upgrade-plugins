<?php

/**
 */
class Seslandingpage_Widget_MobileAppController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
	  
    $this->view->heading = $this->_getParam('heading', '');
    $this->view->description = $this->_getParam('description', null);
    $this->view->backgroundimage = Engine_Api::_()->seslandingpage()->getFileUrl($this->_getParam('backgroundimage', 'application/modules/Seslandingpage/externals/images/mobile-app-bg.jpg'));
    
    $this->view->slideimage = $this->_getParam('slideimage', 'application/modules/Seslandingpage/externals/images/app-screens.png');
    
    $this->view->height = $this->_getParam('height', null);
    
    $this->view->buttonurl1 = $this->_getParam('buttonurl1', null);
    $this->view->buttonurl2 = $this->_getParam('buttonurl2', null);
    
  }
}
