<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Snsdemo_Widget_MaindemoStripController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  	$this->view->title = $this->_getParam('title', "All Products Demo");
		$this->getElement()->removeDecorator('Title');
    $this->view->themes = Engine_Api::_()->getItemTable('snsdemo_theme')->fetchAll();
    $this->view->allParams = $this->_getAllParams();
    
    $this->view->services = Engine_Api::_()->getItemTable('snsdemo_service')->fetchAll();
	
	}
}
