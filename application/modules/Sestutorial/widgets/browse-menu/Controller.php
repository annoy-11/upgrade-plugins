<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestutorial
 * @package    Sestutorial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestutorial_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->browsenavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestutorial_main');
  }
}