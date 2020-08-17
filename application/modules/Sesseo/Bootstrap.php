<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
	public function __construct($application)
	{
		parent::__construct($application);
		$this->initViewHelperPath();
	}
	
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesseo/controllers/Checklicense.php';
  }

}
