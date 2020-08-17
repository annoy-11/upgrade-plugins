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
class Courses_Widget_CourseViewFeaturesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $show_criterias = $this->_getParam('stats',array('duration','lectures','tests','passparcentage'));
   	foreach($show_criterias as $show_criteria)
			$this->view->$show_criteria = $show_criteria;
    if(!$show_criterias)
     return $this->setNoRender();
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->course = $course = Engine_Api::_()->getItem('courses', $course_id);
    else
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
  }
}
