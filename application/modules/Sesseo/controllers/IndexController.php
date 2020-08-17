<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
