<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



class Sesfaq_Widget_CategoryAssociateFaqController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
		
    $params['limit'] = $this->_getParam('limit_data', 4);
    $params['hasFaq'] = 1;
    $this->view->faqcriteria = $this->_getParam('faqcriteria', 'creation_date');
    $this->view->showviewalllink = $this->_getParam('showviewalllink', 1);
    $this->view->resultcategories = Engine_Api::_()->getDbTable('categories', 'sesfaq')->getCategory($params);
		$this->view->limitdatafaq = $this->_getParam('limitdatafaq', 5);
		
		$this->view->showviewalllink = $this->_getParam('showviewalllink', 1);
		
    if(count($this->view->resultcategories) <= 0)
      return $this->setNoRender();
		
		$this->view->gridblockheight = $this->_getParam('gridblockheight', 250);
		$this->view->viewtype = $this->_getParam('viewtype', 'listview');
		$params['limit'] = $this->_getParam('limitdatafaq', 10);
		$params['faqcriteria'] = $this->_getParam('faqcriteria', 'creation_date');
		$this->view->faqtitlelimit = $this->_getParam('faqtitlelimit', 60);
		$this->view->faqdescriptionlimit = $this->_getParam('faqdescriptionlimit', 200);
		$this->view->showinformation = $this->_getParam('showinformation', array('likecount', 'viewcount', 'commentcount', 'ratingcount', 'description', 'readmorelink'));
		//$this->view->paginator = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqPaginator($params);
    $sesfaq_categories = Zend_Registry::isRegistered('sesfaq_categories') ? Zend_Registry::get('sesfaq_categories') : null;
    if(empty($sesfaq_categories)) {
      return $this->setNoRender();
    }
  }
}