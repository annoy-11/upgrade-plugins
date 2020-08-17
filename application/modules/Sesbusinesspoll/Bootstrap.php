<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspoll_Bootstrap extends Engine_Application_Bootstrap_Abstract
{

  public function __construct($application)
  {

    parent::__construct($application);
    $this->initViewHelperPath();
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesbusinesspoll/controllers/Checklicense.php';
  }
}
