<?php

class Seschristmas_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    //GET NAVIGATION TABS 
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seschristmas_main');
  }

}
