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

class Epetition_Widget_ViewInfoController extends Engine_Content_Widget_Abstract
{

  public function indexAction()
  {
     $fc = Zend_Controller_Front::getInstance();
     $id = $fc->getRequest()->getParam('epetition_id', null);
     $epetition_id =Engine_Api::_()->getDbtable('epetitions','epetition')->getPetitionId($id);
    $epetition=$this->view->petition=Engine_Api::_()->getItem('epetition',$epetition_id);
  }
}
