<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Widget_CategoryQuestionController extends Engine_Content_Widget_Abstract {
  public function indexAction() {			
		$this->view->height = $this->_getParam('height', '180');
		$this->view->width = $this->_getParam('width', '180');	
    $this->view->viewType = $this->_getParam('viewtype','list1');
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
		$this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
		$params['locationEnable'] =  $this->_getParam('locationEnable','0');
		$this->view->title_truncation  = $this->_getParam('title_truncate', '100');
		$this->view->showOptions = $this->_getParam('show_criteria',array('like','comment','itemPhoto','by','date','title','socialSharing','view','favouriteCount','favouriteButton','likeButton','tags'));
		$result = $this->_getParam('result');
		$this->view->paginator = $result;
  }
}