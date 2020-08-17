<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    $filterOptions = (array)$this->_getParam('search_type', array('recentlySPcreated' => 'Recently Created','mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked', 'mostSPcommented' => 'Most Commented','mostSPfavourite' => 'Most Favourite','featured' => 'Featured','sponsored' => 'Sponsored','verified' => 'Verified','mostSPrated'=>'Most Rated','hot' => 'Hot'));

    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1))
        unset($filterOptions['mostSPfavourite']);

    $this->view->view_type = $this-> _getParam('view_type', 'horizontal');
    $this->view->search_for = $search_for = $this-> _getParam('search_for', 'job');
    $default_search_type = $this-> _getParam('default_search_type', 'mostSPliked');

    if($this->_getParam('location','yes') == 'yes' && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob_enable_location', 1))
    $location = 'yes';
    else
    $location = 'no';
    $sesjob_browsejobs = Zend_Registry::isRegistered('sesjob_browsejobs') ? Zend_Registry::get('sesjob_browsejobs') : null;
    $searchForm = $this->view->form = new Sesjob_Form_Search(array('searchTitle' => $this->_getParam('search_title', 'yes'),'browseBy' => $this->_getParam('browse_by', 'yes'),'categoriesSearch' => $this->_getParam('categories', 'yes'),'searchFor'=>$search_for,'FriendsSearch'=>$this->_getParam('friend_show', 'yes'),'defaultSearchtype'=>$default_search_type,'locationSearch' => $location,'kilometerMiles' => $this->_getParam('kilometer_miles', 'yes'),'hasPhoto' => $this->_getParam('has_photo', 'yes'), 'searchcompTitle' => $this->_getParam('searchcomp_title', 'yes'), 'industry' => $this->_getParam('industry', 'yes'), 'employmenttype' => $this->_getParam('employmenttype', 'yes'), 'educationlevel' => $this->_getParam('educationlevel', 'yes')));
    if (empty($sesjob_browsejobs))
      return $this->setNoRender();
    if($this->_getParam('search_type','job') !== null && $this->_getParam('browse_by', 'yes') == 'yes'){
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

    // Job browse page work
    $page_id = Engine_Api::_()->sesjob()->getWidgetPageId($this->view->identity);
    if($page_id) {
      $pageName = Engine_Db_Table::getDefaultAdapter()->select()
              ->from('engine4_core_pages', 'name')
              ->where('page_id = ?', $page_id)
              ->limit(1)
              ->query()
              ->fetchColumn();
      if($pageName) {
        $this->view->pageName = $pageName;
        $explode = explode('sesjob_index_', $pageName);
        if(is_numeric($explode[1])) {
          $this->view->page_id = $explode[1];
        }
      }
    }
    // Job browse page work
  }
}
