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
class Courses_Widget_WelcomeFeaturesBlockController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
      $this->view->description = $this->_getParam('description',""); 
      $this->view->heading = $this->_getParam('heading',"");
      $this->view->headingText = $this->_getParam('headingText',"");
      
      $this->view->buttonTitle = $this->_getParam('buttonTitle',"");
      $this->view->buttonLink = $this->_getParam('buttonLink',"");
      
      $this->view->block1title = $this->_getParam('block1title',"");
      $this->view->block1Text = $this->_getParam('block1Text',"");
      $this->view->image1 = $this->_getParam('image1',"application/modules/Courses/externals/images/feature1.png");
      
      $this->view->block2title = $this->_getParam('block2title',"");
      $this->view->block2Text = $this->_getParam('block2Text',"");
      $this->view->image2 = $this->_getParam('image2',"application/modules/Courses/externals/images/feature2.png");
      
      $this->view->block3title = $this->_getParam('block3title',"");
      $this->view->block3Text = $this->_getParam('block3Text',"");
      $this->view->image3 = $this->_getParam('image3',"application/modules/Courses/externals/images/feature3.png");
      
      $this->view->block4title = $this->_getParam('block4title',"");
      $this->view->block4Text = $this->_getParam('block4Text',"");
      $this->view->image4 = $this->_getParam('image4',"application/modules/Courses/externals/images/feature4.png");

  }
}
