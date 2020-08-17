<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Courses
 * @package    Courses
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Courses_Widget_CourseProfileEarningsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('course_id', null);
    $course_id = Engine_Api::_()->getDbTable('courses', 'courses')->getCourseId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->course = $course = Engine_Api::_()->getItem('courses', $course_id);
    else
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    if(empty($course))
      return $this->setNoRender();
      
    $this->view->daily = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseOrderReport(array('course_id' => $course->course_id,'type'=>'daily','earning'=>true));
    $this->view->weekly = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseOrderReport(array('course_id' => $course->course_id,'type'=>'weekly','earning'=>true));
    $this->view->monthly = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseOrderReport(array('course_id' => $course->course_id,'type'=>'monthly','earning'=>true));
    $this->view->yearly = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseOrderReport(array('course_id' => $course->course_id,'type'=>'yearly','earning'=>true));
  }
}
