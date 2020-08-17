<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesspectromedia_Widget_MenuMainController extends Engine_Content_Widget_Abstract {

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
    $header_teamplate = Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_header_design');
    if($header_teamplate == 3) {
	    $this->view->max = 0;
    } else {
	    $this->view->max = $settings->getSetting('sesspectromedia.limit', 4);
    }
    $this->view->moreText = $settings->getSetting('sesspectromedia.moretext', 'More');
    $this->view->storage = Engine_Api::_()->storage();
  }

}
