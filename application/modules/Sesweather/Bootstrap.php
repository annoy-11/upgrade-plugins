<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesweather_Bootstrap extends Engine_Application_Bootstrap_Abstract
{

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesweather/controllers/Checklicense.php';
  }
}
