<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageurl
 * @package    Sespageurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageurl_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
