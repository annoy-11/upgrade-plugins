<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract
{

  public function indexAction()
  {
    // Get navigation
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('epetition_main');
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.taboptions', $settings->getSetting('epetition.item.count',6));
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }
}
