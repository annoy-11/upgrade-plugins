<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Widget_BrowseAlbumSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $filterOptions = (array)$this->_getParam('search_type', array('recentlySPcreated' => 'Recently Created','mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked', 'mostSPcommented' => 'Most Commented','mostSPfavourite'=>'Most Favourite'));
    $this->view->view_type = $this-> _getParam('view_type', 'horizontal');
    $this->view->search_for = $search_for = $this-> _getParam('search_for', 'album');
    $default_search_type = $this-> _getParam('default_search_type', 'mostSPliked');
    $searchForm = $this->view->searchForm = new Eclassroom_Form_AlbumSearch(array('searchTitle' => $this->_getParam('search_title', 'yes'),'browseBy' => $this->_getParam('browse_by', 'yes'),'searchFor'=>$search_for,'FriendsSearch'=>$this->_getParam('friend_show', 'yes'),'defaultSearchtype'=>$default_search_type));
    if(isset($_GET['tag_name'])){
      $searchForm->getElement('search')->setValue($_GET['tag_name']);
    }
    if($this->_getParam('search_type') !== null && $this->_getParam('browse_by', 'yes') == 'yes') {
      $arrayOptions = $filterOptions;
      $filterOptions = array();
      foreach ($arrayOptions as $filterOption) {
        $value = str_replace(array('SP',''), array(' ',' '), $filterOption);
        $filterOptions[$filterOption] = ucwords($value);
      }
      $filterOptions = array(''=>'')+$filterOptions;
      $searchForm->sort->setMultiOptions($filterOptions);
      $searchForm->sort->setValue($default_search_type);
    }
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm->setMethod('get')->populate($request->getParams());
  }
}
