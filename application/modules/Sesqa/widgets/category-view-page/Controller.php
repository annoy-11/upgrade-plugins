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

class Sesqa_Widget_CategoryViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() { 
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax',false);
    if(!$is_ajax){
      if(!Engine_Api::_()->core()->hasSubject('sesqa_category'))
        return $this->setNoRender();
      $subject  = Engine_Api::_()->core()->getSubject();
    }else{
      $subject = Engine_Api::_()->getItem('sesqa_category',$this->_getParam('category_id'));  
    }
    $this->view->category_id = $subject->getIdentity();
     $this->view->widgetIdentity = $this->_getParam('widgetIdentity', $this->view->identity);
    $this->view->subject = $subject;
    $this->view->loadOptionData = $this->_getParam('loadOptionData','auto_load');
    $this->view->viewType = $this->_getParam('viewtype', 'subcategoryview');
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit');
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon');
    $this->view->title_truncate = $this->_getParam('title_truncate',100);
    $criteria = $this->view->qacriteria = $this->_getParam('qacriteria', 'creation_date');
    $this->view->locationEnable = $this->_getParam('locationEnable',0);
    
    if($criteria == "unanswered"){
      $value['popularCol'] = $criteria;
    }else{
      $value['info'] = $criteria;  
    }
    
    if($subject->subcat_id == 0 && $subject->subsubcat_id == 0)
      $value['category_id'] = $subject->getIdentity();
    else if($subject->subcat_id != 0)
      $value['subcat_id'] = $subject->getIdentity();
    else
      $value['subsubcat_id'] = $subject->getIdentity();
    $this->view->limitdataqa = $limit = $this->_getParam('limitdataqa', 10);
        
    $this->view->height = $this->_getParam('height', 0);
    $this->view->width = $this->_getParam('width', 0);
		
		$this->view->showOptions = $is_ajax ? json_decode($this->_getParam('showinformation', array()),true) : $this->_getParam('showinformation', array());
    $paginator = $this->view->paginator = Engine_Api::_()->getDbTable('questions','sesqa')->getQuestionPaginator($value);
    $paginator->setItemCountPerPage($limit);
    $page = $this->view->page = $this->_getParam('page', 1);
    $this->view->widgetName = 'category-view-page';
    
    $paginator->setCurrentPageNumber($page);
    if($is_ajax){
      $this->getElement()->removeDecorator('Container');
    }
  }
}