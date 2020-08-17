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

class Eclassroom_Widget_ProfileMainPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('classroom')) {
      return $this->setNoRender();
    }
    // Prepare data
    $this->view->classroom = Engine_Api::_()->core()->getSubject();
    $this->view->limit_data = $limit_data = $this->_getParam('limit_data',5);
    $this->view->height = $height = $this->_getParam('height',230);
     $this->view->width = $width = $this->_getParam('width',260);
    $show_criterias = $this->_getParam('criteria', array('photo','title','classroomUrl','tab'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
  }

}
