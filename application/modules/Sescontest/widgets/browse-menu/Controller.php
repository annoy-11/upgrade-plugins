<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontest_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('sescontest_main', array());
    $this->view->popup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.open.smoothbox', 0);
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
    $sescontest_browsemenu = Zend_Registry::isRegistered('sescontest_browsemenu') ? Zend_Registry::get('sescontest_browsemenu') : null;
    if(empty($sescontest_browsemenu)) {
      return $this->setNoRender();
    }
  }
}