<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Bootstrap extends Engine_Application_Bootstrap_Abstract {
	public function __construct($application) {
	
    parent::__construct($application);
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800');
		$view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Open+Sans:400,700');
		$view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400italic,700,700italic');
		
	}
}
