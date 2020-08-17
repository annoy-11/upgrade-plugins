<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Bootstrap.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
    parent::__construct($application);
    Zend_Controller_Front::getInstance()->registerPlugin(new Einstaclone_Plugin_Core);
  }
    
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Einstaclone/controllers/Checklicense.php';
  }
}
