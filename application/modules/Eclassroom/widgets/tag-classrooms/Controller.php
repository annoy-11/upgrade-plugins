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

class Eclassroom_Widget_tagClassroomsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->widgetbgcolor = $this->_getParam('widgetbgcolor', '424242');
    $this->view->buttonbgcolor = $this->_getParam('buttonbgcolor', '000000');
    $this->view->textcolor = $this->_getParam('textcolor', 'ffffff');
    $show_count = $this->_getParam('show_count', 25);
    
    $this->view->tagCloudData  = Engine_Api::_()->eclassroom()->tagCloudItemCore('fetchAll','',$show_count);
    if( count($this->view->tagCloudData) <= 0 )
    return $this->setNoRender();
  }
}
