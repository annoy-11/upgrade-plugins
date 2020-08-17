<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Widget_WishlistsBrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();

    $searchOptionsType = $this->_getParam('searchOptionsType', array('searchBox', 'view', 'show'));

    if (empty($searchOptionsType))
      return $this->setNoRender();

    $this->view->form = $formFilter = new Sesproduct_Form_Wishlist_SearchWishlist();

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
