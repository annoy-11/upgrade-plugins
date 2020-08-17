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

class Sesqa_Widget_CategoryAssociateQaController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $params['limit'] = $this->_getParam('limit_data', 4);
    $params['hasQa'] = 1;
    $this->view->resultcategories = Engine_Api::_()->getDbTable('categories', 'sesqa')->getCategory($params);
		$this->view->limitdataqa = $this->_getParam('limitdataqa', 5);
		$this->view->locationEnable =  $this->_getParam('locationEnable','0');
		$this->view->showviewalllink = $this->_getParam('showviewalllink', 1);
    
    $this->view->socialshare_enable_plusicon =  $this->_getParam('socialshare_enable_plusicon','0');
		$this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 1);
    
    if(count($this->view->resultcategories) <= 0)
      return $this->setNoRender();
		
		$this->view->height = $this->_getParam('height', 0);
    $this->view->width = $this->_getParam('width', 0);
		$this->view->viewtype = $this->_getParam('viewtype', 'list1');
    
    $criteria = $this->_getParam('qacriteria', 'creation_date');
    if($criteria == "unanswered"){
      $this->view->popularCol = $criteria;
      $this->view->info = "";
    }else{
      $this->view->popularCol = "";
        $this->view->info = $criteria;
    }
		
		$this->view->title_truncate = $this->_getParam('title_truncate', 60);
		$this->view->showOptions = $this->_getParam('showinformation', array('likecount', 'viewcount', 'commentcount', 'ratingcount', 'description', 'readmorelink'));
    
  }
}