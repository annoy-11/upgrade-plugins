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


class Sespagethm_Widget_BannerController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->height = $this->_getParam('height', 250);
    $this->view->storage = Engine_Api::_()->storage();
		$this->view->is_full = $this->_getParam('is_full', '1');
		$this->view->is_full = $this->_getParam('is_pattern', '1');
    $this->view->banner_image = $this->_getParam('banner_image', '');
    $this->view->banner_title = $this->_getParam('banner_title', '');
    $this->view->title_button_color = $this->_getParam('title_button_color', '');
    $this->view->description = $this->_getParam('description', '');
    $this->view->description_button_color = $this->_getParam('description_button_color', '');
    $this->view->button1 = $this->_getParam('button1', '');
    $this->view->button1_text = $this->_getParam('button1_text', '');
    $this->view->button1_text_color = $this->_getParam('button1_text_color', '');
    $this->view->button1_color = $this->_getParam('button1_color', '');
    $sespagethm_widget = Zend_Registry::isRegistered('sespagethm_widget') ? Zend_Registry::get('sespagethm_widget') : null;
    if(empty($sespagethm_widget)) {
      return $this->setNoRender();
    }
    $this->view->button1_mouseover_color = $this->_getParam('button1_mouseover_color', '');
    $this->view->button1_link = $this->_getParam('button1_link', '');
    $this->view->button2 = $this->_getParam('button2', '');
    $this->view->button2_text = $this->_getParam('button2_text', '');
    $this->view->button2_text_color = $this->_getParam('button2_text_color', '');
    $this->view->button2_color = $this->_getParam('button2_color', '');
    $this->view->button2_mouseover_color = $this->_getParam('button2_mouseover_color', '');
    $this->view->button2_link = $this->_getParam('button2_link', '');
    $this->view->button3 = $this->_getParam('button3', '');
    $this->view->button3_text = $this->_getParam('button3_text', '');
    $this->view->button3_text_color = $this->_getParam('button3_text_color', '');
    $this->view->button3_color = $this->_getParam('button3_color', '');
    $this->view->button3_mouseover_color = $this->_getParam('button3_mouseover_color', '');
    $this->view->button3_link = $this->_getParam('button3_link', '');

  }

}
