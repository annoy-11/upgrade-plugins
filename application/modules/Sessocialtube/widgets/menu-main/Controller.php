<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessocialtube_Widget_MenuMainController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('core_main');

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $this->getElement()->removeDecorator('Container');
    $showMainmenu = $this->_getParam('show_main_menu', 1);
    if ($viewerId == 0 && empty($showMainmenu)) {
      $this->setNoRender();
      return;
    }

    $require_check = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
    if (!$require_check && !$viewerId) {
      $navigation->removePage($navigation->findOneBy('route', 'user_general'));
    }
    $header_teamplate = Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_header_design');
    if($header_teamplate == 3) {
	    $this->view->max = 0;
    } else {
	    $this->view->max = $settings->getSetting('sessocialtube.limit', 4);
    }
    $this->view->moreText = $settings->getSetting('sessocialtube.moretext', 'More');
    $this->view->storage = Engine_Api::_()->storage();
  }

}
