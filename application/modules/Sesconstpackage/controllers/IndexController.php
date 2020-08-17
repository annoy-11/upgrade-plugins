<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesconstpackage
 * @package    Sesconstpackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-09-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesconstpackage_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
