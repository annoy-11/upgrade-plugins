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


class Eclassroom_Widget_ClassroomPolicyController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject()) {
      return $this->setNoRender();
    }
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $this->view->editPolicy = $editPolicy = $subject->authorization()->isAllowed($viewer, 'edit');
    if (!$editPolicy && (!$subject->term_and_condition || is_null($subject->term_and_condition))) {
      return $this->setNoRender();
    }
  }
}
