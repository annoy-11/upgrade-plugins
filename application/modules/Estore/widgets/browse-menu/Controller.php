<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $estore_estorewidget = Zend_Registry::isRegistered('estore_estorewidget') ? Zend_Registry::get('estore_estorewidget') : null;
    if(empty($estore_estorewidget)) {
      return $this->setNoRender();
    }
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('estore_main', array());


    $this->view->popup = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.open.smoothbox', 0);
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.taboptions', 6);
		

    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }

}
