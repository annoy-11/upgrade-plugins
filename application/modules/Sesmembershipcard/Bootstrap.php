<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershipcard_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {

    parent::__construct($application);

    // Add view helper and action helper paths
    $this->initViewHelperPath();
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesmembershipcard/controllers/Checklicense.php';
  }
}
