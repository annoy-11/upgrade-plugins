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
class Eclassroom_Widget_CategoryAssociateClassroomsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->widgetName = 'category-associate-classrooms';
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($widgetId);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $show_category_criterias = $params['show_category_criteria'];
    foreach ($show_category_criterias as $show_category_criteria)
      $this->view->{$show_category_criteria . 'Active'} = $show_category_criteria;
    $this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategory(array('hasClassroom' => true, 'criteria' => $params['criteria'], 'order' => $params['popularty'],'paginator' => 'yes'));
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $paginatorCategory->setItemCountPerPage($params['category_limit']);
    $paginatorCategory->setCurrentPageNumber ($page);
    if ($paginatorCategory->getTotalItemCount() > 0) {
      foreach ($paginatorCategory as $key => $valuePaginator) {
        $countArray[] = $valuePaginator->total_classroom_categories;
        $pageData['classroom_data'][$valuePaginator->category_id] = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomSelect(array('category_id' => $valuePaginator->category_id, 'limit' => $params['classroom_limit'], 'order' => $params['popularty'], 'info' => $params['order'], 'fetchAll' => true));
      }
    } else {
      if (!$is_ajax)
        return $this->setNoRender();
    }
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
    $this->view->countArray = $countArray;
    $this->view->resultArray = $pageData;
    // Set item count per page and current page number
    $this->view->page = $page;
    $this->view->paginatorCategory = $paginatorCategory;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
