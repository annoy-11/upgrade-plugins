<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Widget_PopupController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->popup_id = $popup_id = $this->_getParam('popup_id', 0);
		if(!$popup_id)
			 return $this->setNoRender();
		$this->view->auto_open = $this->_getParam('auto_open', 0);
		$this->view->time_execution = $this->_getParam('time_execution', 10000);  
		$this->view->show_button = $this->_getParam('show_button', 1);   
    $this->view->popup = $popup = Engine_Api::_()->getItem('sespagebuilder_popup',$popup_id);
		if(!$popup)
			return $this->setNoRender();
  }
}
