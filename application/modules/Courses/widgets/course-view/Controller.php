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
class Courses_Widget_CourseViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
     $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('course_id', null);
    $course_id = Engine_Api::_()->getDbTable('courses', 'courses')->getCourseId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->course = $course = Engine_Api::_()->getItem('courses', $course_id);
    else
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $courseTable = Engine_Api::_()->getDbtable('courses', 'courses');
    $owner = $course->getOwner();
    if( !$course->isOwner($viewer) ) {
        $courseTable->update(array(
            'view_count' => new Zend_Db_Expr('view_count + 1'),
        ), array(
            'course_id = ?' => $course->getIdentity(),
        ));
    }
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
    $paymentGateways = Engine_Api::_()->courses()->checkPaymentGatewayEnable();
    $this->view->noPaymentGatewayEnableByAdmin = false;
    if(!empty($paymentGateways['noPaymentGatewayEnableByAdmin'])){
        $this->view->noPaymentGatewayEnableByAdmin = true;
    }
    $this->view->paymentMethods = @$paymentGateways['methods'];
    $this->view->params = $params = Engine_Api::_()->courses()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    // Get category
    if (!empty($course->category_id))
    $this->view->category = Engine_Api::_()->getDbTable('categories', 'courses')->find($course->category_id)->current();
    $this->view->courseTags = $course->tags()->getTagMaps();
    $this->view->canComment = $course->authorization()->isAllowed($viewer, 'comment');
  }
}
