<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesmenu/controllers/Checklicense.php';
  }
}
