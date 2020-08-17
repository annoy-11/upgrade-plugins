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

class Courses_Widget_ProfileLecturesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('course_id', null);
    $course_id = Engine_Api::_()->getDbTable('courses', 'courses')->getCourseId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->course = $course = Engine_Api::_()->getItem('courses', $course_id);
    else
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    if(empty($course))
      return $this->setNoRender();
    $limit_data = $this->_getParam('limit_data',20);
    $value['course_id'] = $course_id;
    $paginator = Engine_Api::_()->getDbTable('lectures', 'courses')->getLecturesPaginator($value,array('title','course_id','lecture_id','as_preview','duration','photo_id','owner_id'));
    $this->view->isPurchesed = Engine_Api::_()->courses()->getUserPurchesedCourse($course_id);
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
    else {
      // Do not render if nothing to show
      if ($paginator->getTotalItemCount() <= 0) {
        return $this->setNoRender();
      }
    }
  }
}
