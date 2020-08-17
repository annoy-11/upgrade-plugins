<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_CategoryController extends Core_Controller_Action_Standard {

  public function browseAction() {
    $sesbusiness_sesbusinesscategories = Zend_Registry::isRegistered('sesbusiness_sesbusinesscategories') ? Zend_Registry::get('sesbusiness_sesbusinesscategories') : null;
    if(!empty($sesbusiness_sesbusinesscategories)) {
      $this->_helper->content->setEnabled();
    }
  }

  public function indexAction() {
    $category_id = $this->_getParam('category_id', false);
    if ($category_id)
      $category_id = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategoryId($category_id);
    else
      return;
    $category = Engine_Api::_()->getItem('sesbusiness_category', $category_id);

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
