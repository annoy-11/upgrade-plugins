<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmultiplecurrency
 * @package    Sesmultiplecurrency
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-09-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



class Sesmultiplecurrency_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
