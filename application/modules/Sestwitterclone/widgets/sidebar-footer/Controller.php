<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sestwitterclone_Widget_SidebarFooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->socialnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_social_sites');

    $this->view->sestwitterclone_extra_menu = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_extra_menu');

    $this->view->url = Zend_Controller_Action_HelperBroker::getStaticHelper('Url');
    $this->view->schemes = new Zend_View_Helper_ServerUrl();
  }
}
