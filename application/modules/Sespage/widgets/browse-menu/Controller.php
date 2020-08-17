<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $sespage_sespagewidget = Zend_Registry::isRegistered('sespage_sespagewidget') ? Zend_Registry::get('sespage_sespagewidget') : null;
    if(empty($sespage_sespagewidget)) {
      return $this->setNoRender();
    }
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('sespage_main', array());
    $this->view->popup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.open.smoothbox', 0);
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }

}
