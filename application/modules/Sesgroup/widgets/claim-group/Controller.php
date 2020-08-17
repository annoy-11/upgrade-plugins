<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Widget_ClaimGroupController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->form = $form = new Sesgroup_Form_Claim();
    
    if(isset($_POST))
    $form->populate($_POST);

    if (empty($_POST)) 
    return;
    
    $validator = new Zend_Validate_EmailAddress();
    $validator->getHostnameValidator()->setValidateTld(false);
    if (!$validator->isValid($_POST['user_email'])) {
      $errorMessage = '<div class="sesgroup_claim_form_tip"><div class="sesgroup_error_message"><i class="fa fa-times-circle"></i><span>'.$this->view->translate("Invalid sender email address, which you have put in email field.").'</span></div></div>';
      echo json_encode(array('status'=>false,'message'=>$errorMessage));die;
    }
    
		// Process
		$table = Engine_Api::_()->getDbtable('claims', 'sesgroup');
		$db = $table->getAdapter();
		$db->beginTransaction();
		try {
			// Create Claim
			$viewer = Engine_Api::_()->user()->getViewer();
			$sesgroupClaim = $table->createRow();
			$sesgroupClaim->user_id = $viewer->getIdentity();
			$sesgroupClaim->group_id = $_POST['group_id'];
			$sesgroupClaim->title = $_POST['title'];
			$sesgroupClaim->user_email = $_POST['user_email'];
			$sesgroupClaim->user_name = $_POST['user_name'];
			$sesgroupClaim->contact_number = $_POST['contact_number'];
			$sesgroupClaim->description = $_POST['description'];
			$sesgroupClaim->save();
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
    $groupItem = Engine_Api::_()->getItem('sesgroup_group', $_POST['group_id']);
    $groupOwnerId = $groupItem->owner_id;
    $owner = $groupItem->getOwner();
    $pageOwnerEmail = Engine_Api::_()->getItem('user', $groupOwnerId)->email;
    $fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($pageOwnerEmail, 'sesgroup_group_owner_claim', $mail_settings);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($fromAddress, 'sesgroup_site_owner_for_claim', $mail_settings);
    
    //Send notification to page owner
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $groupItem, 'sesuser_claim_group');
    
    //Send notification to all superadmins
    $getAllSuperadmins = Engine_Api::_()->user()->getSuperAdmins();
    foreach($getAllSuperadmins as $getAllSuperadmin) {
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($getAllSuperadmin, $viewer, $groupItem, 'sesuser_claimadmin_group');    
    }
    
    echo json_encode(array('status'=>true,'message'=>'<div class="sesgroup_claim_form_tip"><div class="sesgroup_success_message"><i class="fa fa-check"></i><span>'.$this->view->translate('Your request for claim has been sent to site owner. He will contact you soon.').'</span></div></div>'));die;
  }

}
