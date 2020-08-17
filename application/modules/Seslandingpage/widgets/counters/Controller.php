<?php

/**
 */

class Seslandingpage_Widget_CountersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    $this->view->allParams = $this->_getAllParams();
    $seslandingpage_widget = Zend_Registry::isRegistered('seslandingpage_widget') ? Zend_Registry::get('seslandingpage_widget') : null;
    if(empty($seslandingpage_widget))
      return $this->setNoRender();
  }

}
