<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_ViewRecentController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null);
    $this->view->epetition_id = $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId($id);

  }

}
