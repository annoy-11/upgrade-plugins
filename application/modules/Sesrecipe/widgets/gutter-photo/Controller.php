<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "About Me");
    $this->getElement()->removeDecorator('Title');
    // Only sesrecipe or user as subject
    if( Engine_Api::_()->core()->hasSubject('sesrecipe_recipe') ) {
      $this->view->user_description_limit = $this->_getParam('user_description_limit', 150);
      $this->view->sesrecipe = $sesrecipe = Engine_Api::_()->core()->getSubject('sesrecipe_recipe');
      $this->view->owner = $owner = $sesrecipe->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->sesrecipe = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
  }
}
