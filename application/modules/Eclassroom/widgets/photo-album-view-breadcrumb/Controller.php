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

class Eclassroom_Widget_PhotoAlbumViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->album = $album = Engine_Api::_()->core()->getSubject();
    $classroom_id = $album->classroom_id;
    if(!$album->getIdentity())
      return $this->setNoRender();
    $this->view->classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
	}
}
