<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->view_type = $this->_getParam('view_type', 'horizontal');
    $this->view->defaultProfileId = 1;
    $this->view->search_for = $search_for = $this->_getParam('search_for', 'page');
    $searchForm = $this->view->form = new Estore_Form_Search(array('defaultProfileId' => 1));
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm->setMethod('get')->populate($request->getParams());
  }

}
