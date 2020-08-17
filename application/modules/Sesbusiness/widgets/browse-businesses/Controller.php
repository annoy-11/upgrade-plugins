<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Widget_BrowseBusinessesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    
    $getParams = '';
    $searchArray = array();
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    else {
      $getParams = !empty($_POST['getParams']) ? $_POST['getParams'] : $_SERVER['QUERY_STRING'];
      parse_str($getParams, $get_array);
      if($moduleName == 'core')
        $tag_id = Engine_Api::_()->getDbTable('tags', 'core')->getTagId($get_array['search']);
    }
    $this->view->getParams = $getParams;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;

    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($widgetId);
    $defaultSearchParams = Engine_Api::_()->sesbusiness()->getSearchWidgetParams($widgetId);
    if ($defaultSearchParams) {
      $params['show'] = isset($defaultSearchParams['default_view_search_type'])?$defaultSearchParams['default_view_search_type']:'';
      switch ($defaultSearchParams['default_search_type']) {
        case 'recentlySPcreated':
          $columnValue = 'creation_date';
          break;
        case 'mostSPviewed':
          $columnValue = 'view_count';
          break;
        case 'mostSPliked':
          $columnValue = 'like_count';
          break;
        case 'mostSPcommented':
          $columnValue = 'comment_count';
          break;
        case 'mostSPfavourite':
          $columnValue = 'favourite_count';
          break;
        case 'mostSPfollower':
          $columnValue = 'follow_count';
          break;
        case 'featured':
          $columnValue = 'featured';
          break;
        case 'sponsored':
          $columnValue = 'sponsored';
          break;
        case 'verified':
          $columnValue = 'verified';
          break;
        case 'hot':
          $columnValue = 'hot';
          break;
      }
      $params['sort'] = $columnValue;
    }
    if (isset($get_array)) {
      foreach ($get_array as $key => $getvalue) {
        $params[$key] = $getvalue;
      }
      if (isset($params['tag_id']))
        $params['tag'] = Engine_Api::_()->getItem('core_tag', $params['tag_id'])->text;
    }
    if (isset($_GET['category_id']))
      $params[category_id] = $_GET['category_id'];

    if (isset($_GET['show']) && !empty($_GET['show']))
      $params['show'] = $_GET['show'];
    if (!empty($searchArray)) {
      foreach ($searchArray as $key => $search) {
        $params[$key] = $search;
      }
    }
    $sesbusiness_sesbusinesswidget = Zend_Registry::isRegistered('sesbusiness_sesbusinesswidget') ? Zend_Registry::get('sesbusiness_sesbusinesswidget') : null;
    if(empty($sesbusiness_sesbusinesswidget)) {
      return $this->setNoRender();
    }
    $this->view->view_type = $viewType = isset($_POST['type']) ? $_POST['type'] : (count($params['enableTabs']) > 1 ? $params['openViewType'] : $params['enableTabs'][0]);
    $limit_data = $params["limit_data_$viewType"];
    $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
    if (count($optionsEnable) > 1) {
      $this->view->bothViewEnable = true;
    }
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->widgetName = 'browse-businesses';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $value = array();
    $value['status'] = 1;
    $value['search'] = 1;
    $value['draft'] = "1";
    if (isset($params['search']))
      $params['text'] = addslashes($params['search']);
      if (isset($_POST['query']))
          $params['text'] = addslashes($_POST['query']);
    $params['tag'] = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
    $params = array_merge($params, $value);
    if($tag_id) {
      unset($params['text']);
      $params['tag'] = $tag_id;
    }
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')
            ->getBusinessPaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber ($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
