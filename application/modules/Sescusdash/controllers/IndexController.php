<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescusdash_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
