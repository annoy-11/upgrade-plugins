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

class Courses_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "About Me");
    $this->getElement()->removeDecorator('Title');
    // Only courses or user as subject
    if(Engine_Api::_()->core()->hasSubject()) {
      $this->view->user_description_limit = $this->_getParam('user_description_limit', 150);
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $this->view->owner = $owner = $course->getOwner();
    }else {
      return $this->setNoRender();
    }
  }
}
