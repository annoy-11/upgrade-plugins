<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: IndexController.php 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Edeletedmember_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
}
