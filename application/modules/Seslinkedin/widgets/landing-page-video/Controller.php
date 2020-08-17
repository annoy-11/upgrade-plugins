<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seslinkedin_Widget_LandingPageVideoController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
     $this->view->title = $this->_getParam('title');
     $this->view->description = $this->_getParam('description');
     $this->view->video = $this->_getParam('video');
     $this->view->embedCode = $this->_getParam('embedCode');
     $this->view->video_type = $this->_getParam('video_type');
     $this->getElement()->removeDecorator('Title');
  }
}
