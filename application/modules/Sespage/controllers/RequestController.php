<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: RequestController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_RequestController extends Core_Controller_Action_Standard {

  public function init() {
    if (0 !== ($page_id = (int) $this->_getParam('page_id')) &&
            null !== ($page = Engine_Api::_()->getItem('sespage_page', $page_id))) {
      Engine_Api::_()->core()->setSubject($page);
    }
    $this->_helper->requireUser();
    $this->_helper->requireSubject('sespage_page');
  }

  public function acceptAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('sespage_page')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Sespage_Form_Request_Accept();

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
    $db = Engine_Api::_()->getDbTable('linkpages', 'sespage')->getAdapter();
    $db->beginTransaction();
    try {
      // Set the request as handled
      $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType($viewer, $subject, 'sespage_link_page');
      if ($notification) {
        $notification->mitigated = true;
        $notification->save();
      }
      Engine_Db_Table::getDefaultAdapter()->update('engine4_sespage_linkpages', array('active' => 1), array("user_id = ?" => $notification->subject_id, "link_page_id = ?" => $subject->page_id));
      $receiver = Engine_Api::_()->getItem('user', $notification->subject_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($receiver, $viewer, $subject, 'sespage_accept_link_request');
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have accepted the page link invitation request of your page %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;
    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Page link invitation accepted')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function rejectAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('sespage_page')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Sespage_Form_Request_Reject();

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
    $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType($viewer, $subject, 'sespage_link_page');
    if ($notification) {
      $notification->mitigated = true;
      $notification->save();
    }
    Engine_Db_Table::getDefaultAdapter()->delete('engine4_sespage_linkpages', array("user_id = ?" => $notification->subject_id, "page_id = ?" => $subject->page_id));
    $receiver = Engine_Api::_()->getItem('user', $notification->subject_id);
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($receiver, $viewer, $subject, 'sespage_reject_link_request');

    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have ignored the invite to the page %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Page invite rejected')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

}
