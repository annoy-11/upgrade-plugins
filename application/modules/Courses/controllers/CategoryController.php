<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: CategoryController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_CategoryController extends Core_Controller_Action_Standard {

  public function browseAction() {
      $this->_helper->content->setEnabled();
  }

  public function indexAction() {
    $category_id = $this->_getParam('category_id', false);
    if ($category_id)
      $category_id = Engine_Api::_()->getDbTable('categories', 'courses')->getCategoryId($category_id);
    else
      return;
    $category = Engine_Api::_()->getItem('courses_category', $category_id);

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
