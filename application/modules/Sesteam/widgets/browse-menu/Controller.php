<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesteam_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $this->_getAllParams();
    $this->getElement()->removeDecorator('Title');

    //Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_main', array());

    if (count($this->view->navigation) == 1)
      $this->view->navigation = null;
  }

}