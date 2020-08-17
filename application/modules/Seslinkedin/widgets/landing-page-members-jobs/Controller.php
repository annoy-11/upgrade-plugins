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


class Seslinkedin_Widget_LandingPageMembersJobsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
        $this->getElement()->removeDecorator('Title');

        $this->view->fe1img = $this->_getParam('fe1img');
        $this->view->fe1heading = $this->_getParam('fe1heading');
        $this->view->fe1buttonText = $this->_getParam('fe1buttonText');
        $this->view->fe1buttonUrl = $this->_getParam('fe1buttonUrl');

        $this->view->fe2heading = $this->_getParam('fe2heading');
        $this->view->fe2img = $this->_getParam('fe2img');
        $this->view->fe2buttonText = $this->_getParam('fe2buttonText');
        $this->view->fe2buttonUrl = $this->_getParam('fe2buttonUrl');
  }
}
