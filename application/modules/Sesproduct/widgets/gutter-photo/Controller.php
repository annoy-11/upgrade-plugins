<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "About Me");
    $this->getElement()->removeDecorator('Title');
    // Only sesproduct or user as subject
    if( Engine_Api::_()->core()->hasSubject('sesproduct') ) {
      $this->view->user_description_limit = $this->_getParam('user_description_limit', 150);
      $this->view->sesproduct = $sesproduct = Engine_Api::_()->core()->getSubject('sesproduct');
      $this->view->owner = $owner = $sesproduct->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->sesproduct = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
  }
}
