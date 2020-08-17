<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Widget_LandingPageWidgetController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->sidebarimage = $this->_getParam('sidebarimage', '');
    $this->view->titleheading = $this->_getParam('titleheading', '');
    $this->view->description = $this->_getParam('description', '');
    $this->view->buttontext = $this->_getParam('buttontext', '');
    $this->view->buttonlink = $this->_getParam('buttonlink', '');
  }

}
