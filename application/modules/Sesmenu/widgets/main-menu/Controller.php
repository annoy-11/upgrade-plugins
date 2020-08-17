<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Widget_MainMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'sesmenu')->getNavigation('core_main');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $requireCheck = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
    if( !$requireCheck && !$viewer->getIdentity() ) {
      $navigation->removePage($navigation->findOneBy('route', 'user_general'));
    }
    $this->view->menuType = $this->_getParam('menuType', 'horizontal');
    $this->view->menuFromTheme = $this->_getParam('menuFromTheme', false);
    $this->view->max = '12';
    $this->view->moretext = 'More';
  //Cover Photo work
    //Cover Photo work
    $cover = 0;
    if(Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesusercoverphoto')) && $viewerId) {
      if($viewer->cover) {
        $this->view->menuinformationimg = $cover =	Engine_Api::_()->storage()->get($viewer->cover, '');
        if($cover) {
          $this->view->menuinformationimg = $cover->getPhotoUrl();
        }
      }
    }
    $sesmenu_widget = Zend_Registry::isRegistered('sesmenu_widget') ? Zend_Registry::get('sesmenu_widget') : null;
    if(empty($sesmenu_widget))
      return $this->setNoRender();
		if(empty($cover)) {
      $this->view->menuinformationimg = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmenu.menuinformation.img', '');
		}
  	// Mobile Menu User Options
		$this->view->homelinksnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_home');
	}
}
