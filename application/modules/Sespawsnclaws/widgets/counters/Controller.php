<?php

/**
 */

class Sespawsnclaws_Widget_CountersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    $this->view->allParams = $this->_getAllParams();
  }

}
