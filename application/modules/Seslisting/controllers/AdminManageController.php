<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_manage');

    $this->view->formFilter = $formFilter = new Seslisting_Form_Admin_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $seslisting = Engine_Api::_()->getItem('seslisting', $value);
					Engine_Api::_()->seslisting()->deleteListing($seslisting);
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
    'order' => isset($_GET['order']) ? $_GET['order'] :'',
    'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $listingTable = Engine_Api::_()->getDbTable('seslistings', 'seslisting');
    $listingTableName = $listingTable->info('name');
    $select = $listingTable->select()
    ->setIntegrityCheck(false)
    ->from($listingTableName)
    ->joinLeft($tableUserName, "$listingTableName.owner_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'listing_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($listingTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

     if (!empty($_GET['category_id']))
      $select->where($listingTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($listingTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($listingTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
    $select->where($listingTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
    $select->where($listingTableName . '.sponsored = ?', $_GET['sponsored']);

		if (isset($_GET['package_id']) && $_GET['package_id'] != '')
    $select->where($listingTableName . '.package_id = ?', $_GET['package_id']);

    if (isset($_GET['status']) && $_GET['status'] != '')
    $select->where($listingTableName . '.draft = ?', $_GET['status']);

		if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    	$select->where($listingTableName . '.is_approved = ?', $_GET['is_approved']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
    $select->where($listingTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
    $select->where($listingTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
      $select->where($listingTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
      $select->where($listingTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
    $select->where($listingTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

		if (isset($_GET['subcat_id'])) {
			$formFilter->subcat_id->setValue($_GET['subcat_id']);
			$this->view->category_id = $_GET['category_id'];
		}

    if (isset($_GET['subsubcat_id'])) {
			$formFilter->subsubcat_id->setValue($_GET['subsubcat_id']);
			$this->view->subcat_id = $_GET['subcat_id'];
    }

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function claimAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_claim');

    $this->view->formFilter = $formFilter = new Seslisting_Form_Admin_Claim_Filter();

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $seslistingClaim = Engine_Api::_()->getItem('seslisting_claim', $value);
          $seslistingClaim->delete();
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
    'order' => isset($_GET['order']) ? $_GET['order'] :'',
    'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $listingClaimTable = Engine_Api::_()->getDbTable('claims', 'seslisting');
    $listingClaimTableName = $listingClaimTable->info('name');
    $select = $listingClaimTable->select()
    ->setIntegrityCheck(false)
    ->from($listingClaimTableName)
    ->joinLeft($tableUserName, "$listingClaimTableName.user_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($listingClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    $select->where($listingClaimTableName . '.status = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
    $select->where($listingClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->listing_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $seslisting = Engine_Api::_()->getItem('seslisting', $id);
        // delete the seslisting entry into the database
        Engine_Api::_()->seslisting()->deleteListing($seslisting);
        $db->commit();
      }

      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Approved Action
  public function approvedAction() {
    $listing_id = $this->_getParam('id');
    if (!empty($listing_id)) {
      $seslisting = Engine_Api::_()->getItem('seslisting', $listing_id);
      $seslisting->is_approved = !$seslisting->is_approved;
      $seslisting->save();
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($seslisting);
      if(count($action->toArray()) <= 0 && (!$seslisting->publish_date || strtotime($seslisting->publish_date) <= time())) {
          $viewer = Engine_Api::_()->getItem('user', $seslisting->owner_id);
          $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $seslisting, 'seslisting_new');
          // make sure action exists before attaching the seslisting to the activity
          if( $action ) {
            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $seslisting);
          }
      }
    }
    $this->_redirect('admin/seslisting/manage');
  }

  //Featured Action
  public function featuredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('seslisting', $event_id);
      $event->featured = !$event->featured;
      $event->save();
    }
    $this->_redirect('admin/seslisting/manage');
  }


  //Sponsored Action
  public function sponsoredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('seslisting', $event_id);
      $event->sponsored = !$event->sponsored;
      $event->save();
    }
    $this->_redirect('admin/seslisting/manage');
  }

  //Verify Action
  public function verifyAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('seslisting', $event_id);
      $event->verified = !$event->verified;
      $event->save();
    }
    $this->_redirect('admin/seslisting/manage');
  }

  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Seslisting_Form_Admin_Oftheday();
    $item = Engine_Api::_()->getItem('seslisting', $id);
    $form->setTitle("Listing of the Day");
    $form->setDescription('Here, choose the start date and end date for this listing to be displayed as "Listing of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Listing of the Day");

    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update('engine4_seslisting_listings', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("listing_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_seslisting_listings', array('offtheday' => 0), array("listing_id = ?" => $id));
      } else {
        $db->update('engine4_seslisting_listings', array('offtheday' => 1), array("listing_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }

  public function showDetailAction() {
    $claimId = $this->_getParam('id');
    $this->view->claimItem = Engine_Api::_()->getItem('seslisting_claim', $claimId);
  }

  public function approveClaimAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('seslisting_claim', $claimId);
    $listingItem = Engine_Api::_()->getItem('seslisting', $claimItem->listing_id);
    $currentOwnerId = $listingItem->owner_id;
    $this->view->form = $form = new Seslisting_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();

		if (!$this->getRequest()->isPost()) {
		return;
		}
		if (!$form->isValid($this->getRequest()->getPost())) {
		return;
		}

    $viewer = Engine_Api::_()->user()->getViewer();
		if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {

			//upgrade album
			$db->update('engine4_seslisting_albums', array('owner_id' => $claimItem->user_id), array("listing_id = ?" => $claimItem->listing_id));
			//upgrade photos
			$db->update('engine4_seslisting_photos', array('user_id' => $claimItem->user_id), array("listing_id = ?" => $claimItem->listing_id));
			//upgrade favourites
			$db->update('engine4_seslisting_favourites', array('user_id' => $claimItem->user_id), array("resource_id = ?" => $claimItem->listing_id,'user_id = ?'=>$listingItem->owner_id));
			//upgrade reviews
			$db->update('engine4_seslisting_reviews', array('owner_id' => $claimItem->user_id), array("listing_id = ?" => $claimItem->listing_id,'owner_id = ?'=>$listingItem->owner_id));
			//upgrade roles
			$db->update('engine4_seslisting_roles', array('user_id' => $claimItem->user_id), array("listing_id = ?" => $claimItem->listing_id,'user_id = ?'=>$listingItem->owner_id));
			//upgrade extention if exists
			//upgrade video
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')){
				$db->update('engine4_video_videos', array('owner_id' => $claimItem->user_id), array("parent_id = ?" => $claimItem->listing_id,'parent_type = ?'=>'seslisting','owner_id = ?'=>$listingItem->owner_id));
			}
			//upgrade music plugin
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmusic')){
				//upgrade video
				$db->update('engine4_sesmusic_albums', array('owner_id' => $claimItem->user_id), array("resource_id = ?" => $claimItem->listing_id,'resource_type = ?'=>'seslisting','owner_id = ? '=>$listingItem->owner_id));
			}
			//done upgrade extention work

			$db->update('engine4_seslisting_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));
			$db->update('engine4_seslisting_listings', array('owner_id' => $claimItem->user_id), array("listing_id = ?" => $claimItem->listing_id));
			$fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
			$fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
			$mailDataClaimOwner = array('sender_title' => $fromName);
			$bodyForClaimOwner = '';
			$bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			$bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataClaimOwner['message'] = $bodyForClaimOwner;
		  Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'seslisting_claim_owner_approve', $mailDataClaimOwner);
			$mailDataListingOwner = array('sender_title' => $fromName);
			$bodyForListingOwner = '';
			$bodyForListingOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
			$bodyForListingOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
			$bodyForListingOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataListingOwner['message'] = $bodyForListingOwner;
			$listingOwnerId = Engine_Api::_()->getItem('seslisting', $claimItem->listing_id)->owner_id;
			$listingOwnerEmail = Engine_Api::_()->getItem('user', $listingOwnerId)->email;
			$claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
			$listingOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($listingOwnerEmail, 'seslisting_owner_approve', $mailDataListingOwner);
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $listingItem, 'seslisting_claim_approve');
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($listingOwner, $viewer, $listingItem, 'seslisting_owner_informed');
		}
		elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_seslisting_claims', array("claim_id = ?" => $claimItem->claim_id));
		  Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $listingItem, 'seslisting_claim_declined');
		}
		else {
		  $form->addError($this->view->translate("Choose atleast one option for this claim request."));
      return;
		}

		$this->_forward('success', 'utility', 'core', array(
				'smoothboxClose' => 10,
				'parentRefresh' => 10,
				'messages' => array('Claim has been updated Successfully')
		));
  }

  //view item function
  public function viewAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('seslisting', $id);
    $this->view->item = $item;
  }

}
