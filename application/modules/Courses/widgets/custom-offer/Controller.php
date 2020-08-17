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

class Courses_Widget_CustomOfferController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->design = $design = $this->_getParam('design', 'design1');
    $this->view->offer_id = $offer_id = $this->_getParam('offer_id', 0);
    $this->view->heading = $heading = $this->_getParam('heading', '');
    $this->view->show_timer = $show_timer = $this->_getParam('show_timer', 'yes');
    $this->view->itemCount = $itemCount = $this->_getParam('itemCount', 3);
    $this->view->button_title = $button_title = $this->_getParam('button_title', '');
    $this->view->width = $width = $this->_getParam('width', 3);
    $this->view->height = $height = $this->_getParam('height', '');
    // Get courses
     $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'courses')->getSlides($offer_id,'',true,array('limit'=>$itemCount));
  }
}
