<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessoffer_Widget_BrowseOffersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
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
    $sesbusinessoffer_widget = Zend_Registry::isRegistered('sesbusinessoffer_widget') ? Zend_Registry::get('sesbusinessoffer_widget') : null;
    if(empty($sesbusinessoffer_widget))
      return $this->setNoRender();
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
        case 'featured':
          $columnValue = 'featured';
          break;
        case 'sponsored':
          $columnValue = 'sponsored';
          break;
      }
      $params['sort'] = $columnValue;
    }
    if (isset($get_array)) {
      foreach ($get_array as $key => $getvalue) {
        $params[$key] = $getvalue;
      }
    }

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

    $this->view->widgetName = 'browse-offers';
    $business = isset($_POST['business']) ? $_POST['business'] : 1;
    $this->view->business = $business;

    if (isset($params['search']))
      $params['text'] = addslashes($params['search']);
      if (isset($_POST['search']))
          $params['text'] = addslashes($_POST['search']);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businessoffers', 'sesbusinessoffer')
            ->getOffersPaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($business);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
