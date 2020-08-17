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

class Epetition_Widget_ViewOwnerController extends Engine_Content_Widget_Abstract
{

  public function indexAction()
  {

    $this->view->photoviewtype = $this->_getParam('photoviewtype', "circle");
    $this->view->title = $this->_getParam('title', "Petition Owner");
    $this->view->allParams = $this->_getAllParams();
    $this->getElement()->removeDecorator('Title');
    if (Engine_Api::_()->core()->hasSubject('epetition')) {
      $this->view->user_description_limit = $this->_getParam('user_description_limit', 150);
      $this->view->epetition = $epetition = Engine_Api::_()->core()->getSubject('epetition');
      $this->view->owner = $owner = $epetition->getOwner();
      $this->view->totalpeition=Engine_Api::_()->getDbtable('epetitions', 'epetition')->totalpetition($epetition['owner_id']);
    } else if (Engine_Api::_()->core()->hasSubject('user')) {
      $this->view->epetition = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
  }
}
