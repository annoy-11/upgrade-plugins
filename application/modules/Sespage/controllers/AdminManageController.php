<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_manage');
    $this->view->formFilter = $formFilter = new Sespage_Form_Admin_Filter();
    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $page = Engine_Api::_()->getItem('sespage_page', $value);
          $page->delete();
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
    $pageTable = Engine_Api::_()->getDbTable('pages', 'sespage');
    $pagesTableName = $pageTable->info('name');
    $select = $pageTable->select()
            ->setIntegrityCheck(false)
            ->from($pagesTableName)
            ->joinLeft($tableUserName, "$pagesTableName.owner_id = $tableUserName.user_id", 'username')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'page_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
      $select->where($pagesTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['category_id']))
      $select->where($pagesTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($pagesTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($pagesTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($pagesTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($pagesTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($pagesTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['page_type']) && $_GET['page_type'] != '')
      $select->where($pagesTableName . '.page_type = ?', $_GET['page_type']);

    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($pagesTableName . '.hot = ?', $_GET['hot']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($pagesTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($pagesTableName . '.is_approved = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
      $select->where($pagesTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->sespage_id = $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();

    if ($type == 'sespage_page') {
      $item = Engine_Api::_()->getItem('sespage_page', $id);
      $form->setTitle('Delete Page?');
      $form->setDescription('Are you sure that you want to delete this page? It will not be recoverable after being deleted.');
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
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sespage_page', $page_id);
      $page->featured = !$page->featured;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sespage/manage';
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sespage_page', $page_id);
      $page->sponsored = !$page->sponsored;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sespage/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function verifyAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sespage_page', $page_id);
      $page->verified = !$page->verified;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sespage/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function hotAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sespage_page', $page_id);
      $page->hot = !$page->hot;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sespage/manage';
    $this->_redirect($url);
  }

  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Sespage_Form_Admin_Oftheday();
    if ($type == 'sespage_page') {
      $item = Engine_Api::_()->getItem('sespage_page', $id);
      $form->setTitle("Page of the Day");
      $form->setDescription('Here, choose the start date and end date for this page to be displayed as "Page of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Page of the Day");
      $table = 'engine4_sespage_pages';
      $item_id = 'page_id';
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
    $this->view->item = Engine_Api::_()->getItem('sespage_page', $this->_getParam('id', null));
  }

  //Approved Action
  public function approvedAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sespage_page', $page_id);
      $page->is_approved = !$page->is_approved;
      $page->save();
      if ($page->is_approved) {
        $mailType = 'sespage_page_adminapproved';
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $getActivity = $activityApi->getActionsByObject($page);
        if (!count($getActivity)) {
          $action = $activityApi->addActivity($viewer, $page, 'sespage_create');
          if ($action) {
            $activityApi->attachActivity($action, $page);
          }
        }
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($page->getOwner(), $viewer, $page, 'sespage_page_adminapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), 'notify_sespage_page_approvedbyadmin', array('page_title' => $page->getTitle(), 'pageowner_title' => $page->getOwner()->getTitle(), 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } else {
        $mailType = 'sespage_page_admindisapproved';
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($page->getOwner(), $viewer, $page, 'sespage_page_admindisapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), 'notify_sespage_page_disapprovedbyadmin', array('page_title' => $page->getTitle(), 'pageowner_title' => $page->getOwner()->getTitle(), 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
      //Page approved mail send to page owner
      //Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), $mailType, array('member_name' => $page->getOwner()->getTitle(), 'page_title' => $page->title, 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    }
    $this->_redirect('admin/sespage/manage');
  }

  public function changeOwnerAction() {
    $this->_helper->layout->setLayout('admin-simple');
    if (!$this->_getParam('id', null))
      return;
    $this->view->page = $page = Engine_Api::_()->getItem('sespage_page', $this->_getParam('id', null));
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->sespage()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $page->owner_id, 'page_id' => $page->page_id));
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Owner has been changed successfully.')
    ));
  }


  public function claimAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_claim');

    $this->view->formFilter = $formFilter = new Sespage_Form_Admin_Claim_Filter();

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sespageClaim = Engine_Api::_()->getItem('sespage_claim', $value);
          $sespageClaim->delete();
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
    $pageClaimTable = Engine_Api::_()->getDbTable('claims', 'sespage');
    $pageClaimTableName = $pageClaimTable->info('name');
    $select = $pageClaimTable->select()
    ->setIntegrityCheck(false)
    ->from($pageClaimTableName)
    ->joinLeft($tableUserName, "$pageClaimTableName.user_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($pageClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    $select->where($pageClaimTableName . '.status = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
    $select->where($pageClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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

  public function showDetailAction() {
    $claimId = $this->_getParam('id');
    $this->view->claimItem = Engine_Api::_()->getItem('sespage_claim', $claimId);
  }


  public function approveClaimAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('sespage_claim', $claimId);
    $pageItem = Engine_Api::_()->getItem('sespage_page', $claimItem->page_id);
    $currentOwnerId = $pageItem->owner_id;
    $this->view->form = $form = new Sespage_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();

		if (!$this->getRequest()->isPost()) {
      return;
		}

		if (!$form->isValid($this->getRequest()->getPost())) {
      return;
		}

    $viewer = Engine_Api::_()->user()->getViewer();

		if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {

      Engine_Api::_()->sespage()->updateNewOwnerId(array('newuser_id' => $claimItem->user_id, 'olduser_id' => $pageItem->owner_id, 'page_id' => $pageItem->page_id));

			$db->update('engine4_sespage_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));

			$fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
			$fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
			$mailDataClaimOwner = array('sender_title' => $fromName);
			$bodyForClaimOwner = '';
			$bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			$bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataClaimOwner['message'] = $bodyForClaimOwner;
		  Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'sespage_claim_owner_approve', $mailDataClaimOwner);
			$mailDataPageOwner = array('sender_title' => $fromName);
			$bodyForPageOwner = '';
			$bodyForPageOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
			$bodyForPageOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
			$bodyForPageOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataPageOwner['message'] = $bodyForPageOwner;
			$pageOwnerId = Engine_Api::_()->getItem('sespage_page', $claimItem->page_id)->owner_id;
			$pageOwnerEmail = Engine_Api::_()->getItem('user', $pageOwnerId)->email;
			$claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
			$pageOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($pageOwnerEmail, 'sespage_page_owner_approve', $mailDataPageOwner);
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $pageItem, 'sespage_claim_approve');
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($pageOwner, $viewer, $pageItem, 'sespage_owner_informed');
		}
		elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_sespage_claims', array("claim_id = ?" => $claimItem->claim_id));
		  Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $pageItem, 'sespage_claim_declined');
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
