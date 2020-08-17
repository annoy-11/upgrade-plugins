<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seslisting_main');
    if( count($this->view->navigation) == 1 ) {
      $this->view->navigation = null;
    }
    $seslisting_browselistings = Zend_Registry::isRegistered('seslisting_browselistings') ? Zend_Registry::get('seslisting_browselistings') : null;
    if (empty($seslisting_browselistings))
      return $this->setNoRender();
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }
}
