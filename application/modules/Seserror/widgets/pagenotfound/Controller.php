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

class Seserror_Widget_PagenotfoundController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->showsearch = $this->_getParam('showsearch', 1);
    $this->view->showhomebutton = $this->_getParam('showhomebutton', 1);
    $this->view->showbackbutton = $this->_getParam('showbackbutton', 1);
    
    $this->view->pagenotfoundphotoID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfoundphotoID', 0);

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->default_activate = $settings->getSetting('seserror.pagenotfoundactivate', 1);
    $this->view->text1 = $settings->getSetting('seserror.pagenotfoundenabletext1', "OOPS!");
    $this->view->text2 = $settings->getSetting('seserror.pagenotfoundenabletext2', "Error 404 :Page Not Found");
    $this->view->text3 = $settings->getSetting('seserror.pagenotfoundenabletext3', "Rather search for something else?");
    $enable = $settings->getSetting('seserror.pagenotfoundenable', 1);
    if(empty($enable))
      return $this->setNoRender();
  }

}
