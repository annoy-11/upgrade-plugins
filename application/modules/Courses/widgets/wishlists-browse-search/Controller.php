<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Widget_WishlistsBrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    $searchOptionsType = $this->_getParam('searchOptionsType', array('searchBox', 'view', 'show'));
    if (empty($searchOptionsType))
      return $this->setNoRender();
    $this->view->form = $formFilter = new Courses_Form_Wishlist_SearchWishlist();
    if ($formFilter->isValid($requestParams))
      $values = $formFilter->getValues();
    else
      $values = array();
      //print_r($values);die;
    $this->view->formValues = array_filter($values);
    if (@$values['show'] == 2 && $viewer->getIdentity())
      $values['users'] = $viewer->membership()->getMembershipsOfIds();
    unset($values['show']);
  }

}
