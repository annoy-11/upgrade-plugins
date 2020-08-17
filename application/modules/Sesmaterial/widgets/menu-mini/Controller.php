<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmaterial_Widget_MenuMiniController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->core_settings = $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();
    $this->getElement()->removeDecorator('Container');
    $search_settings = $settings->core_general_search;
    if (!$search_settings) {
      if ($viewer->getIdentity()) {
        $this->view->search_check = true;
      } else {
        $this->view->search_check = false;
      }
    } else
      $this->view->search_check = true;

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_mini');

    if ($viewer->getIdentity()) {
      $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesmaterial')->hasNotifications($viewer);
      $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesmaterial')->getMessagesUnreadCount($viewer);
      $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesmaterial')->hasNotifications($viewer, 'friend');
    }

    $this->view->frontRequest = $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->view->notificationOnly = $request->getParam('notificationOnly', false);
    $this->view->updateSettings = $settings->getSetting('core.general.notificationupdate');

    //LOGIN FORM WORK
    $this->view->form = $form = new Sesbasic_Form_Login();
    $this->view->storage = Engine_Api::_()->storage();

    //Get user setting navigation menu
    $this->view->settingNavigation = $settingsNavigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('user_settings', array());

    $user = Engine_Api::_()->user()->getViewer();
    if ($user && $user->getIdentity()) {
      if (1 === count(Engine_Api::_()->user()->getSuperAdmins()) && 1 === $user->level_id) {
        foreach ($settingsNavigation as $page) {
          if ($page instanceof Zend_Navigation_Page_Mvc &&
                  $page->getAction() == 'delete') {
            $settingsNavigation->removePage($page);
          }
        }
      }
    }
  }

}
