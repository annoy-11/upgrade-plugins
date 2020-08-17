<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Widget_headerController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();


    $loggedinHeaderCondition = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.headerloggedinoptions', 'a:4:{i:0;s:6:"search";i:1;s:8:"miniMenu";i:2;s:8:"mainMenu";i:3;s:4:"logo";} '));
    $nonloggedinHeaderCondition = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.headernonloggedinoptions', 'a:3:{i:0;s:8:"miniMenu";i:1;s:8:"mainMenu";i:2;s:4:"logo";}'));

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
    $seslinkedin_header = Zend_Registry::isRegistered('seslinkedin_header') ? Zend_Registry::get('seslinkedin_header') : null;
    if(empty($seslinkedin_header)) {
      return $this->setNoRender();
    }
    $this->view->footerNavigation =  Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');

// Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    //$currentLocale = Zend_Registry::get('Locale')->__toString();
    // Prepare default langauge
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if (!in_array($defaultLanguage, $languageList)) {
      if ($defaultLanguage == 'auto' && isset($languageList['en'])) {
        $defaultLanguage = 'en';
      } else {
        $defaultLanguage = null;
      }
    }

    // Prepare language name list
    $languageNameList = array();
    $languageDataList = Zend_Locale_Data::getList(null, 'language');
    $territoryDataList = Zend_Locale_Data::getList(null, 'territory');

    foreach ($languageList as $localeCode) {
      $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
      if (empty($languageNameList[$localeCode])) {
        if (false !== strpos($localeCode, '_')) {
          list($locale, $territory) = explode('_', $localeCode);
        } else {
          $locale = $localeCode;
          $territory = null;
        }
        if (isset($territoryDataList[$territory]) && isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
        } else if (isset($territoryDataList[$territory])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory];
        } else if (isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $languageDataList[$locale];
        } else {
          continue;
        }
      }
    }

    $languageNameList = array_merge(array($defaultLanguage => $defaultLanguage), $languageNameList);
    $this->view->languageNameList = $languageNameList;

    $this->view->mainMenuNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_main');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->headerlogo = $settings->getSetting('seslinkedin.headerlogo', '');
    $this->view->siteTitle = $settings->getSetting('core.general.site.title', 'My Community');
    $this->view->sidepaneldesign = $settings->getSetting('seslinkedin.sidepaneldesign', 1);
    $this->view->footersidepanel = $settings->getSetting('seslinkedin.footersidepanel', 1);

    $this->view->poupup = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.popupsign', 1);

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'sesbasic')->getNavigation('sesbasic_mini');
    if ($viewer->getIdentity()) {
      $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
      $this->view->messageCount = Engine_Api::_()->getApi('message', 'seslinkedin')->getMessagesUnreadCount($viewer);
      $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
    }

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->view->notificationOnly = $request->getParam('notificationOnly', false);
    $this->view->updateSettings = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');

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
