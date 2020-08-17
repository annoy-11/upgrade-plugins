<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_CategoryController extends Core_Controller_Action_Standard {

  public function browseAction() {
    $sesgroup_sesgroupcategories = Zend_Registry::isRegistered('sesgroup_sesgroupcategories') ? Zend_Registry::get('sesgroup_sesgroupcategories') : null;
    if(!empty($sesgroup_sesgroupcategories)) {
      $this->_helper->content->setEnabled();
    }
  }

  public function indexAction() {
    $category_id = $this->_getParam('category_id', false);
    if ($category_id)
      $category_id = Engine_Api::_()->getDbTable('categories', 'sesgroup')->getCategoryId($category_id);
    else
      return;
    $category = Engine_Api::_()->getItem('sesgroup_category', $category_id);

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
