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

class Sestwitterclone_Widget_headerController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $loggedinHeaderCondition = unserialize($settings->getSetting('sestwitterclone.headerloggedinoptions', 'a:4:{i:0;s:6:"search";i:1;s:8:"miniMenu";i:2;s:8:"mainMenu";i:3;s:4:"logo";} '));

    $nonloggedinHeaderCondition = unserialize($settings->getSetting('sestwitterclone.headernonloggedinoptions', 'a:3:{i:0;s:8:"miniMenu";i:1;s:8:"mainMenu";i:2;s:4:"logo";}'));

    if($viewerId != 0) {
      if(!in_array('mainMenu',$loggedinHeaderCondition))
        $this->view->show_menu = 0;
      else
        $this->view->show_menu = 1;
			if(!in_array('miniMenu',$loggedinHeaderCondition))
        $this->view->show_mini = 0;
      else
        $this->view->show_mini = 1;
			if(!in_array('logo',$loggedinHeaderCondition))
        $this->view->show_logo = 0;
      else
        $this->view->show_logo = 1;
			if(!in_array('search',$loggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
    }else{
      if(!in_array('mainMenu',$nonloggedinHeaderCondition))
        $this->view->show_menu = 0;
      else
        $this->view->show_menu = 1;
			if(!in_array('miniMenu',$nonloggedinHeaderCondition))
        $this->view->show_mini = 0;
      else
        $this->view->show_mini = 1;
			if(!in_array('logo',$nonloggedinHeaderCondition))
        $this->view->show_logo = 0;
      else
        $this->view->show_logo = 1;
			if(!in_array('search',$nonloggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
    }

    $this->view->footerNavigation =  Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');

    //Call function from sesbasic
    $this->view->languageNameList = Engine_Api::_()->sesbasic()->getLanguages();

    $this->view->mainMenuNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_main');

    $this->view->headerlogo = $settings->getSetting('sestwitterclone.headerlogo', '');
    $this->view->siteTitle = $settings->getSetting('core.general.site.title', 'My Community');
    $this->view->sidepaneldesign = $settings->getSetting('sestwitterclone.sidepaneldesign', 1);
    $this->view->footersidepanel = $settings->getSetting('sestwitterclone.footersidepanel', 1);

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'sesbasic')->getNavigation('sesbasic_mini');
    if ($viewer->getIdentity()) {
      $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
      $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesbasic')->getMessagesUnreadCount($viewer);
      $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
    }

    $this->view->poupup = $settings->getSetting('sestwitterclone.popupsign', 1);

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->view->notificationOnly = $request->getParam('notificationOnly', false);
    $this->view->updateSettings = $settings->getSetting('core.general.notificationupdate');

    $this->view->settingNavigation = $settingsNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_settings', array());
    if ($viewer && $viewer->getIdentity()) {
      if (1 === count(Engine_Api::_()->user()->getSuperAdmins()) && 1 === $viewer->level_id) {
        foreach ($settingsNavigation as $page) {
          if ($page instanceof Zend_Navigation_Page_Mvc && $page->getAction() == 'delete') {
            $settingsNavigation->removePage($page);
          }
        }
      }
    }
  }
}
