<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesmemveroth/controllers/Checklicense.php';
  }
}
