<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_ClaimRecipeController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->form = $form = new Sesrecipe_Form_Claim();
    
    if(isset($_POST))
    $form->populate($_POST);

    if (empty($_POST)) 
    return;
    
    $validator = new Zend_Validate_EmailAddress();
    $validator->getHostnameValidator()->setValidateTld(false);
    if (!$validator->isValid($_POST['user_email'])) {
      $errorMessage = '<div class="sesrecipe_claim_form_tip"><div class="sesrecipe_error_message"><i class="fa fa-times-circle"></i><span>'.$this->view->translate("Invalid sender email address, which you have put in email field.").'</span></div></div>';
      echo json_encode(array('status'=>false,'message'=>$errorMessage));die;
    }
    
		// Process
		$table = Engine_Api::_()->getDbtable('claims', 'sesrecipe');
		$db = $table->getAdapter();
		$db->beginTransaction();
		try {
			// Create Claim
			$viewer = Engine_Api::_()->user()->getViewer();
			$sesrecipeClaim = $table->createRow();
			$sesrecipeClaim->user_id = $viewer->getIdentity();
			$sesrecipeClaim->recipe_id = $_POST['recipe_id'];
			$sesrecipeClaim->title = $_POST['title'];
			$sesrecipeClaim->user_email = $_POST['user_email'];
			$sesrecipeClaim->user_name = $_POST['user_name'];
			$sesrecipeClaim->contact_number = $_POST['contact_number'];
			$sesrecipeClaim->description = $_POST['description'];
			$sesrecipeClaim->save();
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
    $recipeItem = Engine_Api::_()->getItem('sesrecipe_recipe', $_POST['recipe_id']);
    $recipeOwnerId = $recipeItem->owner_id;
    $owner = $recipeItem->getOwner();
    $recipeOwnerEmail = Engine_Api::_()->getItem('user', $recipeOwnerId)->email;
    $fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($recipeOwnerEmail, 'sesrecipe_recipe_owner_claim', $mail_settings);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($fromAddress, 'sesrecipe_site_owner_for_claim', $mail_settings);
    
    //Send notification to recipe owner
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $recipeItem, 'sesuser_claim_recipe');
    
    //Send notification to all superadmins
    $getAllSuperadmins = Engine_Api::_()->user()->getSuperAdmins();
    foreach($getAllSuperadmins as $getAllSuperadmin) {
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($getAllSuperadmin, $viewer, $recipeItem, 'sesuser_claimadmin_recipe');    
    }
    
    echo json_encode(array('status'=>true,'message'=>'<div class="sesrecipe_claim_form_tip"><div class="sesrecipe_success_message"><i class="fa fa-check"></i><span>'.$this->view->translate('Your request for claim has been sent to site owner. He will contact you soon.').'</span></div></div>'));die;
  }

}
