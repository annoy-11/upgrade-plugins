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

class Courses_Widget_CourseContactInformationController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('courses');
    if (!$subject) {
      return $this->setNoRender();
    }
    $this->view->info = $this->_getParam('show_criteria',array('name','email','phone','facebook','linkedin','twitter','website','instagram','pinterest'));
    if(!$subject->course_contact_name && !$subject->course_contact_email && !$subject->course_contact_phone && !$subject->course_contact_website && !$subject->course_contact_facebook && !$subject->course_contact_twitter && !$subject->course_contact_linkedin)
        return $this->setNoRender();
    $this->view->subject = $subject;
  }
}
