<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroup_admin_main', array(), 'sesgroup_admin_main_manage');
    $this->view->formFilter = $formFilter = new Sesgroup_Form_Admin_Filter();
    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $group = Engine_Api::_()->getItem('sesgroup_group', $value);
          $group->delete();
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
    $groupTable = Engine_Api::_()->getDbTable('groups', 'sesgroup');
    $groupsTableName = $groupTable->info('name');
    $select = $groupTable->select()
            ->setIntegrityCheck(false)
            ->from($groupsTableName)
            ->joinLeft($tableUserName, "$groupsTableName.owner_id = $tableUserName.user_id", 'username')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'group_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
      $select->where($groupsTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['category_id']))
      $select->where($groupsTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($groupsTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($groupsTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($groupsTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($groupsTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($groupsTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['group_type']) && $_GET['group_type'] != '')
      $select->where($groupsTableName . '.group_type = ?', $_GET['group_type']);

    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($groupsTableName . '.hot = ?', $_GET['hot']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($groupsTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($groupsTableName . '.is_approved = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
      $select->where($groupsTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
    $this->view->sesgroup_id = $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();

    if ($type == 'sesgroup_group') {
      $item = Engine_Api::_()->getItem('sesgroup_group', $id);
      $form->setTitle('Delete Group?');
      $form->setDescription('Are you sure that you want to delete this group? It will not be recoverable after being deleted.');
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
    $group_id = $this->_getParam('id');
    if (!empty($group_id)) {
      $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
      $group->featured = !$group->featured;
      $group->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesgroup/manage';
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredAction() {
    $group_id = $this->_getParam('id');
    if (!empty($group_id)) {
      $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
      $group->sponsored = !$group->sponsored;
      $group->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesgroup/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function verifyAction() {
    $group_id = $this->_getParam('id');
    if (!empty($group_id)) {
      $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
      $group->verified = !$group->verified;
      $group->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesgroup/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function hotAction() {
    $group_id = $this->_getParam('id');
    if (!empty($group_id)) {
      $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
      $group->hot = !$group->hot;
      $group->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesgroup/manage';
    $this->_redirect($url);
  }

  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Sesgroup_Form_Admin_Oftheday();
    if ($type == 'sesgroup_group') {
      $item = Engine_Api::_()->getItem('sesgroup_group', $id);
      $form->setTitle("Group of the Day");
      $form->setDescription('Here, choose the start date and end date for this group to be displayed as "Group of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Group of the Day");
      $table = 'engine4_sesgroup_groups';
      $item_id = 'group_id';
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
    $this->view->item = Engine_Api::_()->getItem('sesgroup_group', $this->_getParam('id', null));
  }

  //Approved Action
  public function approvedAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $group_id = $this->_getParam('id');
    if (!empty($group_id)) {
      $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
      $group->is_approved = !$group->is_approved;
      $group->save();
      if ($group->is_approved) {
        $mailType = 'sesgroup_group_adminapproved';
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $getActivity = $activityApi->getActionsByObject($group);
        if (!count($getActivity)) {
          $action = $activityApi->addActivity($viewer, $group, 'sesgroup_create');
          if ($action) {
            $activityApi->attachActivity($action, $group);
          }
        }
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($group->getOwner(), $viewer, $group, 'sesgroup_group_adminapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($group->getOwner(), 'notify_sesgroup_group_groupsentforapproval', array('group_title' => $group->getTitle(), 'groupowner_title' => $group->getOwner()->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } else {
        $mailType = 'sesgroup_group_admindisapproved';
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($group->getOwner(), $viewer, $group, 'sesgroup_group_admindisapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($group->getOwner(), 'notify_sesgroup_group_disapprovedbyadmin', array('group_title' => $group->getTitle(), 'groupowner_title' => $group->getOwner()->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
      //Group approved mail send to group owner
      //Engine_Api::_()->getApi('mail', 'core')->sendSystem($group->getOwner(), $mailType, array('member_name' => $group->getOwner()->getTitle(), 'group_title' => $group->title, 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    }
    $this->_redirect('admin/sesgroup/manage');
  }

  public function changeOwnerAction() {
    $this->_helper->layout->setLayout('admin-simple');
    if (!$this->_getParam('id', null))
      return;
    $this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $this->_getParam('id', null));
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->sesgroup()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $group->owner_id, 'group_id' => $group->group_id));
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Owner has been changed successfully.')
    ));
  }
  
  
  public function claimAction() {
  
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesgroup_admin_main', array(), 'sesgroup_admin_main_claim');

    $this->view->formFilter = $formFilter = new Sesgroup_Form_Admin_Claim_Filter();
      
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesgroupClaim = Engine_Api::_()->getItem('sesgroup_claim', $value);
          $sesgroupClaim->delete();
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
    $groupClaimTable = Engine_Api::_()->getDbTable('claims', 'sesgroup');
    $groupClaimTableName = $groupClaimTable->info('name');
    $select = $groupClaimTable->select()
    ->setIntegrityCheck(false)
    ->from($groupClaimTableName)
    ->joinLeft($tableUserName, "$groupClaimTableName.user_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($groupClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    $select->where($groupClaimTableName . '.status = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
    $select->where($groupClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
    $this->view->claimItem = Engine_Api::_()->getItem('sesgroup_claim', $claimId);
  }
  
  
  public function approveClaimAction() {
  
    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('sesgroup_claim', $claimId);
    $groupItem = Engine_Api::_()->getItem('sesgroup_group', $claimItem->group_id);
    $currentOwnerId = $groupItem->owner_id;
    $this->view->form = $form = new Sesgroup_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();
    
		if (!$this->getRequest()->isPost()) {
      return;
		}
		
		if (!$form->isValid($this->getRequest()->getPost())) {
      return;
		}
    
    $viewer = Engine_Api::_()->user()->getViewer();

		if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {

      Engine_Api::_()->sesgroup()->updateNewOwnerId(array('newuser_id' => $claimItem->user_id, 'olduser_id' => $groupItem->owner_id, 'group_id' => $groupItem->group_id));
			
			$db->update('engine4_sesgroup_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));

			$fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
			$fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
			$mailDataClaimOwner = array('sender_title' => $fromName);
			$bodyForClaimOwner = '';
			$bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			$bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataClaimOwner['message'] = $bodyForClaimOwner;
		  Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'sesgroup_claim_owner_approve', $mailDataClaimOwner);
			$mailDataGroupOwner = array('sender_title' => $fromName);
			$bodyForGroupOwner = '';
			$bodyForGroupOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
			$bodyForGroupOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
			$bodyForGroupOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataGroupOwner['message'] = $bodyForGroupOwner;
			$groupOwnerId = Engine_Api::_()->getItem('sesgroup_group', $claimItem->group_id)->owner_id;
			$groupOwnerEmail = Engine_Api::_()->getItem('user', $groupOwnerId)->email;
			$claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
			$groupOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($groupOwnerEmail, 'sesgroup_group_owner_approve', $mailDataGroupOwner);
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $groupItem, 'sesgroup_claim_approve');
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($groupOwner, $viewer, $groupItem, 'sesgroup_owner_informed');
		}
		elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_sesgroup_claims', array("claim_id = ?" => $claimItem->claim_id));
		  Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $groupItem, 'sesgroup_claim_declined');
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
