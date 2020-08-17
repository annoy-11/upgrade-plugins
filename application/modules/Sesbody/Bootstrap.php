<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbody_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesbody/controllers/Checklicense.php';
  }
}
