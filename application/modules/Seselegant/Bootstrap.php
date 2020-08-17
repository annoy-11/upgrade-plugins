<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seselegant_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {

    parent::__construct($application);
    
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Seselegant_Plugin_Core);
    
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headMeta()->appendName('viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0');
    $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800');
		$view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic');
	}
}