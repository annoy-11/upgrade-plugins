<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesexpose_Widget_MenuMiniController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $require_check = Engine_Api::_()->getApi('settings', 'core')->core_general_search;
    if (!$require_check) {
      if ($viewer->getIdentity()) {
        $this->view->search_check = true;
      } else {
        $this->view->search_check = false;
      }
    }
    else
      $this->view->search_check = true;

    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'sesbasic')
            ->getNavigation('sesbasic_mini');
    if ($viewer->getIdentity()) {
      $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
      $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesexpose')->getMessagesUnreadCount($viewer);
      $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
    }
    $this->view->poupup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.popupsign', 1);


    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->view->notificationOnly = $request->getParam('notificationOnly', false);
    $this->view->updateSettings = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');

    //LOGIN FORM WORK
    $this->view->form = $form = new Sesbasic_Form_Login();
    $this->view->storage = Engine_Api::_()->storage();

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultoptn = array('search','miniMenu','mainMenu','logo', 'socialshare');
		$loggedinHeaderCondition = $settings->getSetting('sesexp.header.loggedin.options', $defaultoptn);
		$nonloggedinHeaderCondition = $settings->getSetting('sesexp.header.nonloggedin.options',$defaultoptn);
    $viewer_id = $viewer->getIdentity();
    if($viewer_id != 0) {
			if(!in_array('search',$loggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
    } else {
			if(!in_array('search',$nonloggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
		}

		$this->view->headerview = $headerview = Engine_Api::_()->sesexpose()->getContantValueXML('exp_header_type');
  }

}
