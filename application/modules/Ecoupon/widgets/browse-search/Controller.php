<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {
    $filterOptions = (array)$this->_getParam('search_type', array('recentlySPcreated' => 'Recently Created','mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked', 'mostSPcommented' => 'Most Commented','mostSPfavourite' => 'Most Favourite','featured' => 'Featured','sponsored' => 'Sponsored','verified' => 'Verified','mostSPrated'=>'Most Rated'));
  
    $this->view->view_type = $this-> _getParam('view_type', 'horizontal');
    $this->view->search_for = $search_for = $this-> _getParam('search_for', 'course');
    $default_search_type = $this-> _getParam('default_search_type', 'mostSPliked');
    $searchForm = $this->view->form = new Ecoupon_Form_Search(array('searchTitle' => $this->_getParam('search_title', 'yes'),'browseBy' => $this->_getParam('browse_by', 'yes'),'categoriesSearch' => $this->_getParam('categories', 'yes'),'searchFor'=>$search_for,'FriendsSearch'=>$this->_getParam('friend_show', 'yes'),'defaultSearchtype'=>$default_search_type,'price' => $this->_getParam('price', 'yes'),'discount' => $this->_getParam('discount', 'yes'),'lecture'=>$this->_getParam('lecture','yes')));
    if($this->_getParam('search_type','course') !== null && $this->_getParam('browse_by', 'yes') == 'yes'){
      $arrayOptions = $filterOptions;
      $filterOptions = array();
      foreach ($arrayOptions as $key=>$filterOption) {
        if(is_numeric($key))
        $columnValue = $filterOption;
        else
        $columnValue = $key;
				$value = str_replace(array('SP',''), array(' ',' '), $columnValue);
				$filterOptions[$columnValue] = ucwords($value);
      }
      $filterOptions = array(''=>'')+$filterOptions;
      $searchForm->sort->setMultiOptions($filterOptions);
      $searchForm->sort->setValue($default_search_type);
    }
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm->setMethod('get')->populate($request->getParams());
    // Course browse page work
    $page_id = Engine_Api::_()->ecoupon()->getWidgetPageId($this->view->identity);
    if($page_id) {
      $pageName = Engine_Db_Table::getDefaultAdapter()->select()
              ->from('engine4_core_pages', 'name')
              ->where('page_id = ?', $page_id)
              ->limit(1)
              ->query()
              ->fetchColumn();
      if($pageName) {
        $this->view->pageName = $pageName;
        $explode = explode('courses_index_', $pageName);
        if(is_numeric($explode[1])) {
          $this->view->page_id = $explode[1];
        }
      }
    }
    // Course browse page work
  }
}
