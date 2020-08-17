<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbstyle_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
	public function __construct($application) {
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesfbstyle_Plugin_Core);
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700" rel="stylesheet');
	}
	
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesfbstyle/controllers/Checklicense.php';
  }
}