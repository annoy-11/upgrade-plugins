<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_ClaimBusinessController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->form = $form = new Sesbusiness_Form_Claim();
    
    if(isset($_POST))
    $form->populate($_POST);

    if (empty($_POST)) 
    return;
    
    $validator = new Zend_Validate_EmailAddress();
    $validator->getHostnameValidator()->setValidateTld(false);
    if (!$validator->isValid($_POST['user_email'])) {
      $errorMessage = '<div class="sesbusiness_claim_form_tip"><div class="sesbusiness_error_message"><i class="fa fa-times-circle"></i><span>'.$this->view->translate("Invalid sender email address, which you have put in email field.").'</span></div></div>';
      echo json_encode(array('status'=>false,'message'=>$errorMessage));die;
    }
    
		// Process
		$table = Engine_Api::_()->getDbtable('claims', 'sesbusiness');
		$db = $table->getAdapter();
		$db->beginTransaction();
		try {
			// Create Claim
			$viewer = Engine_Api::_()->user()->getViewer();
			$sesbusinessClaim = $table->createRow();
			$sesbusinessClaim->user_id = $viewer->getIdentity();
			$sesbusinessClaim->business_id = $_POST['business_id'];
			$sesbusinessClaim->title = $_POST['title'];
			$sesbusinessClaim->user_email = $_POST['user_email'];
			$sesbusinessClaim->user_name = $_POST['user_name'];
			$sesbusinessClaim->contact_number = $_POST['contact_number'];
			$sesbusinessClaim->description = $_POST['description'];
			$sesbusinessClaim->save();
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
    $businessItem = Engine_Api::_()->getItem('businesses', $_POST['business_id']);
    $businessOwnerId = $businessItem->owner_id;
    $owner = $businessItem->getOwner();
    $pageOwnerEmail = Engine_Api::_()->getItem('user', $businessOwnerId)->email;
    $fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($pageOwnerEmail, 'sesbusiness_business_owner_claim', $mail_settings);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($fromAddress, 'sesbusiness_site_owner_for_claim', $mail_settings);
    
    //Send notification to page owner
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $businessItem, 'sesuser_claim_business');
    
    //Send notification to all superadmins
    $getAllSuperadmins = Engine_Api::_()->user()->getSuperAdmins();
    foreach($getAllSuperadmins as $getAllSuperadmin) {
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($getAllSuperadmin, $viewer, $businessItem, 'sesuser_claimadmin_business');    
    }
    
    echo json_encode(array('status'=>true,'message'=>'<div class="sesbusiness_claim_form_tip"><div class="sesbusiness_success_message"><i class="fa fa-check"></i><span>'.$this->view->translate('Your request for claim has been sent to site owner. He will contact you soon.').'</span></div></div>'));die;
  }

}
