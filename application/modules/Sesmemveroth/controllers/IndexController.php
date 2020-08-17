<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_IndexController extends Core_Controller_Action_Standard {

  public function viewAction() {
    $resource_id = $this->_getParam('resource_id', null);
    $this->view->resource = Engine_Api::_()->getItem('user', $resource_id);
    $this->view->allRequests = Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->getAllUserVerificationRequests($resource_id);
  }

  public function verificationAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

    $resource_id = $this->getRequest()->getParam('id');
    $resource = Engine_Api::_()->getItem('user', $resource_id);

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesmemveroth_Form_Verification();

    $verification_id = $this->_getParam('verification_id', null);
    if ($verification_id) {
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Comment");
      $form->setDescription("Edit your comment for verifying this member.");
      $verification = Engine_Api::_()->getItem('sesmemveroth_verification', $verification_id);
      $form->populate($verification->toArray());
    }

    if ($this->getRequest()->isPost()) {

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

      $verificationTable = Engine_Api::_()->getDbtable('verifications', 'sesmemveroth');
      $db = $verificationTable->getAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        if (!isset($verification))
            $verification = $verificationTable->createRow();

            $verification->poster_id = $viewer->getIdentity();
            $verification->poster_title = $viewer->getTitle();
            $verification->resource_id = $resource_id;
            $verification->resource_title = $resource->getTitle();

            if($values['description']) {
                $verification->description = $values['description'];
            }

            $autoapprove = Engine_Api::_()->authorization()->isAllowed('sesmemveroth', null, 'autoapprove');

            if($autoapprove) {
                $verification->admin_approved = 1;
            } else {
                $verification->admin_approved = 0;
            }

            $verification->save();

            if($autoapprove) {
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($resource, $viewer, $viewer, 'sesmemveroth_verified');
            } else {
                $owner_admin = Engine_Api::_()->getItem('user', 1);
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner_admin, 'sesmemveroth_adminverificationrequests', array('sender_title' => $resource->getTitle(), 'admin_link' => 'admin/sesmemveroth/manage-requests', 'host' => $_SERVER['HTTP_HOST']));
            }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('<div class="sesmemveroth_success">You are Successfully Verified.</div>')
      ));
    }
  }


  public function cancelAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $verification = Engine_Api::_()->getItem('sesmemveroth_verification', $this->getRequest()->getParam('verification_id'));

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesmemveroth_Form_Cancel();
    if ($verification->admin_approved) {
      $form->submit->setLabel('Remove ');
      $form->setTitle("Remove Verification for This Member");
      $form->setDescription("Are you sure you want to remove verification for this member?");
    } else {
      $form->submit->setLabel('Cancel Verification Request');
      $form->setTitle("Cancel Verification for This Member");
      $form->setDescription("Are you sure you want to cancel verification for this member?");
    }

    if( !$verification ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Member Cerification entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $verification->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $verification->delete();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array('Your verification entry has been deleted.')
    ));
  }

}
