<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Widget_CrossSellCoursesController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $getParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->params = $params = Engine_Api::_()->courses()->getWidgetParams($widgetId);
    $cartData = Engine_Api::_()->courses()->cartTotalPrice();
    if(empty($cartData['cartCourseIds']))
        return $this->setNoRender();
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel','sponsoredLabel','verifiedLabel', 'category', 'favouriteButton','likeButton', 'socialSharing', 'view', 'creationDate', 'readmore'));
    if(is_array($show_criterias)) {
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
    $this->view->show_item_count = $this->_getParam('show_item_count', 1);
    // Get Courses
    $paginator = Engine_Api::_()->getDbtable('courses', 'courses')->getCoursePaginator(array('courseIds'=>implode(",", $cartData['cartCourseIds']),'crosssell'=>true,'manage-widget'=>true,'limit'=>$this->_getParam('limit_data_grid'),'fetchAll'=>true));
    $this->view->paginator = $paginator;
    if($paginator->count() < 1)
       return $this->setNoRender();
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(12);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    $this->view->params = $params;
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
  }
}
