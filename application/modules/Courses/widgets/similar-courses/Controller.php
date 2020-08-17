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

class Courses_Widget_SimilarCoursesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $params = Engine_Api::_()->courses()->getWidgetParams($widgetId);
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $identity = $view->identity;
    $this->view->widgetIdentity = $this->_getParam('content_id', $identity);
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    if (!$is_ajax) {
      if (!Engine_Api::_()->core()->hasSubject())
        return $this->setNoRender();
      //Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      $category_id = $subject->category_id;
      if(!$category_id)
        return $this->setNoRender();
    } else if($is_ajax){
      $subject = Engine_Api::_()->getItem('courses', $params['course_id']);
      $category_id = $params['category_id'];
      if(!$category_id)
          return $this->setNoRender();
    }
    if ($this->_getParam('showLimitData', 1))
        $this->view->widgetName = 'similar-courses';
    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon =isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $socialshare_icon_limit =isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);
    $this->view->height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '264');
    $this->view->width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '262');
    $this->view->title_truncation_limit = isset($params['title_truncation_limit']) ? $params['title_truncation_limit'] : $this->_getParam('title_truncation_limit', '45');
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'verifiedLabel', 'rating', 'favourite','category','favouriteButton','likeButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $limit = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', 3);
    $this->view->params = array('show_criterias' => $show_criterias, 'limit_data' => $limit, 'category_id' => $category_id, 'title_truncation_list' => $this->view->title_truncation_list, 'height' => $this->view->height, 'width' => $this->view->width, 'socialshare_enable_plusicon' => $socialshare_enable_plusicon, 'socialshare_icon_limit' => $socialshare_icon_limit);
    $value['category_id'] = $category_id;
    $value['widgetName'] = 'Similar Courses';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('courses', 'courses')->getCoursePaginator($value);
    $paginator->setItemCountPerPage($limit);
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    if ($paginator->getTotalItemCount() <= 0)
		return $this->setNoRender();
    if ($is_ajax)
		$this->getElement()->removeDecorator('Container');

  }
}
