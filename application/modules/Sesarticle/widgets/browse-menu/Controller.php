<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesarticle_main');
    if( count($this->view->navigation) == 1 ) {
      $this->view->navigation = null;
    }
    $sesarticle_browsearticles = Zend_Registry::isRegistered('sesarticle_browsearticles') ? Zend_Registry::get('sesarticle_browsearticles') : null;
    if (empty($sesarticle_browsearticles))
      return $this->setNoRender();
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.taboptions', 6);
    if (count($this->view->navigation) == 1) {
      $this->view->navigation = null;
    }
  }
}
