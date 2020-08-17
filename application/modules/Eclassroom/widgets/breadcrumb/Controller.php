<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
  $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
   $classroom_id = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomId($searchParams['classroom_id']);
   if (!Engine_Api::_()->core()->hasSubject())
       $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
    else
      $classroom = Engine_Api::_()->core()->getSubject();
    if (!$classroom)
      return $this->setNoRender();
     $this->view->subject = $classroom;
  }
}
