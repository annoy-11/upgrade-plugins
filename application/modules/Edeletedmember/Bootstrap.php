<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Bootstrap.php 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Edeletedmember_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initFrontController() {
      include APPLICATION_PATH . '/application/modules/Edeletedmember/controllers/Checklicense.php';
  }
}
