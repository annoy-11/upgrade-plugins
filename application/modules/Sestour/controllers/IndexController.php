<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
