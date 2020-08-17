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
class Eclassroom_Widget_BrowseClassroomsController extends Engine_Content_Widget_Abstract {

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
        $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($widgetId);
        $defaultSearchParams = Engine_Api::_()->eclassroom()->getSearchWidgetParams($widgetId);
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
        $this->view->view_type = $viewType = isset($_POST['type']) ? $_POST['type'] : (count($params['enableTabs']) > 1 ? $params['openViewType'] : $params['enableTabs'][0]);
        $limit_data = $params["limit_data_$viewType"] ? $params["limit_data_$viewType"] : 1;
        $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
        $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
        if(empty($courses_widgets))
          return $this->setNoRender();
        $show_criterias = $params['show_criteria'];
        foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;

        if (isset($_GET['category_id']))
            $params[category_id] = $_GET['category_id'];
        $this->view->widgetName = 'browse-classrooms';
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $this->view->page = $page;
        $value = array();
        $value['status'] = 1;
        $value['search'] = 1;
        $value['draft'] = "1";
        if (isset($searchArray['search']))
            $params['text'] = addslashes($searchArray['search']);
        $params['tag'] = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
        $params['alphabet'] = isset($_GET['alphabet']) ? $_GET['alphabet'] : '';
        $params = array_merge($params, $value,$searchArray);
        $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')
            ->getClassroomPaginator($params);
        $paginator->setItemCountPerPage($limit_data);
        $paginator->setCurrentPageNumber ($page);
        if ($is_ajax) {
            $this->getElement()->removeDecorator('Container');
        }
    }
}
