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

class Courses_Widget_CourseSocialshareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('course_id', null);
    $this->view->design_type = $this->_getParam('socialshare_design', 1);
    $course_id = Engine_Api::_()->getDbtable('courses', 'courses')->getCourseId($id);
    if(!Engine_Api::_()->core()->hasSubject())
      $courses = Engine_Api::_()->getItem('courses', $product_id);
    else
      $courses  = Engine_Api::_()->core()->getSubject();
    if(!$courses)
        return $this->setNoRender();
    $this->view->courses = $courses;
  }
}
