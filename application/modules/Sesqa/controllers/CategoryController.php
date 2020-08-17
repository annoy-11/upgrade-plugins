<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_CategoryController extends Core_Controller_Action_Standard {
	public function browseAction() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid())
      return;
      // Render
    $this->_helper->content->setEnabled();		
	}
	public function indexAction() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid())
      return;      
    $category_id = $this->_getParam('category_id', 0);
    if($category_id) {
      $category_id = Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategoryId($category_id); 
    } else {
      return;
    }
    $category = Engine_Api::_()->getItem('sesqa_category', $category_id);
    if($category) {
      Engine_Api::_()->core()->setSubject($category);
    } else
      $this->_forward('requireauth', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();		
	}
}