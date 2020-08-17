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

class Ecometchatapi_Loader extends Engine_Loader {

  static $_hooked = false;
  var $_loader;

  public static function hook() {
    if (self::$_hooked) {
      return;
    }
    self::$_hooked = true;

    new self();
  }

  public function __construct() {
    $this->_loader = Engine_Loader::getInstance();
    Engine_Loader::setInstance($this);

    $this->_prefixToPaths = $this->_loader->_prefixToPaths;
    $this->_components = $this->_loader->_components;
  }

  public function load($class) {
    if ($class == 'User_Model_DbTable_Membership') {
      $class = "Ecometchatapi_Model_DbTable_Membership";
    }
    return parent::load($class);
  }

}