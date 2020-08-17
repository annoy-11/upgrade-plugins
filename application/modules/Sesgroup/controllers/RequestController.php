<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: RequestController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_RequestController extends Core_Controller_Action_Standard {

  public function init() {
    if (0 !== ($group_id = (int) $this->_getParam('group_id')) &&
            null !== ($group = Engine_Api::_()->getItem('sesgroup_group', $group_id))) {
      Engine_Api::_()->core()->setSubject($group);
    }
    $this->_helper->requireUser();
    $this->_helper->requireSubject('sesgroup_group');
  }

  public function acceptAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('sesgroup_group')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Request_Accept();

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
    $db = Engine_Api::_()->getDbTable('linkgroups', 'sesgroup')->getAdapter();
    $db->beginTransaction();
    try {
      // Set the request as handled
      $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType($viewer, $subject, 'sesgroup_link_group');
      if ($notification) {
        $notification->mitigated = true;
        $notification->save();
      }
      Engine_Db_Table::getDefaultAdapter()->update('engine4_sesgroup_linkgroups', array('active' => 1), array("user_id = ?" => $notification->subject_id, "link_group_id = ?" => $subject->group_id));
      $receiver = Engine_Api::_()->getItem('user', $notification->subject_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($receiver, $viewer, $subject, 'sesgroup_accept_link_request');
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have accepted the group link invitation request of your group %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;
    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group link invitation accepted')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function rejectAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('sesgroup_group')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Request_Reject();

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
    $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType($viewer, $subject, 'sesgroup_link_group');
    if ($notification) {
      $notification->mitigated = true;
      $notification->save();
    }
    Engine_Db_Table::getDefaultAdapter()->delete('engine4_sesgroup_linkgroups', array("user_id = ?" => $notification->subject_id, "group_id = ?" => $subject->group_id));
    $receiver = Engine_Api::_()->getItem('user', $notification->subject_id);
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($receiver, $viewer, $subject, 'sesgroup_reject_link_request');

    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have ignored the invite to the group %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group invite rejected')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

}
