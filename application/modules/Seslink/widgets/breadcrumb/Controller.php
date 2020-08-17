<?php

class Seslink_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('seslink_link'))
      return $this->setNoRender();
    $this->view->link = Engine_Api::_()->core()->getSubject('seslink_link');
  }
}