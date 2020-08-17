<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Widget_PrivateController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->showsearch = $this->_getParam('showsearch', 1);
    $this->view->showhomebutton = $this->_getParam('showhomebutton', 1);
    $this->view->showbackbutton = $this->_getParam('showbackbutton', 1);
    
    $this->view->privatepagephotoID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.privatepagephotoID', 0);
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->default_activate = $settings->getSetting('seserror.privatepageactivate', 1);
    $this->view->text1 = $settings->getSetting('seserror.privatepagetext1', "Private Page");
    $this->view->text2 = $settings->getSetting('seserror.privatepagetext2', "Don''t Try To Make Over Smart");
    $this->view->text3 = $settings->getSetting('seserror.privatepagetext3', "This Is A Private Page Go To Another Page And Search Other Thing");
    $privateenable = $settings->getSetting('seserror.privateenable', 1);
    if(empty($privateenable))
      return $this->setNoRender();
  }
}