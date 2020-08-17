<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesspectromedia_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {
	
    parent::__construct($application);
    
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesspectromedia_Plugin_Core);
	}
	
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesspectromedia/controllers/Checklicense.php';
  }
}
