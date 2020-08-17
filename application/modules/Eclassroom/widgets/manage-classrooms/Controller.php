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
class Eclassroom_Widget_ManageClassroomsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->loadJs = true;
    $this->view->optionsListGrid = array('tabbed' => true, 'paggindData' => true);
    $this->view->can_create = Engine_Api::_()->authorization()->isAllowed('eclassroom', null, 'create');
    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($widgetId);
    //START WORK FOR TABS
    $defaultOpenTab = array();
    $defaultOptions = $arrayOptions = array();
    $defaultOptionsArray = $params['search_type'];
    $arrayOptn = array();
    if (!$is_ajax && is_array($defaultOptionsArray)) {
      foreach ($defaultOptionsArray as $key => $defaultValue) {
        if ($this->_getParam($defaultValue . '_order'))
          $order = $this->_getParam($defaultValue . '_order');
        else
          $order = (1000 + $key);
        $arrayOptn[$order] = $defaultValue;
        if ($this->_getParam($defaultValue . '_label'))
          $valueLabel = $this->_getParam($defaultValue . '_label');
        else {
          if ($defaultValue == 'recentlySPcreated')
            $valueLabel = 'Recently Created';
          else if ($defaultValue == 'mostSPviewed')
            $valueLabel = 'Most Viewed';
          else if ($defaultValue == 'mostSPliked')
            $valueLabel = 'Most Liked';
          else if ($defaultValue == 'mostSPcommented')
            $valueLabel = 'Most Commented';
          else if ($defaultValue == 'mostSPfollowed')
            $valueLabel = 'Most Followed';
          else if ($defaultValue == 'mostSPjoined')
            $valueLabel = 'Most Joined';
          else if ($defaultValue == 'mostSPfavourite')
            $valueLabel = 'Most Favourited';
          else if ($defaultValue == 'featured')
            $valueLabel = 'Featured';
          else if ($defaultValue == 'sponsored')
            $valueLabel = 'Sponsored';
          else if ($defaultValue == 'verified')
            $valueLabel = 'Verified';
          else if ($defaultValue == 'hot')
            $valueLabel = 'Hot';
          else if ($defaultValue == 'mostSPcourses')
            $valueLabel = 'Courses';
        }
        $arrayOptions[$order] = $valueLabel;
      }
      ksort($arrayOptions);
      $counter = 0;
      foreach ($arrayOptions as $key => $valueOption) {
        //$key = explode('||', $key);
        if ($counter == 0)
          $this->view->defaultOpenTab = $defaultOpenTab = $arrayOptn[$key];
        $defaultOptions[$arrayOptn[$key]] = $valueOption;
        $counter++;
      }
    }
    $this->view->defaultOptions = $defaultOptions;
    //END WORK OF TABS
    if (isset($_GET['openTab']) || $is_ajax) {
      $this->view->defaultOpenTab = $defaultOpenTab = (isset($_GET['openTab']) ? str_replace('_', 'SP', $_GET['openTab']) : ($this->_getParam('openTab') != NULL ? $this->_getParam('openTab') : (isset($params['openTab']) ? $params['openTab'] : '' )));
    }
    switch ($defaultOpenTab) {
      case 'recentlySPcreated':
        $params['sort'] = 'creation_date';
        break;
      case 'mostSPviewed':
        $params['sort'] = 'view_count';
        break;
      case 'mostSPliked':
        $params['sort'] = 'like_count';
        break;
      case 'mostSPcommented':
        $params['sort'] = 'comment_count';
        break;
      case 'mostSPfavourite':
        $params['sort'] = 'favourite_count';
        break;
      case 'mostSPfollowed':
        $params['sort'] = 'follow_count';
        break;
      case 'mostSPjoined':
        $params['sort'] = 'member_count';
        break;
      case 'mostSPrated':
        $params['sort'] = 'rating';
        break;
      case 'featured':
        $params['sort'] = 'featured';
        break;
      case 'sponsored':
        $params['sort'] = 'sponsored';
        break;
      case 'verified':
        $params['sort'] = 'verified';
        break;
      case 'hot':
        $params['sort'] = 'hot';
        break;
      case 'mostSPcourses':
        $params['sort'] = 'course_count';
        break;
      default:
      $params['sort'] = 'creation_date';
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
    $this->view->widgetName = 'manage-classrooms';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $value = array();
    $value['widgetManage'] = 1;
    $params = array_merge($params, $value);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')
            ->getClassroomPaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber ($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
