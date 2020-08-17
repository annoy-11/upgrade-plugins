<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessveroth
 * @package    Sesbusinessveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessveroth_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesbusinessveroth/controllers/Checklicense.php';
  }
}
