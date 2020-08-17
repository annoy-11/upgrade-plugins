<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
	public function __construct($application) {

    parent::__construct($application);

    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Seslinkedin_Plugin_Core);

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700" rel="stylesheet');
	}

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Seslinkedin/controllers/Checklicense.php';
  }
}
