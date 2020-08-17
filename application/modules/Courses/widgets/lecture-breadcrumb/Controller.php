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

class Courses_Widget_LectureBreadcrumbController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->title = $this->_getParam('showTitle', 1);
    if (Engine_Api::_()->core()->hasSubject('courses_lecture'))
      $item = Engine_Api::_()->core()->getSubject('courses_lecture');
    $this->view->subject = $item;
    if (!$item)
      return $this->setNoRender();
  }
}
