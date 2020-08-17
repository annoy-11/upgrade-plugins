<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: RequestController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_RequestController extends Core_Controller_Action_Standard {

  public function init() {
    if (0 !== ($store_id = (int) $this->_getParam('store_id')) &&
            null !== ($store = Engine_Api::_()->getItem('stores', $store_id))) {
      Engine_Api::_()->core()->setSubject($store);
    }
    $this->_helper->requireUser();
    $this->_helper->requireSubject('stores');
  }

  public function acceptAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('stores')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Request_Accept();

    // Process form
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Method');
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Data');
      return;
    }
    // Process form
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    $db = Engine_Api::_()->getDbTable('linkstores', 'estore')->getAdapter();
    $db->beginTransaction();
    try {
      // Set the request as handled
      $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType($viewer, $subject, 'estore_link_store');
      if ($notification) {
        $notification->mitigated = true;
        $notification->save();
      }
      Engine_Db_Table::getDefaultAdapter()->update('engine4_estore_linkstores', array('active' => 1), array("user_id = ?" => $notification->subject_id, "link_store_id = ?" => $subject->store_id));
      $receiver = Engine_Api::_()->getItem('user', $notification->subject_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($receiver, $viewer, $subject, 'estore_accept_link_request');
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have accepted the store link invitation request of your store %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;
    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store link invitation accepted')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function rejectAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('stores')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Request_Reject();

    // Process form
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Method');
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Data');
      return;
    }
    // Process form
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    // Set the request as handled
    $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType($viewer, $subject, 'estore_link_store');
    if ($notification) {
      $notification->mitigated = true;
      $notification->save();
    }
    Engine_Db_Table::getDefaultAdapter()->delete('engine4_estore_linkstores', array("user_id = ?" => $notification->subject_id, "store_id = ?" => $subject->store_id));
    $receiver = Engine_Api::_()->getItem('user', $notification->subject_id);
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($receiver, $viewer, $subject, 'estore_reject_link_request');

    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have ignored the invite to the store %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store invite rejected')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

}
