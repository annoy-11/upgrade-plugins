<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_CategoryController extends Core_Controller_Action_Standard {

  public function browseAction() {
    $this->_helper->content->setEnabled();
  }

  public function indexAction() {
    $category_id = $this->_getParam('category_id', false);
    if ($category_id) {
      $category_id = Engine_Api::_()->getDbtable('categories', 'eblog')->getCategoryId($category_id);
    } else {
      return;
    }
    $category = Engine_Api::_()->getItem('eblog_category', $category_id);
    if ($category) {
      Engine_Api::_()->core()->setSubject($category);
    }
    if (!$this->_helper->requireSubject()->isValid())
      return;
    $eblog_category = Zend_Registry::isRegistered('eblog_category') ? Zend_Registry::get('eblog_category') : null;
    if (empty($eblog_category))
      return $this->_forward('notfound', 'error', 'core');
    // video is a type of object chanel
    // if this is sending a message id, the user is being directed from a coversation
    // check if member is part of the conversation
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
