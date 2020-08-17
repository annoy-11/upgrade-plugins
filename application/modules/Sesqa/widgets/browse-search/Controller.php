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
class Sesqa_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $option = array('recentlySPcreated' =>'Recently Created','mostSPviewed' =>'Most Viewed','mostSPliked'=>'Most Liked','mostSPcommented' =>'Most Commented','mostSPvoted' => 'Most Voted','mostSPfavourite' => 'Most Favourite','homostSPanswered' =>'Most Answered','unanswered' =>'Unanswered');
    $filterOptions = (array)$this->_getParam('search_type', $option);
    $this->view->view_type = $this-> _getParam('view_type', 'horizontal');
    $this->view->searchboxwidth = $this-> _getParam('searchboxwidth', '170');
		$setting = Engine_Api::_()->getApi('settings', 'core');

		$default_search_type = $this-> _getParam('default_search_type', 'recentlySPcreated');

		if($this->_getParam('location','yes') == 'yes' && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_location', 1)){
			$location = 'yes';
		}else
			$location = 'no';
	 $searchForm = $this->view->searchForm = new Sesqa_Form_Browsesearch(array('searchTitle' => $this->_getParam('search_title', 'yes'),'browseBy' => $this->_getParam('browse_by', 'yes'),'categoriesSearch' => $this->_getParam('categories', 'yes'),'locationSearch' => $location,'kilometerMiles' => $this->_getParam('kilometer_miles', 'yes'),'FriendsSearch'=>$this->_getParam('friend_show', 'yes'),'defaultSearchtype'=>$default_search_type,'startendTime' => $this->_getParam('search_startendtime', 'yes')));
	 if(isset($_GET['tag_name'])){
		 $searchForm->getElement('searchText')->setValue($_GET['tag_name']);
	 }
   if($this->_getParam('browse_by', 'yes') == 'yes'){
		$arrayOptions = $filterOptions;
		$filterOptions = array();
    $enableNewSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_newLabel', 1);
		foreach ($arrayOptions as $key=>$filterOption) {
      if($filterOption == "new" && !$enableNewSetting)
        continue;
      $value = isset($option[$filterOption]) ? $option[$filterOption] : str_replace(array('SP',''), array(' ',' '), $filterOption);
      $filterOptions[$filterOption] = ucwords($value);
    }
		$filterOptions = array(''=>'')+$filterOptions;
		 $searchForm->order->setMultiOptions($filterOptions);
		 $searchForm->order->setValue($default_search_type);
	 }
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm
            ->setMethod('get')
            ->populate($request->getParams());

    // Video based video browse page work
    $page_id = Engine_Api::_()->sesqa()->getWidgetPageId($this->view->identity);
    if($page_id) {
      $pageName = Engine_Db_Table::getDefaultAdapter()->select()
              ->from('engine4_core_pages', 'name')
              ->where('page_id = ?', $page_id)
              ->limit(1)
              ->query()
              ->fetchColumn();
      if($pageName) {
        $this->view->pageName = $pageName;
        $explode = explode('sesqa_index_', $pageName);
        if(is_numeric($explode[1])) {
          $this->view->page_id = $explode[1];
        }
      }
    }
    // Video based video browse page work
  }
}
