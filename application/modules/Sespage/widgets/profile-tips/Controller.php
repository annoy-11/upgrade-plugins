<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 

class Sespage_Widget_ProfileTipsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $subject = Engine_Api::_()->core()->getSubject();
    if($subject->getType() != "sespage_page")
      return $this->setNoRender();
    $this->view->title = $this->_getParam('title','');
    $this->view->description = $this->_getParam('description','');
    $this->view->types = $this->_getParam('types',array('addLocation','addCover','addProfilePhoto'));
    $this->view->page = $subject;
    $this->view->canEdit = $canEdit = $subject->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'edit');
    
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
