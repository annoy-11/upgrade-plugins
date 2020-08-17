<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get navigation
    $this->view->navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('sesmember_main', array());
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
    $sesmember_browsemembers = Zend_Registry::isRegistered('sesmember_browsemembers') ? Zend_Registry::get('sesmember_browsemembers') : null;
    if (empty($sesmember_browsemembers))
      return $this->setNoRender();
    $this->view->max = $this->_getParam('sesmember_taboptions', 6);
  }

}
