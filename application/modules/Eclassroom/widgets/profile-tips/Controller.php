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

class Eclassroom_Widget_ProfileTipsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $subject = Engine_Api::_()->core()->getSubject();
    if($subject->getType() != "classroom")
      return $this->setNoRender();
    $this->view->title = $this->_getParam('title','');
    $this->view->description = $this->_getParam('description','');
    $this->view->types = $this->_getParam('types',array('addLocation','addCover','addProfilePhoto'));
    $this->view->classroom = $subject;
    $this->view->canEdit = $canEdit = Engine_Api::_()->authorization()->isAllowed('eclassroom', Engine_Api::_()->user()->getViewer(), 'edit');
    $counter = 0;
    if(!$subject->location){
      $counter = 1;
      $this->view->location = true;
    }
    if(!$subject->photo_id){
      $counter++;
      $this->view->mainphoto = true;
    }
    if(!$subject->cover){
      $counter++;
      $this->view->coverphoto = true;
    }
    if(!count($this->view->types) || !$this->view->types || !$canEdit || !$counter)
      $this->setNoRender();
	}
}
