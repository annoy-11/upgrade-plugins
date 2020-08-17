<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfbstyle_Widget_LandingPageController extends Engine_Content_Widget_Abstract {
  public function indexAction() {    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->socialloginbutton = $this->_getParam('socialloginbutton', 0);
		$this->view->socialnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_social_sites');
    $this->view->leftsideimage = $this->_getParam('leftsideimage', '');
    $this->view->heading = $this->_getParam('heading', 'Welcome to SocialEngine! We\'re glad that you\'re here.');
    $this->view->description = $this->_getParam('description', 'We believe that friends are important – we hope that you\'ll connect with yours on SocialEngine.');
    $sesfbstyle_landingpage = Zend_Registry::isRegistered('sesfbstyle_landingpage') ? Zend_Registry::get('sesfbstyle_landingpage') : null;
    if(empty($sesfbstyle_landingpage)) {
      return $this->setNoRender();
    }
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');
  }
}