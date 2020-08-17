<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  protected function _initFrontController() {

		$this->initViewHelperPath();

		$this->initActionHelperPath() ;
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Seserror_Plugin_Core);

		Zend_Controller_Action_HelperBroker::addHelper( new Seserror_Controller_Action_Helper_Errors() ) ;
  }
}