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


class Seslinkedin_Widget_LandingPagePostJobController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->getElement()->removeDecorator('Title');
    $this->view->heading = $this->_getParam('heading');
    $this->view->buttonText = $this->_getParam('buttonText');
    $this->view->buttonUrl = $this->_getParam('buttonUrl');
    $this->view->image = $this->_getParam('image');
  }
}
