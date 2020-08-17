<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_manage');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_manage', array(), 'estore_admin_main_managestore');
    $this->view->formFilter = $formFilter = new Estore_Form_Admin_Filter();
    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $store = Engine_Api::_()->getItem('stores', $value);
            Engine_Api::_()->estore()->deleteStore($store);
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
    $storeTable = Engine_Api::_()->getDbTable('stores', 'estore');
    $storesTableName = $storeTable->info('name');
    $select = $storeTable->select()
            ->setIntegrityCheck(false)
            ->from($storesTableName)
            ->joinLeft($tableUserName, "$storesTableName.owner_id = $tableUserName.user_id", 'username')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'store_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
      $select->where($storesTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['category_id']))
      $select->where($storesTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($storesTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($storesTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($storesTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($storesTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($storesTableName . '.verified = ?', $_GET['verified']);

//     if (isset($_GET['store_type']) && $_GET['store_type'] != '')
//       $select->where($storesTableName . '.store_type = ?', $_GET['store_type']);

    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($storesTableName . '.hot = ?', $_GET['hot']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($storesTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($storesTableName . '.is_approved = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
      $select->where($storesTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
    $this->view->estore_id = $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();

    if ($type == 'stores') {
      $item = Engine_Api::_()->getItem('stores', $id);
      $form->setTitle('Delete Store?');
      $form->setDescription('Are you sure that you want to delete this store? It will not be recoverable after being deleted.');
      $form->submit->setLabel('Delete');
    }

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->estore()->deleteStore($item);
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
    $store_id = $this->_getParam('id');
    if (!empty($store_id)) {
      $store = Engine_Api::_()->getItem('stores', $store_id);
      $store->featured = !$store->featured;
      $store->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage';
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredAction() {
    $store_id = $this->_getParam('id');
    if (!empty($store_id)) {
      $store = Engine_Api::_()->getItem('stores', $store_id);
      $store->sponsored = !$store->sponsored;
      $store->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function verifyAction() {
    $store_id = $this->_getParam('id');
    if (!empty($store_id)) {
      $store = Engine_Api::_()->getItem('stores', $store_id);
      $store->verified = !$store->verified;
      $store->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function hotAction() {
    $store_id = $this->_getParam('id');
    if (!empty($store_id)) {
      $store = Engine_Api::_()->getItem('stores', $store_id);
      $store->hot = !$store->hot;
      $store->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage';
    $this->_redirect($url);
  }

  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Estore_Form_Admin_Oftheday();
    if ($type == 'stores') {
      $item = Engine_Api::_()->getItem('stores', $id);
      $form->setTitle("Store of the Day");
      $form->setDescription('Here, choose the start date and end date for this store to be displayed as "Store of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Store of the Day");
      $table = 'engine4_estore_stores';
      $item_id = 'store_id';
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
    $this->view->item = Engine_Api::_()->getItem('stores', $this->_getParam('id', null));
  }

  //Approved Action
  public function approvedAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $store_id = $this->_getParam('id');
    if (!empty($store_id)) {
      $store = Engine_Api::_()->getItem('stores', $store_id);
      $store->is_approved = !$store->is_approved;
      $store->save();
      if ($store->is_approved) {
        $mailType = 'estore_store_adminapproved';
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $getActivity = $activityApi->getActionsByObject($store);
        if (!count($getActivity)) {
          $action = $activityApi->addActivity($viewer, $store, 'estore_create');
          if ($action) {
            $activityApi->attachActivity($action, $store);
          }
        }
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($store->getOwner(), $viewer, $store, 'estore_store_adminaapr');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($store->getOwner(), 'notify_estore_store_storesentforapproval', array('store_title' => $store->getTitle(), 'storeowner_title' => $store->getOwner()->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } else {
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($store->getOwner(), $viewer, $store, 'estore_store_admindisapr');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($store->getOwner(), 'notify_estore_store_disapprovedbyadmin', array('store_title' => $store->getTitle(), 'storeowner_title' => $store->getOwner()->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
    }
    $this->_redirect('admin/estore/manage');
  }

  public function changeOwnerAction() {
    $this->_helper->layout->setLayout('admin-simple');
    if (!$this->_getParam('id', null))
      return;
    $this->view->store = $store = Engine_Api::_()->getItem('stores', $this->_getParam('id', null));
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->estore()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $store->owner_id, 'store_id' => $store->store_id));
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Owner has been changed successfully.')
    ));
  }


  public function claimAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_claim');
    $this->view->formFilter = $formFilter = new Estore_Form_Admin_Claim_Filter();

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $estoreClaim = Engine_Api::_()->getItem('estore_claim', $value);
          $estoreClaim->delete();
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
    $storeClaimTable = Engine_Api::_()->getDbTable('claims', 'estore');
    $storeClaimTableName = $storeClaimTable->info('name');
    $select = $storeClaimTable->select()
                            ->setIntegrityCheck(false)
                            ->from($storeClaimTableName)
                            ->joinLeft($tableUserName, "$storeClaimTableName.user_id = $tableUserName.user_id", 'username')
                            ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
    $select->where($storeClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    $select->where($storeClaimTableName . '.status = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
    $select->where($storeClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
    $this->view->claimItem = Engine_Api::_()->getItem('estore_claim', $claimId);
  }


  public function approveClaimAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('estore_claim', $claimId);
    $storeItem = Engine_Api::_()->getItem('stores', $claimItem->store_id);
    $currentOwnerId = $storeItem->owner_id;
    $this->view->form = $form = new Estore_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();

		if (!$this->getRequest()->isPost()) {
      return;
		}

		if (!$form->isValid($this->getRequest()->getPost())) {
      return;
		}

    $viewer = Engine_Api::_()->user()->getViewer();

		if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {

      Engine_Api::_()->estore()->updateNewOwnerId(array('newuser_id' => $claimItem->user_id, 'olduser_id' => $storeItem->owner_id, 'store_id' => $storeItem->store_id));

			$db->update('engine4_estore_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));

			$fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
			$fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
			$mailDataClaimOwner = array('sender_title' => $fromName);
			$bodyForClaimOwner = '';
			$bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			$bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataClaimOwner['message'] = $bodyForClaimOwner;
		  Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'estore_claim_owner_approve', $mailDataClaimOwner);
			$mailDataStoreOwner = array('sender_title' => $fromName);
			$bodyForStoreOwner = '';
			$bodyForStoreOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
			$bodyForStoreOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
			$bodyForStoreOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataStoreOwner['message'] = $bodyForStoreOwner;
			$storeOwnerId = Engine_Api::_()->getItem('stores', $claimItem->store_id)->owner_id;
			$storeOwnerEmail = Engine_Api::_()->getItem('user', $storeOwnerId)->email;
			$claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
			$storeOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($storeOwnerEmail, 'estore_store_owner_approve', $mailDataStoreOwner);
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $storeItem, 'estore_claim_approve');
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($storeOwner, $viewer, $storeItem, 'estore_owner_informed');
		}
		elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_estore_claims', array("claim_id = ?" => $claimItem->claim_id));
		  Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $storeItem, 'estore_claim_declined');
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

   public function wishlistAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesproduct_admin_main', array(), 'sesproduct_admin_main_managewishlists');

    $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_Wishlist();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $value);
          $wishlist->delete();
        }
      }
      $this->_redirect('admin/sesproduct/manage/wishlist');
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
    $productTable = Engine_Api::_()->getDbTable('wishlists', 'sesproduct');
    $productTableName = $productTable->info('name');
    $select = $productTable->select()
                            ->setIntegrityCheck(false)
                            ->from($productTableName)
                            ->joinLeft($tableUserName, "$productTableName.owner_id = $tableUserName.user_id", 'username')
                            ->order((!empty($_GET['order']) ? $_GET['order'] : 'product_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
    $select->where($productTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

//     if (!empty($_GET['category_id']))
//     $select->where($productTableName . '.category_id =?', $_GET['category_id']);
//
//     if (!empty($_GET['subcat_id']))
//       $select->where($productTableName . '.subcat_id =?', $_GET['subcat_id']);
//
//     if (!empty($_GET['subsubcat_id']))
//       $select->where($productTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['is_featured']) && $_GET['is_featured'] != '')
    $select->where($productTableName . '.is_featured = ?', $_GET['is_featured']);

    if (isset($_GET['is_sponsored']) && $_GET['is_sponsored'] != '')
    $select->where($productTableName . '.is_sponsored = ?', $_GET['is_sponsored']);

    if (isset($_GET['package_id']) && $_GET['package_id'] != '')
    $select->where($productTableName . '.package_id = ?', $_GET['package_id']);

//     if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
//     $select->where($productTableName . '.offtheday = ?', $_GET['offtheday']);

//     if (isset($_GET['rating']) && $_GET['rating'] != '') {
//       if ($_GET['rating'] == 1):
//       $select->where($productTableName . '.rating <> ?', 0);
//       elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
//       $select->where($productTableName . '.rating = ?', $_GET['rating']);
//       endif;
//     }

    if (!empty($_GET['creation_date']))
    $select->where($productTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

// 		if (isset($_GET['subcat_id'])) {
// 			$formFilter->subcat_id->setValue($_GET['subcat_id']);
// 			$this->view->category_id = $_GET['category_id'];
// 		}
//
//     if (isset($_GET['subsubcat_id'])) {
// 			$formFilter->subsubcat_id->setValue($_GET['subsubcat_id']);
// 			$this->view->subcat_id = $_GET['subcat_id'];
//     }
   // echo $select;die;
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
}
