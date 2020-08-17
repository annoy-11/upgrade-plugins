<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sespagethm_Widget_HeaderController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
		$defaultoptn = array('search','miniMenu','mainMenu','logo');
    //$showMainmenu = Engine_Api::_()->getApi('settings', 'core')->getSetting('sm.header.show.nologin', 1);
		$loggedinHeaderCondition = Engine_Api::_()->getApi('settings', 'core')->getSetting('sm.header.loggedin.options', $defaultoptn);
		$nonloggedinHeaderCondition = Engine_Api::_()->getApi('settings', 'core')->getSetting('sm.header.nonloggedin.options',$defaultoptn);
		$this->view->miniUserPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagethm_mini_user_photo_round',1);
			$this->view->headerFixed = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagethm.header.fixed', 1);
			$this->view->core_settings = $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if($viewer_id != 0) {
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
    $sespagethm_header = Zend_Registry::isRegistered('sespagethm_header') ? Zend_Registry::get('sespagethm_header') : null;
    if(empty($sespagethm_header)) {
      return $this->setNoRender();
    }
    $this->view->header_template = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_header_design');
    $this->view->nav_position = Engine_Api::_()->getApi('settings', 'core')->getSetting('sm.navigation.position', 1);

    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('core_main');
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
  }

}
