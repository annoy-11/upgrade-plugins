<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_CategoryController extends Core_Controller_Action_Standard {

  public function browseAction() {
    $this->_helper->content->setEnabled();
  }

  public function indexAction() {
    $category_id = $this->_getParam('category_id', false);
    if ($category_id) {
      $category_id = Engine_Api::_()->getDbtable('categories', 'sesrecipe')->getCategoryId($category_id);
    } else {
      return;
    }
    $category = Engine_Api::_()->getItem('sesrecipe_category', $category_id);
    if ($category) {
      Engine_Api::_()->core()->setSubject($category);
    }
    if (!$this->_helper->requireSubject()->isValid())
      return;
    $sesrecipe_category = Zend_Registry::isRegistered('sesrecipe_category') ? Zend_Registry::get('sesrecipe_category') : null;
    if (empty($sesrecipe_category))
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
