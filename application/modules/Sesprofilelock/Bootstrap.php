<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initFrontController() {
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesprofilelock_Plugin_Core);
    Zend_Controller_Action_HelperBroker::addHelper(new Sesprofilelock_Controller_Action_Helper_Lock());
    include APPLICATION_PATH . '/application/modules/Sesprofilelock/controllers/Checklicense.php';
  }
}
