<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Widget_HeaderController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultoptn = array('search','miniMenu','mainMenu','logo', 'socialshare');
		$loggedinHeaderCondition = $settings->getSetting('sesytube.header.loggedin.options', $defaultoptn);
		$nonloggedinHeaderCondition = $settings->getSetting('sesytube.header.nonloggedin.options',$defaultoptn);

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $sesytube_header = Zend_Registry::isRegistered('sesytube_header') ? Zend_Registry::get('sesytube_header') : null;
    if(empty($sesytube_header)) {
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
