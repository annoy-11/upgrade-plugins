<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Loader.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecometchatapi_Plugin_Loader extends Zend_Controller_Plugin_Abstract {

  public function preDispatch(Zend_Controller_Request_Abstract $request) {
    $loader = Engine_Loader::getInstance();
    if (get_class($loader) == 'Engine_Loader') {
        Ecometchatapi_Loader::hook();
    }
  }

}
