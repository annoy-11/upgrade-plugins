<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {

    parent::__construct($application);

    Zend_Controller_Front::getInstance()->registerPlugin(new Sestwitterclone_Plugin_Core);

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700" rel="stylesheet');
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sestwitterclone/controllers/Checklicense.php';
  }
}
