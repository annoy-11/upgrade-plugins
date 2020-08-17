<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemoji_IndexController extends Core_Controller_Action_Standard
{
  public function feelingemojiAction() {
    $this->view->edit = $this->_getParam('edit',false);
    $this->renderScript('_feelingemoji.tpl');
  }
  
  public function feelingemojicommentAction() { 
    $this->view->edit = $this->_getParam('edit',false);
    $this->renderScript('_feelingemojicomment.tpl');
  }
}
