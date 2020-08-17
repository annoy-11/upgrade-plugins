<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seselegant_Widget_MenuMainController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('core_main');

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    $showMainmenu = $this->_getParam('show_main_menu', 1);
    if ($viewerId == 0 && empty($showMainmenu)) {
      $this->setNoRender();
      return;
    }

    $require_check = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
    if (!$require_check && !$viewerId) {
      $navigation->removePage($navigation->findOneBy('route', 'user_general'));
    }
    $this->view->max = $this->_getParam('seselegant_main_navigation', 10);
    $this->view->storage = Engine_Api::_()->storage();
  }

}
