<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Get navigation menu
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesqa_main');
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
    $sesqa_menus = Zend_Registry::isRegistered('sesqa_menus') ? Zend_Registry::get('sesqa_menus') : null;
    if(empty($sesqa_menus)) {
      return $this->setNoRender();
    }
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.taboptions', 6);
  }
}
