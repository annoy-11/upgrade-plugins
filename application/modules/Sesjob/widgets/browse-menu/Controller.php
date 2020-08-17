<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_main');
    if( count($this->view->navigation) == 1 ) {
      $this->view->navigation = null;
    }
    $sesjob_browsejobs = Zend_Registry::isRegistered('sesjob_browsejobs') ? Zend_Registry::get('sesjob_browsejobs') : null;
    if (empty($sesjob_browsejobs))
      return $this->setNoRender();
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }
}
