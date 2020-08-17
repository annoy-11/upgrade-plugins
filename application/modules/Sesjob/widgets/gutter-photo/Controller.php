<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "About Me");
    $this->getElement()->removeDecorator('Title');
    // Only sesjob or user as subject
    if( Engine_Api::_()->core()->hasSubject('sesjob_job') ) {
      $this->view->user_description_limit = $this->_getParam('user_description_limit', 150);
      $this->view->sesjob = $sesjob = Engine_Api::_()->core()->getSubject('sesjob_job');
      $this->view->owner = $owner = $sesjob->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->sesjob = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
  }
}
