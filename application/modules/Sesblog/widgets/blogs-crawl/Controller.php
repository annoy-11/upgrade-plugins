<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesblog
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Sesblog_Widget_BlogsCrawlController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->title = $this->_getParam('title', 'Breaking News');
    // $this->view->title_truncation = $this->_getParam('title_truncation', '45');
	 	$this->view->autoplay = $this->_getParam('autoplay',1);
		$this->view->speed = $this->_getParam('speed',2000);
		$this->view->showCreationDate = $this->_getParam('showCreationDate', 1);
    
    $limit =  $this->_getParam('limit_data', 3);
    $value['criteria'] = $this->_getParam('criteria', 5);
    $value['info'] = $this->_getParam('info', 'recently_created');
   	$value['order'] = $this->_getParam('order', '');
    $value['fetchAll'] = true;
		$value['limit'] = 3;
    $this->view->paginatorRight = Engine_Api::_()->getDbTable('blogs', 'sesblog')->getSesblogsSelect($value);
  }
}
