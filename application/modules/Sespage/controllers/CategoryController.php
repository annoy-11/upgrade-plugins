<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_CategoryController extends Core_Controller_Action_Standard {

  public function browseAction() {
    $sespage_sespagecategories = Zend_Registry::isRegistered('sespage_sespagecategories') ? Zend_Registry::get('sespage_sespagecategories') : null;
    if(!empty($sespage_sespagecategories)) {
      $this->_helper->content->setEnabled();
    }
  }

  public function indexAction() {
    $category_id = $this->_getParam('category_id', false);
    if ($category_id)
      $category_id = Engine_Api::_()->getDbTable('categories', 'sespage')->getCategoryId($category_id);
    else
      return;
    $category = Engine_Api::_()->getItem('sespage_category', $category_id);

    if ($category)
      Engine_Api::_()->core()->setSubject($category);

    if (!$this->_helper->requireSubject()->isValid())
      return;

    $message_id = $this->getRequest()->getParam('message');
    $message_view = false;
    if ($message_id) {
      $conversation = Engine_Api::_()->getItem('messages_conversation', $message_id);
      if ($conversation->hasRecipient(Engine_Api::_()->user()->getViewer())) {
        $message_view = true;
      }
    }
    $this->view->message_view = $message_view;
    // Render
    $this->_helper->content->setEnabled();
  }

}
