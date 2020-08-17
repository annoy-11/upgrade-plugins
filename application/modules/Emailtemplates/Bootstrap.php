<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Emailtemplates_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
      parent::__construct($application);
      $this->initViewHelperPath();
      $frontController = Zend_Controller_Front::getInstance();
      $frontController->registerPlugin( new Emailtemplates_Plugin_Loader() );
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Emailtemplates/controllers/Checklicense.php';
  }
}
