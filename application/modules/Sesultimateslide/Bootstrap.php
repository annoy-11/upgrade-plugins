<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Bootstrap.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesultimateslide_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesultimateslide/controllers/Checklicense.php';
  }
}
