<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "About Me");
    $this->getElement()->removeDecorator('Title');
    // Only sesarticle or user as subject
    if( Engine_Api::_()->core()->hasSubject('sesarticle') ) {
      $this->view->user_description_limit = $user_description_limit = $this->_getParam('user_description_limit', 150);
      $this->view->sesarticle = $sesarticle = Engine_Api::_()->core()->getSubject('sesarticle');
      $this->view->owner = $owner = $sesarticle->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->sesarticle = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
  }
}
