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

class Eclassroom_Widget_PhotoViewBreadcrumbController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
        $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();
        $classroom_id = $photo->classroom_id;
        $album_id = $photo->album_id;
        if(!$photo->getIdentity())
        return $this->setNoRender();
        $this->view->album = Engine_Api::_()->getItem('eclassroom_album', $album_id);
        $this->view->classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
	}
}
