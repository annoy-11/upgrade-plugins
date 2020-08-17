<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Widget_ListingsCrawlController extends Engine_Content_Widget_Abstract {

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
    $this->view->paginatorRight = Engine_Api::_()->getDbTable('seslistings', 'seslisting')->getSeslistingsSelect($value);
  }
}
