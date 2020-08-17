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
class Courses_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->bannerImage = $this->_getParam('courses_categorycover_photo');
    $this->view->description = $this->_getParam('description', '');
    $this->view->title = $this->_getParam('title', '');
    $this->view->params = $params = Engine_Api::_()->courses()->getWidgetParams($this->view->identity);
    $value = array();
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
    $value['order'] = $params['order'];
    $value['info'] = $params['info'];
    $this->view->paginator = array();
    if ($params['show_popular_courses']) {
      $this->view->paginator = Engine_Api::_()->getDbTable('courses', 'courses')
              ->getCourseSelect(array_merge($value, array('search' => 1, 'fetchAll' => true, 'limit' => 3)));
    }
  }

}
