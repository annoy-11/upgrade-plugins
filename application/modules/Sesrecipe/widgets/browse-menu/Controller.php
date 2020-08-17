<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesrecipe_main');
    if( count($this->view->navigation) == 1 ) {
      $this->view->navigation = null;
    }
    $sesrecipe_browserecipes = Zend_Registry::isRegistered('sesrecipe_browserecipes') ? Zend_Registry::get('sesrecipe_browserecipes') : null;
    if (empty($sesrecipe_browserecipes))
      return $this->setNoRender();
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }
}
