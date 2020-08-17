<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_CategoryController extends Core_Controller_Action_Standard {

  public function browseAction() {
    
    $this->_helper->content->setEnabled();
  }

  public function indexAction() {
  
    $category_id = $this->_getParam('category_id', false);
    if ($category_id)
      $category_id = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->getCategoryId($category_id);
    else
      return;
    
    $category = Engine_Api::_()->getItem('sescrowdfunding_category', $category_id);
    if ($category)
      Engine_Api::_()->core()->setSubject($category);
    
    if (!$this->_helper->requireSubject()->isValid())
      return;

    $this->_helper->content->setEnabled();
  }
}