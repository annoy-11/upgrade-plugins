<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $sesgroup_sesgroupwidget = Zend_Registry::isRegistered('sesgroup_sesgroupwidget') ? Zend_Registry::get('sesgroup_sesgroupwidget') : null;
    if(empty($sesgroup_sesgroupwidget)) {
      return $this->setNoRender();
    }
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('sesgroup_main', array());
    $this->view->popup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.open.smoothbox', 0);
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }

}
