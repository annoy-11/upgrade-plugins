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
class Emailtemplates_Plugin_Loader extends Zend_Controller_Plugin_Abstract {

  public function preDispatch(Zend_Controller_Request_Abstract $request) {
    $loader = Engine_Loader::getInstance();
    if (get_class($loader) == 'Engine_Loader') {
      Emailtemplates_Loader::hook();
    }
  }

}
