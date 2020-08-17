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

class Courses_Widget_CourseProfileOptionsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Only courses or user as subject
    if( Engine_Api::_()->core()->hasSubject('courses') ) {
      $this->view->courses = $courses = Engine_Api::_()->core()->getSubject('courses');
      $this->view->owner = $owner = $courses->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->courses = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('courses_gutter');
  }
}
