<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvancedheader_Widget_HeaderController extends Engine_Content_Widget_Abstract {
	function changeNumber($number){
		$ones = array(
			1 => "one",
			2 => "two",
			3 => "three",
			4 => "four",
			5 => "five",
			6 => "six",
			7 => "seven",
			8 => "eight",
			9 => "nine",
			10 => "ten",
			11 => "eleven",
			12 => "twelve",
			13 => "thirteen",
			14 => "fourteen",
			15 => "fifteen",
		);
		return $ones[$number];
	}
  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $request = Zend_Controller_Front::getInstance()->getRequest();
		$params = $request->getParams();
    $requestUrl = $request->getRequestUri();
    $action = $params['action'];
    $module = $params['module'];
    $controller = $params['controller'];
    $pageName = $module.'_'.$controller.'_'.$action;
    $widgetTable = Engine_Api::_()->getDbTable('content', 'core');
    $widgetPages = Engine_Api::_()->getDbTable('pages', 'core')->info('name');
    $pageTable = Engine_Api::_()->getDbTable('pages', 'core');
    $page_id = 0;
    if($controller == "pages" && $module == "core"){
        $identity = $pageTable->select()
            ->from($pageTable, '*')
            ->where($pageTable->info('name') . '.url = ?', $action);
        $page =   $pageTable->fetchRow($identity);
        if($page)
          $page_id = $page->getIdentity();
    }
    $identity = $widgetTable->select()
            ->setIntegrityCheck(false)
            ->from($widgetTable, '*')
            ->where($widgetTable->info('name') . '.type = ?', 'widget')
            ->where($widgetTable->info('name') . '.name = ?', 'sesadvancedheader.header');
    if(empty($page_id)){
            $identity->where($widgetPages . '.name = ?', $pageName)
            ->joinLeft($widgetPages, $widgetPages . '.page_id = ' . $widgetTable->info('name') . '.page_id',null);
    }else{
      $identity->where('page_id = '.$page_id);
    }
    $headerWidgitOnPage = $widgetTable->fetchRow($identity);
    if($headerWidgitOnPage){
      $identity = $widgetTable->select()
            ->from($widgetTable, '*')
            ->where($widgetTable->info('name') . '.page_id = ?', 1)
            ->where('content_id =?',$this->view->identity);
    $headerWidgit =   $widgetTable->fetchRow($identity);
      if($headerWidgit){
        return $this->setNoRender();
      }
    }
    
    $sesadvancedheader_widgets = Zend_Registry::isRegistered('sesadvancedheader_widgets') ? Zend_Registry::get('sesadvancedheader_widgets') : null;
    if(empty($sesadvancedheader_widgets))
      return $this->setNoRender();
    
    $this->view->headerdesign = $settings->getSetting('sesadvheader.design', '1'); //$this->_getParam('design', 1);
    //$this->view->disableheader = $this->_getParam('disableheader', 0);
    $this->view->storage = Engine_Api::_()->storage();

    $menusApi = Engine_Api::_()->getApi('menus', 'core');

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

    $this->view->mainMenuNavigation = $menusApi->getNavigation('core_main');
    $this->view->homelinksnavigation = $menusApi->getNavigation('user_home');
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'sesbasic')->getNavigation('sesbasic_mini');
    $this->view->social_navigation = $menusApi->getNavigation('sesadvancedheader_extra_menu');

    $this->view->backgroundImg = $settings->getSetting('sesadvancedheader.menu.img', '');

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
      $this->view->menuinformationimg = $settings->getSetting('sesadvancedheader.menuinformation.img', '');
		}

		$this->view->headerlogo = $settings->getSetting('sesadvancedheader.logo', '');
    $this->view->headerfixedlogo = $settings->getSetting('sesadvancedheader.fixed.logo', '');
		$this->view->siteTitle = $settings->getSetting('core.general.site.title', 'My Community');
		//$this->view->headerdesign = $settings->getSetting('sesadvheader.design', '10');
		$this->view->sesadvancedheader_header_transparent = $settings->getSetting('sesadvancedheader.header.transparent','0');
    $this->view->max = $settings->getSetting('sesadvancedheader.limit','5');
    $this->view->moretext = $settings->getSetting('sesadvancedheader.moretext','More');
    $this->view->fixedmax = $settings->getSetting('sesadvancedheader.fixed.limit','5');
    $this->view->fixedmoretext = $settings->getSetting('sesadvancedheader.fixed.moretext','More');
    $this->view->sesadvancedheader_fixed_height = $settings->getSetting('sesadvancedheader_fixed_height','34');
    $this->view->sesadvancedheader_fixed_margintop = $settings->getSetting('sesadvancedheader_fixed_margintop','0');
    $this->view->sesadvancedheader_header_fixed = $settings->getSetting('sesadvancedheader.header.fixed',0);
    $this->view->submenu = $settings->getSetting('sesadvancedheader.header.submenu',1);
    $this->view->poupup = $settings->getSetting('sesadvancedheader.popupsign', 1);
    $this->view->sesadvancedheader_header_opacity = $settings->getSetting('sesadvancedheader.header.opacity',"0.7");
    $this->view->sesadvancedheader_header_bgcolor = $settings->getSetting('sesadvancedheader.header.bgcolor',"000");
		$this->view->sesadvancedheader_header_textcolor = $settings->getSetting('sesadvancedheader.header.textcolor',"fff");
    $this->view->sesadvancedheader_minimenu_transparent = $settings->getSetting('sesadvancedheader.minimenu.transparent',"0");
    $this->view->sesadvancedheader_header_logoheight = $settings->getSetting('sesadvancedheader.header.logoheight',"27");
    $this->view->sesadvancedheader_header_logomargintop = $settings->getSetting('sesadvancedheader.header.logomargintop',"0");
    $this->view->loginsignupbgimage = $settings->getSetting('sesadvancedheader.loginsignupbgimage', '');
    $this->view->loginsignup_logo = $settings->getSetting('sesadvancedheader.loginsignuplogo', '');

		$values = array();
    $values['enabled'] = 1;
    $values['limit'] = $settings->getSetting('sesadvancedheader.search.limit', '8');
    $availableTypes = Engine_Api::_()->getDbTable('managesearchoptions', 'sesadvancedheader')->getAllSearchOptions($values);
    $options = array();
    if (count($availableTypes) > 0) {
      foreach ($availableTypes as $index => $type) {
        $options[$type->type] = strtoupper('ITEM_TYPE_' . $type->type) . '_type_info_' . $type->file_id . '_type_info_' . $type->title;
      }
    }
    $this->view->types = array_merge(array('Everywhere' => 'Everywhere_type_info_'), $options);

    $defaultOptions = array (0 => 'search', 1 => 'miniMenu', 2 => 'mainMenu', 3 => 'logo', 4 => 'ads', 5 => 'socialshare');
    //check options available
    if($viewerId == 0) {
      //check non loggedin options
      $this->view->header_options = $settings->getSetting('sesadvancedheader.header.nonloggedin.options',$defaultOptions);
      if(empty($this->view->header_options))
        return $this->setNoRender();
    } else {
      $this->view->header_options = $settings->getSetting('sesadvancedheader.header.loggedin.options',$defaultOptions);
      if(empty($this->view->header_options))
        return $this->setNoRender();
    }

    if ($viewer->getIdentity()) {
      $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
      $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesadvancedheader')->getMessagesUnreadCount($viewer);
      $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
    }

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->view->notificationOnly = $request->getParam('notificationOnly', false);
    $this->view->updateSettings = $settings->getSetting('core.general.notificationupdate');

    $this->view->settingNavigation = $settingsNavigation = $menusApi->getNavigation('user_settings', array());
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
