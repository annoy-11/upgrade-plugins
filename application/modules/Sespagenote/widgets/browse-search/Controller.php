<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagenote_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->view_type = $this->_getParam('view_type', 'horizontal');
    $this->view->search_for = $search_for = $this->_getParam('search_for', 'page');
    $searchForm = $this->view->form = new Sespagenote_Form_Search();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm->setMethod('get')->populate($request->getParams());
  }

}
