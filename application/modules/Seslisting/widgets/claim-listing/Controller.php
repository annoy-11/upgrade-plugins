<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Widget_ClaimListingController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->form = $form = new Seslisting_Form_Claim();

    if(isset($_POST))
    $form->populate($_POST);

    if (empty($_POST))
    return;

    $validator = new Zend_Validate_EmailAddress();
    $validator->getHostnameValidator()->setValidateTld(false);
    if (!$validator->isValid($_POST['user_email'])) {
      $errorMessage = '<div class="seslisting_claim_form_tip"><div class="seslisting_error_message"><i class="fa fa-times-circle"></i><span>'.$this->view->translate("Invalid sender email address, which you have put in email field.").'</span></div></div>';
      echo json_encode(array('status'=>false,'message'=>$errorMessage));die;
    }

		// Process
		$table = Engine_Api::_()->getDbtable('claims', 'seslisting');
		$db = $table->getAdapter();
		$db->beginTransaction();
		try {
			// Create Claim
			$viewer = Engine_Api::_()->user()->getViewer();
			$seslistingClaim = $table->createRow();
			$seslistingClaim->user_id = $viewer->getIdentity();
			$seslistingClaim->listing_id = $_POST['listing_id'];
			$seslistingClaim->title = $_POST['title'];
			$seslistingClaim->user_email = $_POST['user_email'];
			$seslistingClaim->user_name = $_POST['user_name'];
			$seslistingClaim->contact_number = $_POST['contact_number'];
			$seslistingClaim->description = $_POST['description'];
			$seslistingClaim->save();
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
    $listingItem = Engine_Api::_()->getItem('seslisting', $_POST['listing_id']);
    $listingOwnerId = $listingItem->owner_id;
    $owner = $listingItem->getOwner();
    $listingOwnerEmail = Engine_Api::_()->getItem('user', $listingOwnerId)->email;
    $fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($listingOwnerEmail, 'seslisting_owner_claim', $mail_settings);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($fromAddress, 'seslisting_site_owner_for_claim', $mail_settings);

    //Send notification to listing owner
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $listingItem, 'sesuser_claim_listing');

    //Send notification to all superadmins
    $getAllSuperadmins = Engine_Api::_()->user()->getSuperAdmins();
    foreach($getAllSuperadmins as $getAllSuperadmin) {
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($getAllSuperadmin, $viewer, $listingItem, 'sesuser_claimadmin_listing');
    }

    echo json_encode(array('status'=>true,'message'=>'<div class="seslisting_claim_form_tip"><div class="seslisting_success_message"><i class="fa fa-check"></i><span>'.$this->view->translate('Your request for claim has been sent to site owner. He will contact you soon.').'</span></div></div>'));die;
  }

}
