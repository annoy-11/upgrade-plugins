<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    //Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_main');
    if( count($this->view->navigation) == 1)
      $this->view->navigation = null;
      
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.taboptions', 6);
    if (count($this->view->navigation) == 1)
      $this->view->navigation = null;
  }
}
