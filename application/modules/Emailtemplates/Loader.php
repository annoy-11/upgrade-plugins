<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Loader.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Emailtemplates_Loader extends Engine_Loader {

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
    if ($class == 'Core_Api_Mail') {
      $class = "Emailtemplates_Api_Mail";
    }

    return parent::load($class);
  }

}