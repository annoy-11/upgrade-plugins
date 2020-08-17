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



class Sesfaq_Widget_CategoryListingController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->limitdatafaq = $this->_getParam('limitdatafaq', 5);
    $this->view->showinformation = $this->_getParam('showinformation', array('viewall', 'caticon'));
    $this->view->showfaqicon = $this->_getParam('showfaqicon', 1);
    $this->view->faqtitlelimit = $this->_getParam('faqtitlelimit', 50);
    $sesfaq_categories = Zend_Registry::isRegistered('sesfaq_categories') ? Zend_Registry::get('sesfaq_categories') : null;
    if(empty($sesfaq_categories)) {
      return $this->setNoRender();
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $params['limit'] = $this->_getParam('limit_data', 4);
    $params['criteria'] = $this->_getParam('criteria', '');
    $params['hasFaq'] = 1;
    $this->view->faqcriteria = $this->_getParam('faqcriteria', 'creation_date');
    $this->view->resultcategories = Engine_Api::_()->getDbTable('categories', 'sesfaq')->getCategory($params);
    if(count($this->view->resultcategories) <= 0)
      return $this->setNoRender();

  }

}
