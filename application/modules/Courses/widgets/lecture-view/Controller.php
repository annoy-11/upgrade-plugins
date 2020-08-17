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

class Courses_Widget_LectureViewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
      $request = Zend_Controller_Front::getInstance()->getRequest();
      $this->view->lecture_id = $lecture_id = $request->getParam('lecture_id', '0');
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
      $this->view->lecture  = $lecture =  Engine_Api::_()->getItem('courses_lecture',$lecture_id);
      $this->view->isPurchesed = $isPurchesed =  Engine_Api::_()->courses()->getUserPurchesedCourse($lecture->course_id);
      if(empty($isPurchesed) && !$lecture->as_preview)
         return $this->setNoRender();
      if ($lecture->type == "internal" && $lecture->status == 1) { 
        if (!empty($lecture->file_id)) {
          $storage_file = Engine_Api::_()->getItem('storage_file', $lecture->file_id);
          if ($storage_file) { 
            $this->view->lecture_location = $storage_file->map();
          }
        }
      }
  }
}
