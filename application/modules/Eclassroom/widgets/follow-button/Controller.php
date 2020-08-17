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


class Eclassroom_Widget_FollowButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer_id = $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewerId))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('classroom'))
      return $this->setNoRender();
    $this->view->subject = $classroom = Engine_Api::_()->core()->getSubject('classroom');
    if ($classroom->owner_id == $viewerId || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.follow', 1))
      return $this->setNoRender();

  }

}
