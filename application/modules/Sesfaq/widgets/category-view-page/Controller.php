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

class Sesfaq_Widget_CategoryViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() { 
    
    if(!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();

    $this->view->viewType = $this->_getParam('viewType', 'subcategoryview');
    $this->view->limitdatafaq = $this->_getParam('limitdatafaq', 5);
    $this->view->showinformation = $this->_getParam('showinformation', array('viewall', 'caticon'));
    $this->view->faqtitlelimit = $this->_getParam('faqtitlelimit', 50);
    
    $limit = $this->_getParam('limit_data', 10);
    $this->view->faqcriteria = $this->_getParam('faqcriteria', 'creation_date');
    
    
    $this->view->gridblockheight = $this->_getParam('gridblockheight', 250);
		$this->view->viewtype = $this->_getParam('viewtype', 'listview');
		$this->view->faqdescriptionlimit = $this->_getParam('faqdescriptionlimit', 200);
		$this->view->showinformation1 = $this->_getParam('showinformation1', array('likecount', 'viewcount', 'commentcount', 'ratingcount', 'description', 'readmorelink'));
    
    if($subject->subcat_id == 0 && $subject->subsubcat_id == 0) {
      $this->view->thirdlevelcategory = 0;
      $this->view->resultcategories = $resultcategories = Engine_Api::_()->getDbTable('categories', 'sesfaq')->getModuleSubcategory(array('limit' => $limit, 'category_id' => $subject->getIdentity(), 'column_name' => array('*'), 'countFaqs' => 1));
    } else if($subject->subcat_id != 0 && $subject->subsubcat_id == 0) {
      $this->view->thirdlevelcategory = 1;
      $this->view->resultcategories = $resultcategories = Engine_Api::_()->getDbTable('categories', 'sesfaq')->getModuleSubsubcategory(array('limit' => $limit, 'category_id' => $subject->getIdentity(), 'column_name' => array('*'), 'countFaqs' => 1));
    }
		

  }

}
