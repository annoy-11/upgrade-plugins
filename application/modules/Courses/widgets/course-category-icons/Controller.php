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

class Courses_Widget_CourseCategoryIconsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countCourses', 'icon'));
    if (in_array('countCourses', $show_criterias) || $params['criteria'] == 'most_product')
      $params['countCourses'] = true;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
		$params['limit'] = $this->_getParam('limit_data',10);
    // Get products category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'courses')->getCategory($params);
    if (count($paginator) == 0)
      return;
  }
}
