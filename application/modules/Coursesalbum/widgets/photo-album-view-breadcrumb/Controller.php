<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Coursesalbum_Widget_PhotoAlbumViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->album = $album = Engine_Api::_()->core()->getSubject();
    $course_id = $album->course_id;
    if(!$album->getIdentity())
      return $this->setNoRender();
    $this->view->course = Engine_Api::_()->getItem('courses', $course_id);
	}
}
