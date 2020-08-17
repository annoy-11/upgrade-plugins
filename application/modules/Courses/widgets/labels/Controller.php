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

class Courses_Widget_LabelsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    if(empty($subject->featured) && empty($subject->sponsored) && empty($subject->verified) && empty($subject->hot))
      return $this->setNoRender();
      

  }
}
