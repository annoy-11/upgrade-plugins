<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessoffer_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->view_type = $this->_getParam('view_type', 'horizontal');
    $this->view->search_for = $search_for = $this->_getParam('search_for', 'business');
    $sesbusinessoffer_widget = Zend_Registry::isRegistered('sesbusinessoffer_widget') ? Zend_Registry::get('sesbusinessoffer_widget') : null;
    if(empty($sesbusinessoffer_widget))
      return $this->setNoRender();
    $searchForm = $this->view->form = new Sesbusinessoffer_Form_Search();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm->setMethod('get')->populate($request->getParams());
  }

}
