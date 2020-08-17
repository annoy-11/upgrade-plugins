<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seshtmlbackground_Widget_SlideImageController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $coreApi = Engine_Api::_()->core();
		$this->view->templateDesign = $this->_getParam('templateDesign', 0);
    $this->view->full_width = $this->_getParam('full_width', 1);
    $this->view->logo = $this->_getParam('logo', 1);
		$params['limit_data'] = $this->_getParam('limit_data', 0);
		$params['order'] = $this->_getParam('order', 'adminorder');
		$this->view->autoplaydelay = $this->_getParam('autoplaydelay',5000);
		$this->view->logo_url = $this->_getParam('logo_url', false);
    $this->view->height = $this->_getParam('height', '583');
		$this->view->autoplay = $this->_getParam('autoplay', '1');
    $this->view->gallery_id = $gallery_id = $this->_getParam('gallery_id', 0);
		$this->view->searchEnable = $searchEnable = $this->_getParam('searchEnable',1);
		$this->view->thumbnail = $this->_getParam('thumbnail',1);
		$this->view->mute_video = $this->_getParam('mute_video',0);
		$this->view->full_height = $this->_getParam('full_height',0);
		$this->view->signupformtopmargin = $this->_getParam('signupformtopmargin',70);
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		
		    $showMainmenu = Engine_Api::_()->getApi('settings', 'core')->getSetting('seshtmlbackground.showmenu.nologin', 1);
    $viewer_id = $viewer->getIdentity();
    if($viewer_id == 0) {
      if($showMainmenu == 0)
        $this->view->show_menu = 0;
      else
        $this->view->show_menu = 1;
    }
    else
    $this->view->show_menu = 1;
		
		$this->view->arrow_button = $this->_getParam('arrow_button', '0');
		$this->view->photo_icon = $this->_getParam('photo_icon', 'photo');
		$this->view->main_menu_design = $this->_getParam('main_menu_design', 'browseby');
		
    if (!$gallery_id)
      return $this->setNoRender();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'seshtmlbackground')->getSlides($gallery_id,'',true,$params);
    if (count($paginator) == 0)
      return $this->setNoRender();
    
	  if($params['limit_data']){
		 $paginator->setItemCountPerPage($params['limit_data']);
		 $paginator->setCurrentPageNumber(1);
		}
		
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seshtmlbackground.pluginactivated'))
	    return $this->setNoRender();
    $this->view->main_navigation = $main_navigation = $this->_getParam('main_navigation', 0);
		$this->view->mini_navigation = $mini_navigation = $this->_getParam('mini_navigation', 0);
		$session = new Zend_Session_Namespace('mobile');
    $mobile = $session->mobile;
		if($mobile){
			$this->view->main_navigation = 0;
			$this->view->mini_navigation = 0;	
		}
    if ($main_navigation) {
      //main menu widget
      $this->view->navigation = $navigation = Engine_Api::_()
              ->getApi('menus', 'core')
              ->getNavigation('core_main');
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
      $require_check = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
      if (!$require_check && !$viewer->getIdentity()) {
        $navigation->removePage($navigation->findOneBy('route', 'user_general'));
      }
    }
    $this->view->moduleEnable = "sesspectromedia";
		$this->view->sesspectromedia = $sesspectromedia = Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesspectromedia'));
    if(!$sesspectromedia){
      $this->view->moduleEnable = "sesariana";
      $this->view->sesspectromedia = $sesspectromedia = Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesariana'));
      if(!$sesspectromedia){
        $this->view->moduleEnable = "sesexpose";
        $this->view->sesspectromedia = $sesspectromedia = Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesexpose'));
      }      
    }
    
		if(!$sesspectromedia){
			$this->view->menumininavigation = $menumininavigation = Engine_Api::_()
				->getApi('menus', 'core')
				->getNavigation('core_mini');
			 if( $viewer->getIdentity() )
			{
				$this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'activity')->hasNotifications($viewer);
			}
			$request = Zend_Controller_Front::getInstance()->getRequest();
			$this->view->notificationOnly = $request->getParam('notificationOnly', false);
			$this->view->updateSettings = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');
		}
	}
}
