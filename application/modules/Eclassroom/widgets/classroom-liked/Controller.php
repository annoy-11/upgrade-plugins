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

class Eclassroom_Widget_ClassroomLikedController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (Engine_Api::_()->core()->hasSubject('classroom'))
      $classroom = Engine_Api::_()->core()->getSubject();
    else
      return $this->setNoRender();
    $viewer = $this->view->viewer();
    $this->view->title = $this->_getParam('title');
    $table = Engine_Api::_()->getDbTable('likeclassrooms','eclassroom');
    $selelct = $table->select()->where('classroom_id =?',$classroom->getIdentity());
    $this->view->result = $result = $table->fetchAll($selelct);
    if(!count($result))
        return $this->setNoRender();
  }

}
