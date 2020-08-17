<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ManageController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Eclassroom_ManageController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('classroom', null, 'view')->isValid())
      return;
  }
  public function myClassroomAction(){
     $this->_helper->content->setEnabled();
    if (!$this->_helper->requireUser()->isValid())
      return;
    // Render
    $this->_helper->content->setEnabled();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('eclassroom', null, 'create')->checkRequire();
  }
}
