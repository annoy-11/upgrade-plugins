<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id ErrorController.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_ErrorController extends Core_Controller_Action_Standard {

  public function indexAction() {
    $this->_helper->content->setEnabled();
  }

  public function viewAction() {
    $this->_helper->content->setEnabled();
  }

  public function comingsoonAction() {
    $this->_helper->content->setEnabled();
  }
}
