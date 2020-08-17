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

class Courses_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
   $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
   $course_id = Engine_Api::_()->getDbTable('courses', 'courses')->getCourseId($searchParams['course_id']);
   if (!Engine_Api::_()->core()->hasSubject())
       $course = Engine_Api::_()->getItem('courses', $course_id);
    else
      $course = Engine_Api::_()->core()->getSubject();
    $courses_browse = Zend_Registry::isRegistered('courses_browse') ? Zend_Registry::get('courses_browse') : null;
    if(empty($courses_browse))
      return $this->setNoRender();
    if (!$course)
      return $this->setNoRender();
     $this->view->subject = $course;
  }

}
