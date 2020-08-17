<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_ProfileActionButtonController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if($this->_getParam('stores')){
     $subject = Engine_Api::_()->getItemByGuid($this->_getParam('stores'));
    }else  if($this->_getParam('page')){
        $subject = Engine_Api::_()->getItemByGuid($this->_getParam('page'));
    }else{
     $subject = Engine_Api::_()->core()->getSubject();
    }
    $allowed = false;
    if (ESTOREPACKAGE == 1) {
      if (isset($subject)) {
        $package = Engine_Api::_()->getItem('estorepackage_package', $subject->package_id);
      }
      if (!isset($package)) {
        $packageId = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getDefaultPackage();
        $package = Engine_Api::_()->getItem('estorepackage_package', $packageId);
      }
      $params = json_decode($package->params, true);
      if (!empty($params['auth_addbutton'])) {
          $allowed = true;
      }
    }

    $this->view->identity = $this->_getParam('identity',$this->view->identity);
    if($subject->getType() != "stores")
      return $this->setNoRender();
    $this->view->subject = $subject;
    $this->view->addButton = (ESTOREPACKAGE == 1) ? $allowed : Engine_Api::_()->authorization()->isAllowed('stores', $this->viewer(), 'auth_addbutton');
    $canCall = Engine_Api::_()->getDbTable('callactions','estore')->getCallactions(array('store_id'=>$subject->getIdentity()));
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
