<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  protected function _initFrontController() {
	  include APPLICATION_PATH . '/application/modules/Sesdemouser/controllers/Checklicense.php';
  }
}