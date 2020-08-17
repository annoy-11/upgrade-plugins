<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Widget_ProfileActionButtonController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if($this->_getParam('group')){
     $subject = Engine_Api::_()->getItemByGuid($this->_getParam('group')); 
    }else{
     $subject = Engine_Api::_()->core()->getSubject();
    }
    $this->view->identity = $this->_getParam('identity',$this->view->identity);
    if($subject->getType() != "sesgroup_group")
      return $this->setNoRender();
    $this->view->subject = $subject;
    $canCall = Engine_Api::_()->getDbTable('callactions','sesgroup')->getCallactions(array('group_id'=>$subject->getIdentity()));
    $this->view->canEdit = $canEdit = $subject->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'edit');
    if(!$canEdit && !$canCall)
       return $this->setNoRender();
    if($canCall){
     $this->view->calCall = $this->getType($canCall->type);
      $this->view->callAction = $canCall;
    }
    $this->view->is_ajax = $this->_getParam('is_ajax');
	}
  
  function getType($type){
      switch($type){
        case "booknow":
          return 'Book Now';
        case "callnow":
          return "Call Now";
        case "contactus":
          return "Contact Us";
        case "sendmessage":
          return "Send Message";
        case "signup":
          return "Sign Up";
        case "sendemail":
          return "Send Email";
        case "watchvideo":
          return "Watch Video";
        case "learnmore":
          return "Learn More";
        case "shopnow":
          return "Shop Now";
        case "seeoffers":
          return "See Offers";
        case "useapp":
          return "Use App";
        case "playgames":
          return "Play Games";
      }
      return "";
  }
}
