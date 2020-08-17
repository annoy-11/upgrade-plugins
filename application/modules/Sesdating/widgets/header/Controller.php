<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdating
 * @package    Sesdating
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-09-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdating_Widget_HeaderController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->sesdating_extra_menu = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdating_extra_menu');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultoptn = array('search','miniMenu','mainMenu','logo', 'socialshare');
		$loggedinHeaderCondition = $settings->getSetting('sesdating.header.loggedin.options', $defaultoptn);
		$nonloggedinHeaderCondition = $settings->getSetting('sesdating.header.nonloggedin.options',$defaultoptn);

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $sesdating_header = Zend_Registry::isRegistered('sesdating_header') ? Zend_Registry::get('sesdating_header') : null;
    if(empty($sesdating_header)) {
      return $this->setNoRender();
    }
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

			if(!in_array('socialshare',$loggedinHeaderCondition))
        $this->view->show_socialshare = 0;
      else
        $this->view->show_socialshare = 1;

			if(!in_array('search',$loggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
    } else {
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
			if(!in_array('socialshare',$nonloggedinHeaderCondition))
        $this->view->show_socialshare = 0;
      else
        $this->view->show_socialshare = 1;
			if(!in_array('search',$nonloggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
		}
  }

}
