<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_CategoryController extends Core_Controller_Action_Standard {

	public function browseAction() {
	
    if (!$this->_helper->requireAuth()->setAuthParams('sesfaq_faq', null, 'view')->isValid())
      return;
    $sesfaq_categories = Zend_Registry::isRegistered('sesfaq_categories') ? Zend_Registry::get('sesfaq_categories') : null;
    if(!empty($sesfaq_categories)) {
      $this->_helper->content->setEnabled();
    }
	}

	public function indexAction() {
	
    if (!$this->_helper->requireAuth()->setAuthParams('sesfaq_faq', null, 'view')->isValid())
      return;
      
    $category_id = $this->_getParam('category_id', 0);
    if($category_id) {
      $category_id = Engine_Api::_()->getDbtable('categories', 'sesfaq')->getCategoryId($category_id); 
    } else {
      return;
    }

    $category = Engine_Api::_()->getItem('sesfaq_category', $category_id);
    if($category) {
      Engine_Api::_()->core()->setSubject($category);
    } else
      $this->_forward('requireauth', 'error', 'core');
      
    // Render
    $this->_helper->content->setEnabled();		
	}
}