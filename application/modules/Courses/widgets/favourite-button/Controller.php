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
class Courses_Widget_FavouriteButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->viewer_id = $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewerId))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('courses') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.favourite', 1))
      return $this->setNoRender();
    $this->view->subject = Engine_Api::_()->core()->getSubject('courses');
  }

}
