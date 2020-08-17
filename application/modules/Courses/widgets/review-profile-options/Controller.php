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
class Courses_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.review', 1))
      return $this->setNoRender();
    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');

    if (!Engine_Api::_()->core()->hasSubject('courses_review'))
      return $this->setNoRender();

    $review = Engine_Api::_()->core()->getSubject('courses_review');
    $this->view->content_item = $event = Engine_Api::_()->getItem('courses', $review->course_id);
    $this->view->navigation = $coreMenuApi->getNavigation('coursesreview_profile');
  }
}
