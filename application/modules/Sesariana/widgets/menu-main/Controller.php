<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Widget_MenuMainController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_main');

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    $this->view->moretext = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.moretext', 'More');

    //Cover Photo work
    //Cover Photo work
    $cover = 0;
    if(Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesusercoverphoto')) && $viewerId) {
      if($viewer->coverphoto) {
        $this->view->menuinformationimg = $cover =	Engine_Api::_()->storage()->get($viewer->coverphoto, '');
        if($cover) {
          $this->view->menuinformationimg = $cover->getPhotoUrl();
        }
      }
    }
		if(empty($cover)) {
      $this->view->menuinformationimg = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.menuinformation.img', '');
		}

    $this->view->backgroundImg = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.menu.img', '');

    $showMainmenu = $this->_getParam('show_main_menu', 1);
    if ($viewerId == 0 && empty($showMainmenu)) {
      $this->setNoRender();
      return;
    }
    $this->view->submenu = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.submenu', 1);
    $this->view->headerDesign = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.header.design', 2);
    $require_check = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
    if (!$require_check && !$viewerId) {
      $navigation->removePage($navigation->findOneBy('route', 'user_general'));
    }
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.limit', 6);
    $this->view->storage = Engine_Api::_()->storage();

    $this->view->homelinksnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_home');
  }

}
