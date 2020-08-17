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


class Eclassroom_Widget_ClassroomOverviewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject()) {
      return $this->setNoRender();
    }
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $this->view->editOverview = $editOverview = $subject->authorization()->isAllowed($viewer, 'edit');
    if (!$editOverview && (!$subject->overview || is_null($subject->overview))) {
      return $this->setNoRender();
    }
  }
}
