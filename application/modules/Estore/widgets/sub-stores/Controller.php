<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_SubStoresController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $storeId = (isset($_POST['store_id']) ? $_POST['store_id'] : 0);
    if ($storeId) {
      $subject = Engine_Api::_()->getItem('stores', $storeId);
    } else {
      $subject = Engine_Api::_()->core()->getSubject('stores');
      if (!$subject) {
        return $this->setNoRender();
      }
    }
    $this->view->store_id = $subject->store_id;

    $getParams = '';
    $searchArray = array();
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    else {
      $getParams = !empty($_POST['getParams']) ? $_POST['getParams'] : $_SERVER['QUERY_STRING'];
      parse_str($getParams, $get_array);
    }
    $this->view->getParams = $getParams;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->width_pinboard = $this->_getParam('width_pinboard' , 230);
    $this->view->height_pinboard = $this->_getParam('height_pinboard', 230);

    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($widgetId);
    if (!$is_ajax) {
      $defaultSearchParams = Engine_Api::_()->estore()->getSearchWidgetParams($widgetId);
      if ($defaultSearchParams) {
        $params['show'] = isset($defaultSearchParams['default_view_search_type']) ? $defaultSearchParams['default_view_search_type'] : '';
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
    $this->view->view_type = $viewType = isset($_POST['type']) ? $_POST['type'] : (count($params['enableTabs']) > 1 ? $params['openViewType'] : $params['enableTabs'][0]);
    $limit_data = $params["limit_data_$viewType"];
    $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
    if (count($optionsEnable) > 1) {
      $this->view->bothViewEnable = true;
    }
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->widgetName = 'sub-stores';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $value = array();
    $value['status'] = 1;
    $value['search'] = 1;
    $value['draft'] = "1";
    $value['parent_id'] = $subject->store_id;
    if (isset($params['search']))
      $params['text'] = addslashes($params['search']);
    $params['tag'] = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
    $params = array_merge($params, $value);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('stores', 'estore')
            ->getStorePaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber ($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
