<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {
  public function indexAction() { 
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('ecoupon_main', array());
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.taboptions', 9);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }

}
