<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $sesbusiness_sesbusinesswidget = Zend_Registry::isRegistered('sesbusiness_sesbusinesswidget') ? Zend_Registry::get('sesbusiness_sesbusinesswidget') : null;
    if(empty($sesbusiness_sesbusinesswidget)) {
      return $this->setNoRender();
    }
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('sesbusiness_main', array());
    $this->view->popup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.open.smoothbox', 0);
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }

}
