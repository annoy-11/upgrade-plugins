<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "About Me");
    $this->getElement()->removeDecorator('Title');

    // Only edocument or user as subject
    if(Engine_Api::_()->core()->hasSubject('edocument')) {
      $this->view->user_description_limit = $this->_getParam('user_description_limit', 150);
      $this->view->edocument = Engine_Api::_()->core()->getSubject('edocument');
      $this->view->owner = $this->view->edocument->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user')) {
      $this->view->edocument = null;
      $this->view->owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
  }
}
