<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfaq_Bootstrap extends Engine_Application_Bootstrap_Abstract {
	
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesfaq/controllers/Checklicense.php';
  }
}