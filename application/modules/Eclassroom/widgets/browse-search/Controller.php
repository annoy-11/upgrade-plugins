<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() { 
    $this->view->view_type = $this->_getParam('view_type', 'horizontal');
    $this->view->defaultProfileId = 1;
    $this->view->search_for = $search_for = $this->_getParam('search_for', 'page');
    $searchForm = $this->view->form = new Eclassroom_Form_Search(array('defaultProfileId' => 1));
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm->setMethod('get')->populate($request->getParams());
  }
}
