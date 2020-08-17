<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_GutterPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if(!Engine_Api::_()->core()->hasSubject('eblog_blog'))
      return $this->setNoRender();
    
    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "About Me");
    $this->getElement()->removeDecorator('Title');

    $this->view->owner = Engine_Api::_()->core()->getSubject('eblog_blog')->getOwner();
  }
}
