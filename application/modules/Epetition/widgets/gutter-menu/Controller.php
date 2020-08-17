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
class Epetition_Widget_GutterMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {

    // Only sesblog or user as subject
    if( Engine_Api::_()->core()->hasSubject('epetition') ) {
      $this->view->epetition = $epetition = Engine_Api::_()->core()->getSubject('epetition');
      //$this->view->epetition_id=$epetition['epetition_id'];
      $this->view->owner = $owner = $epetition->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->epetition = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
    
    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('epetition_gutter');

  }
}
