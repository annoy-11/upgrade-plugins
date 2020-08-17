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
class Courses_Widget_WelcomeStripController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
      $this->view->heading2 = $this->_getParam('heading2',"");
      $this->view->heading1 = $this->_getParam('heading1',"");
      $this->view->buttonTitle = $this->_getParam('buttonTitle',"");
      $this->view->buttonLink = $this->_getParam('buttonLink',"#");
     
  }
}
