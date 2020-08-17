<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusiness_admin_main', array(), 'sesbusiness_admin_main_manage');
    $this->view->formFilter = $formFilter = new Sesbusiness_Form_Admin_Filter();
    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $business = Engine_Api::_()->getItem('businesses', $value);
          $business->delete();
        }
      }
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] : '',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
            ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $businessTable = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
    $businessesTableName = $businessTable->info('name');
    $select = $businessTable->select()
            ->setIntegrityCheck(false)
            ->from($businessesTableName)
            ->joinLeft($tableUserName, "$businessesTableName.owner_id = $tableUserName.user_id", 'username')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'business_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
      $select->where($businessesTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['category_id']))
      $select->where($businessesTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($businessesTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($businessesTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($businessesTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($businessesTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($businessesTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['business_type']) && $_GET['business_type'] != '')
      $select->where($businessesTableName . '.business_type = ?', $_GET['business_type']);

    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($businessesTableName . '.hot = ?', $_GET['hot']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($businessesTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($businessesTableName . '.is_approved = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
      $select->where($businessesTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function deleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->sesbusiness_id = $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();

    if ($type == 'businesses') {
      $item = Engine_Api::_()->getItem('businesses', $id);
      $form->setTitle('Delete Business?');
      $form->setDescription('Are you sure that you want to delete this business? It will not be recoverable after being deleted.');
      $form->submit->setLabel('Delete');
    }

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $item->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully deleted this entry.')
      ));
    }
  }

  //Featured Action
  public function featuredAction() {
    $business_id = $this->_getParam('id');
    if (!empty($business_id)) {
      $business = Engine_Api::_()->getItem('businesses', $business_id);
      $business->featured = !$business->featured;
      $business->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesbusiness/manage';
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredAction() {
    $business_id = $this->_getParam('id');
    if (!empty($business_id)) {
      $business = Engine_Api::_()->getItem('businesses', $business_id);
      $business->sponsored = !$business->sponsored;
      $business->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesbusiness/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function verifyAction() {
    $business_id = $this->_getParam('id');
    if (!empty($business_id)) {
      $business = Engine_Api::_()->getItem('businesses', $business_id);
      $business->verified = !$business->verified;
      $business->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesbusiness/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function hotAction() {
    $business_id = $this->_getParam('id');
    if (!empty($business_id)) {
      $business = Engine_Api::_()->getItem('businesses', $business_id);
      $business->hot = !$business->hot;
      $business->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesbusiness/manage';
    $this->_redirect($url);
  }

  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Sesbusiness_Form_Admin_Oftheday();
    if ($type == 'businesses') {
      $item = Engine_Api::_()->getItem('businesses', $id);
      $form->setTitle("Business of the Day");
      $form->setDescription('Here, choose the start date and end date for this business to be displayed as "Business of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Business of the Day");
      $table = 'engine4_sesbusiness_businesses';
      $item_id = 'business_id';
    }
    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) {
        return;
      }
      $values = $form->getValues();
      $start = strtotime($values['startdate']);
      $end = strtotime($values['enddate']);
      $values['startdate'] = date('Y-m-d', $start);
      $values['enddate'] = date('Y-m-d', $end);
      $db->update($table, array('startdate' => $values['startdate'], 'enddate' => $values['enddate']), array("$item_id = ?" => $id));
      if (@$values['remove']) {
        $db->update($table, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($table, array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

  public function viewAction() {
    $this->view->item = Engine_Api::_()->getItem('businesses', $this->_getParam('id', null));
  }

  //Approved Action
  public function approvedAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $business_id = $this->_getParam('id');
    if (!empty($business_id)) {
      $business = Engine_Api::_()->getItem('businesses', $business_id);
      $business->is_approved = !$business->is_approved;
      $business->save();
      if ($business->is_approved) {
        $mailType = 'sesbusiness_business_adminapproved';
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $getActivity = $activityApi->getActionsByObject($business);
        if (!count($getActivity)) {
          $action = $activityApi->addActivity($viewer, $business, 'sesbusiness_create');
          if ($action) {
            $activityApi->attachActivity($action, $business);
          }
        }
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($business->getOwner(), $viewer, $business, 'sesbusiness_business_adminaapr');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($business->getOwner(), 'notify_sesbusiness_business_businesssentforapproval', array('business_title' => $business->getTitle(), 'businessowner_title' => $business->getOwner()->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } else {
        $mailType = 'sesbusiness_business_admindisapproved';
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($business->getOwner(), $viewer, $business, 'sesbusiness_business_admindisapr');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($business->getOwner(), 'notify_sesbusiness_business_disapprovedbyadmin', array('business_title' => $business->getTitle(), 'businessowner_title' => $business->getOwner()->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
      //Business approved mail send to business owner
      //Engine_Api::_()->getApi('mail', 'core')->sendSystem($business->getOwner(), $mailType, array('member_name' => $business->getOwner()->getTitle(), 'business_title' => $business->title, 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    }
    $this->_redirect('admin/sesbusiness/manage');
  }

  public function changeOwnerAction() {
    $this->_helper->layout->setLayout('admin-simple');
    if (!$this->_getParam('id', null))
      return;
    $this->view->business = $business = Engine_Api::_()->getItem('businesses', $this->_getParam('id', null));
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->sesbusiness()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $business->owner_id, 'business_id' => $business->business_id));
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Owner has been changed successfully.')
    ));
  }


  public function claimAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesbusiness_admin_main', array(), 'sesbusiness_admin_main_claim');

    $this->view->formFilter = $formFilter = new Sesbusiness_Form_Admin_Claim_Filter();

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesbusinessClaim = Engine_Api::_()->getItem('sesbusiness_claim', $value);
          $sesbusinessClaim->delete();
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
    $businessClaimTable = Engine_Api::_()->getDbTable('claims', 'sesbusiness');
    $businessClaimTableName = $businessClaimTable->info('name');
    $select = $businessClaimTable->select()
    ->setIntegrityCheck(false)
    ->from($businessClaimTableName)
    ->joinLeft($tableUserName, "$businessClaimTableName.user_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($businessClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    $select->where($businessClaimTableName . '.status = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
    $select->where($businessClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function showDetailAction() {
    $claimId = $this->_getParam('id');
    $this->view->claimItem = Engine_Api::_()->getItem('sesbusiness_claim', $claimId);
  }


  public function approveClaimAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('sesbusiness_claim', $claimId);
    $businessItem = Engine_Api::_()->getItem('businesses', $claimItem->business_id);
    $currentOwnerId = $businessItem->owner_id;
    $this->view->form = $form = new Sesbusiness_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();

		if (!$this->getRequest()->isPost()) {
      return;
		}

		if (!$form->isValid($this->getRequest()->getPost())) {
      return;
		}

    $viewer = Engine_Api::_()->user()->getViewer();

		if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {

      Engine_Api::_()->sesbusiness()->updateNewOwnerId(array('newuser_id' => $claimItem->user_id, 'olduser_id' => $businessItem->owner_id, 'business_id' => $businessItem->business_id));

			$db->update('engine4_sesbusiness_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));

			$fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
			$fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
			$mailDataClaimOwner = array('sender_title' => $fromName);
			$bodyForClaimOwner = '';
			$bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			$bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataClaimOwner['message'] = $bodyForClaimOwner;
		  Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'sesbusiness_claim_owner_approve', $mailDataClaimOwner);
			$mailDataBusinessOwner = array('sender_title' => $fromName);
			$bodyForBusinessOwner = '';
			$bodyForBusinessOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
			$bodyForBusinessOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
			$bodyForBusinessOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataBusinessOwner['message'] = $bodyForBusinessOwner;
			$businessOwnerId = Engine_Api::_()->getItem('businesses', $claimItem->business_id)->owner_id;
			$businessOwnerEmail = Engine_Api::_()->getItem('user', $businessOwnerId)->email;
			$claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
			$businessOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($businessOwnerEmail, 'sesbusiness_business_owner_approve', $mailDataBusinessOwner);
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $businessItem, 'sesbusiness_claim_approve');
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($businessOwner, $viewer, $businessItem, 'sesbusiness_owner_informed');
		}
		elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_sesbusiness_claims', array("claim_id = ?" => $claimItem->claim_id));
		  Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $businessItem, 'sesbusiness_claim_declined');
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
}
