<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edocument_main');
    if( count($this->view->navigation) == 1 ) {
      $this->view->navigation = null;
    }

    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }
}
