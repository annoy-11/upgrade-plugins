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

class Courses_Widget_CourseCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');
    $params['criteria'] = $this->_getParam('criteria', '');
		$params['limit'] = $this->_getParam('limit', 0);
		$params['course_required'] = $this->_getParam('course_required',0);
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countCourses', 'icon'));
    if (in_array('countCourses', $show_criterias))
      $params['countCourses'] = true;
		if($params['course_required'])
			$params['courseRequired'] = true;
		$this->view->show_criterias = $show_criterias;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    // Get videos
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'courses')->getCategory($params);
    if (count($paginator) == 0)
      return;
  }

}
