<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Einstaclone_Widget_SidebarFooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->socialnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_social_sites');

    $this->view->einstaclone_extra_menu = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_extra_menu');
    $einstaclone_browse = Zend_Registry::isRegistered('einstaclone_browse') ? Zend_Registry::get('einstaclone_browse') : null;
    if(empty($einstaclone_browse))
      return $this->setNoRender();
    $this->view->url = Zend_Controller_Action_HelperBroker::getStaticHelper('Url');
    $this->view->schemes = new Zend_View_Helper_ServerUrl();
  }
}
