<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sessocialshare_Plugin_Core);
  }
	
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sessocialshare/controllers/Checklicense.php';
  }
}