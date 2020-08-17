<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Widget_RecipesCrawlController extends Engine_Content_Widget_Abstract {

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
    $this->view->paginatorRight = Engine_Api::_()->getDbTable('recipes', 'sesrecipe')->getSesrecipesSelect($value);
  }
}