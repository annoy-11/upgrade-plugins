<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Widget_BrowseCompanySearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->view_type = $this-> _getParam('view_type', 'horizontal');

    $searchForm = $this->view->form = new Sesjob_Form_SearchCompany(array('searchTitle' => $this->_getParam('search_title', 'yes'),'categoriesSearch' => $this->_getParam('categories', 'yes')));

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $searchForm->setMethod('get')->populate($request->getParams());
  }
}
