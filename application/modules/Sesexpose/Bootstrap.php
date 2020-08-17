<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesexpose_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {

        parent::__construct($application);
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sesexpose_Plugin_Core);
	}
}
