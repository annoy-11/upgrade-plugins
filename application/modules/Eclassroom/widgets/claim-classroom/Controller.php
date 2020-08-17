<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Widget_ClaimClassroomController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->form = $form = new Eclassroom_Form_Claim();
    if(isset($_POST))
    $form->populate($_POST);

    if (empty($_POST))
    return;
    $validator = new Zend_Validate_EmailAddress();
    $validator->getHostnameValidator()->setValidateTld(false);
    if (!$validator->isValid($_POST['user_email'])) {
      $errorMessage = '<div class="eclassroom_claim_form_tip"><div class="eclassroom_error_message"><i class="fa fa-times-circle"></i><span>'.$this->view->translate("Invalid sender email address, which you have put in email field.").'</span></div></div>';
      echo json_encode(array('status'=>false,'message'=>$errorMessage));die;
    }
		// Process
    $table = Engine_Api::_()->getDbtable('claims', 'eclassroom');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
        // Create Claim
        $viewer = Engine_Api::_()->user()->getViewer();
        $eclassroomClaim = $table->createRow();
        $eclassroomClaim->user_id = $viewer->getIdentity();
        $eclassroomClaim->classroom_id = $_POST['classroom_id'];
        $eclassroomClaim->title = $_POST['title'];
        $eclassroomClaim->user_email = $_POST['user_email'];
        $eclassroomClaim->user_name = $_POST['user_name'];
        $eclassroomClaim->contact_number = $_POST['contact_number'];
        $eclassroomClaim->description = $_POST['description'];
        $eclassroomClaim->save();
        // Commit
        $db->commit();
    }
    catch( Exception $e ) {
        $db->rollBack();
        throw $e;
    }
    $mail_settings = array('sender_title' => $_POST['user_name']);
    $body = '';
    $body .= $this->view->translate("Email: %s", $_POST['user_email']) . '<br />';
    if(isset($_POST['contact_number']) && !empty($_POST['contact_number']))
    $body .= $this->view->translate("Claim Owner Contact Number: %s", $_POST['contact_number']) . '<br />';
    $body .= $this->view->translate("Claim Reason: %s", $_POST['description']) . '<br /><br />';
    $mail_settings['message'] = $body;
    $classroomItem = Engine_Api::_()->getItem('classroom', $_POST['classroom_id']);
    $classroomOwnerId = $classroomItem->owner_id;
    $owner = $classroomItem->getOwner();
    $pageOwnerEmail = Engine_Api::_()->getItem('user', $classroomOwnerId)->email;
    $fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($pageOwnerEmail, 'eclassroom_classroom_owner_claim', $mail_settings);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($fromAddress, 'eclassroom_site_owner_for_claim', $mail_settings);

    //Send notification to page owner
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $classroomItem, 'sesuser_claim_classroom');

    //Send notification to all superadmins
    $getAllSuperadmins = Engine_Api::_()->user()->getSuperAdmins();
    foreach($getAllSuperadmins as $getAllSuperadmin) {
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($getAllSuperadmin, $viewer, $classroomItem, 'sesuser_claimadmin_classroom');
    }

    echo json_encode(array('status'=>true,'message'=>'<div class="eclassroom_claim_form_tip"><div class="eclassroom_success_message"><i class="fa fa-check"></i><span>'.$this->view->translate('Your request for claim has been sent to site owner. He will contact you soon.').'</span></div></div>'));die;
  }

}
