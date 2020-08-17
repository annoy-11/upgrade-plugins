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
class Courses_Widget_WelcomeBannerController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
      $this->view->description = $this->_getParam('description');
      $this->view->heading = $this->_getParam('heading');
      $this->view->button1Title = $this->_getParam('button1Title',"");
      $this->view->button2Title = $this->_getParam('button2Title',"");
      $this->view->button1Link = $this->_getParam('button1Link',"#");
      $this->view->button2Link = $this->_getParam('button2Link',"#");
      $this->view->video = $this->_getParam('video');
      $this->view->embedCode = $this->_getParam('embedCode');
      $this->view->video_type = $this->_getParam('video_type');
      $this->view->image = $this->_getParam('image',"application/modules/Courses/externals/images/welcome-img.png");
    }
}
