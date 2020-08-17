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


class Sesfbstyle_Widget_FooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');

    $this->view->socialnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_social_sites');
    
    $this->view->sesfbstyle_extra_menu = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfbstyle_extra_menu');
    $sesfbstyle_footer = Zend_Registry::isRegistered('sesfbstyle_footer') ? Zend_Registry::get('sesfbstyle_footer') : null;
    if(empty($sesfbstyle_footer)) {
      return $this->setNoRender();
    }
    $this->view->storage = Engine_Api::_()->storage();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->footer_text = $settings->getSetting('sesfbstyle.footer.aboutdes', '');
    $this->view->footerlogo = $settings->getSetting('sesfbstyle.footerlogo', '');
    $this->view->siteTitle = $settings->getSetting('core.general.site.title', 'My Community');
  }
}