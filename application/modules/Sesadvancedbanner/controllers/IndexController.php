<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: IndexController.php 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

class Sesadvancedbanner_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
