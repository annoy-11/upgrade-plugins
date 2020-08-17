<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Subscriptionbadge
 * @package    Subscriptionbadge
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Subscriptionbadge_Bootstrap extends Engine_Application_Bootstrap_Abstract
{

  protected function _initFrontController() {
      include APPLICATION_PATH . '/application/modules/Subscriptionbadge/controllers/Checklicense.php';
  }
}
