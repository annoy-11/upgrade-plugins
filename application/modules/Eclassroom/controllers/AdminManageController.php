<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminManageController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
   $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_mng');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_mng', array(), 'courses_admin_main_mgcls');
    $this->view->formFilter = $formFilter = new Eclassroom_Form_Admin_Filter();
    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $classroom = Engine_Api::_()->getItem('classroom', $value);
            Engine_Api::_()->eclassroom()->deleteClassroom($classroom);
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
    $classroomTable = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
    $classroomTableName = $classroomTable->info('name');
    $select = $classroomTable->select()
            ->setIntegrityCheck(false)
            ->from($classroomTableName,array('classroom_id','is_approved','featured','sponsored','hot','verified','enddate','offtheday','creation_date','custom_url','owner_id','title'))
            ->joinLeft($tableUserName, "$classroomTableName.owner_id = $tableUserName.user_id", 'username')
            ->order($classroomTableName.(!empty($_GET['order']) ? '.'.$_GET['order'] : '.classroom_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['classroom_title']))
      $select->where($classroomTableName . '.title LIKE ?', '%' . $_GET['classroom_title'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (!empty($_GET['category_id']))
      $select->where($classroomTableName . '.category_id =?', $_GET['category_id']);
    if (!empty($_GET['subcat_id']))
      $select->where($classroomTableName . '.subcat_id =?', $_GET['subcat_id']);
    if (!empty($_GET['subsubcat_id']))
      $select->where($classroomTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);
    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($classroomTableName . '.featured = ?', $_GET['featured']);
    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($classroomTableName . '.sponsored = ?', $_GET['sponsored']);
    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($classroomTableName . '.verified = ?', $_GET['verified']);
    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($classroomTableName . '.hot = ?', $_GET['hot']);
    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($classroomTableName . '.offtheday = ?', $_GET['offtheday']);
    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($classroomTableName . '.is_approved = ?', $_GET['is_approved']);
    if (!empty($_GET['date']['date_from']))
        $select->having($classroomTableName . '.creation_date <=?', $_GET['date']['date_from']);
    if (!empty($_GET['date']['date_to']))
        $select->having($classroomTableName . '.creation_date >=?', $_GET['date']['date_to']);
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
    $classroom_id = $this->_getParam('classroom_id',false);
    if(!$classroom_id)
        return;

    $item = Engine_Api::_()->getItem('classroom', $classroom_id);

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
      $form->setTitle('Delete Classroom?');
      $form->setDescription('Are you sure that you want to delete this classroom? It will not be recoverable after being deleted.');
      $form->submit->setLabel('Delete');

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->eclassroom()->deleteClassroom($item);
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
    $classroom_id = $this->_getParam('classroom_id',false);
    $item = Engine_Api::_()->getItem('classroom', $classroom_id);
    $item->featured = !$item->featured;
    if($item->featured){
      $viewer = Engine_Api::_()->user()->getViewer();
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'eclassroom_classroom_featured');
    }
    $item->save();
    $this->_redirect('admin/eclassroom/manage');
  }

  //Sponsored Action
  public function sponsoredAction() {
    $classroom_id = $this->_getParam('classroom_id',false);
    $item = Engine_Api::_()->getItem('classroom', $classroom_id);
    $item->sponsored = !$item->sponsored;
    if($item->sponsored){
      $viewer = Engine_Api::_()->user()->getViewer();
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'eclassroom_classroom_sponsored');
    }
    $item->save();
    $this->_redirect('admin/eclassroom/manage');
  }

  //Verify Action
  public function verifyAction() {
   $classroom_id = $this->_getParam('classroom_id',false);
    $item = Engine_Api::_()->getItem('classroom', $classroom_id);
    $item->verified = !$item->verified;
    if($item->verified){
      $viewer = Engine_Api::_()->user()->getViewer();
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'eclassroom_classroom_verified');
    }
    $item->save();
    $this->_redirect('admin/eclassroom/manage');
  }

  //Verify Action
  public function hotAction() {
    $classroom_id = $this->_getParam('classroom_id',false);
    $item = Engine_Api::_()->getItem('classroom', $classroom_id);
    $item->hot = !$item->hot;
    if($item->hot){
      $viewer = Engine_Api::_()->user()->getViewer();
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'eclassroom_classroom_hot');
    }
    $item->save();
    $this->_redirect('admin/eclassroom/manage');
  }

  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $classroom_id = $this->_getParam('classroom_id',false);
    $id = $classroom_id;
    $item = Engine_Api::_()->getItem('classroom', $classroom_id);
    $table = 'engine4_eclassroom_classrooms';
    $item_id = 'classroom_id';

    $param = $this->_getParam('param');

    $this->view->form = $form = new Eclassroom_Form_Admin_Oftheday();
      $form->setTitle("Classroom of the Day");
      $form->setDescription('Here, choose the start date and end date for this classroom to be displayed as "Classroom of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Classroom of the Day");
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
      $db->update('engine4_eclassroom_classrooms', array('startdate' => $values['startdate'], 'enddate' => $values['enddate']), array("$item_id = ?" => $id));
      if (@$values['remove']) {
        $db->update('engine4_eclassroom_classrooms', array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update('engine4_eclassroom_classrooms', array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

  public function viewAction() {
    $classroom_id = $this->_getParam('classroom_id',false);
    $item = Engine_Api::_()->getItem('classroom', $classroom_id);
    $this->view->item = $item;
  }

  //Approved Action
  public function approvedAction() {
    $classroom_id = $this->_getParam('classroom_id',false);
    $item = Engine_Api::_()->getItem('classroom', $classroom_id);
    $item->is_approved = !$item->is_approved;
    $viewer = Engine_Api::_()->user()->getViewer();
    if($item->is_approved){
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'eclassroom_classsroom_adminaapr');
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($item->getOwner(), 'eclassroom_classroom_adminaapr', array('classroom_name' => $item->getTitle(), 'recipient_title' => $item->getOwner()->getTitle(), 'object_link' => $item->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    } else {
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'eclassroom_classsroom_admindisapr');
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($item->getOwner(), 'eclassroom_classroom_admindisapr', array('classroom_name' => $item->getTitle(), 'recipient_title' => $item->getOwner()->getTitle(), 'object_link' => $item->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    }
    $item->save();
    $this->_redirect('admin/eclassroom/manage');
  }
  public function changeOwnerAction() {
    $this->_helper->layout->setLayout('admin-simple');
    if (!$this->_getParam('id', null))
      return;
    $this->view->classroom = $classroom = Engine_Api::_()->getItem('classroom', $this->_getParam('id', null));
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->eclassroom()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $classroom->owner_id, 'classroom_id' => $classroom->classroom_id));
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Owner has been changed successfully.')
    ));
  }
  public function claimAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'eclassroom_admin_main_claim');
    $this->view->formFilter = $formFilter = new Eclassroom_Form_Admin_Claim_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $eclassroomClaim = Engine_Api::_()->getItem('eclassroom_claim', $value);
          $eclassroomClaim->delete();
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
    $classroomClaimTable = Engine_Api::_()->getDbTable('claims', 'eclassroom');
    $classroomClaimTableName = $classroomClaimTable->info('name');
    $select = $classroomClaimTable->select()
                            ->setIntegrityCheck(false)
                            ->from($classroomClaimTableName)
                            ->joinLeft($tableUserName, "$classroomClaimTableName.user_id = $tableUserName.user_id", 'username')
                            ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
      $select->where($classroomClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($classroomClaimTableName . '.status = ?', $_GET['is_approved']);
    if (!empty($_GET['creation_date']))
      $select->where($classroomClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
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
    $this->view->claimItem = Engine_Api::_()->getItem('eclassroom_claim', $claimId);
  }
  public function approveClaimAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('eclassroom_claim', $claimId);
    $classroomItem = Engine_Api::_()->getItem('classroom', $claimItem->classroom_id);
    $currentOwnerId = $classroomItem->owner_id;
    $this->view->form = $form = new Eclassroom_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();
    if (!$this->getRequest()->isPost()) {
        return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
        return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
   if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {
    Engine_Api::_()->eclassroom()->updateNewOwnerId(array('newuser_id' => $claimItem->user_id, 'olduser_id' => $classroomItem->owner_id, 'classroom_id' => $classroomItem->classroom_id));
        $db->update('engine4_eclassroom_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));
        $fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
        $fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
        $mailDataClaimOwner = array('sender_title' => $fromName);
        $bodyForClaimOwner = '';
        $bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
        $bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
        $mailDataClaimOwner['message'] = $bodyForClaimOwner;
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'eclassroom_claim_owner_approve', $mailDataClaimOwner);
        $mailDataClassroomOwner = array('sender_title' => $fromName);
        $bodyForClassroomOwner = '';
        $bodyForClassroomOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
        if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
        $bodyForClassroomOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
        $bodyForClassroomOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
        $mailDataClassroomOwner['message'] = $bodyForClassroomOwner;
        $classroomOwnerId = Engine_Api::_()->getItem('classroom', $claimItem->classroom_id)->owner_id;
        $classroomOwnerEmail = Engine_Api::_()->getItem('user', $classroomOwnerId)->email;
        $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
        $classroomOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($classroomOwnerEmail, 'eclassroom_classroom_owner_approve', $mailDataClassroomOwner);
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $classroomItem, 'eclassroom_claim_approve');
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($classroomOwner, $viewer, $classroomItem, 'eclassroom_owner_informed');
    } elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_eclassroom_claims', array("claim_id = ?" => $claimItem->claim_id));
		 Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $classroomItem, 'eclassroom_claim_declined');
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
