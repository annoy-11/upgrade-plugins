<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('edocument_admin_main', array(), 'edocument_admin_main_manage');

    $this->view->formFilter = $formFilter = new Edocument_Form_Admin_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $edocument = Engine_Api::_()->getItem('edocument', $value);
            Engine_Api::_()->edocument()->deleteDocument($edocument);
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

    $documentTable = Engine_Api::_()->getDbTable('edocuments', 'edocument');
    $documentTableName = $documentTable->info('name');

    $select = $documentTable->select()
                            ->setIntegrityCheck(false)
                            ->from($documentTableName)
                            ->joinLeft($tableUserName, "$documentTableName.owner_id = $tableUserName.user_id", 'username')
                            ->order((!empty($_GET['order']) ? $_GET['order'] : 'edocument_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
        $select->where($documentTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
        $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['category_id']))
      $select->where($documentTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($documentTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($documentTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
    $select->where($documentTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
    $select->where($documentTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['status']) && $_GET['status'] != '')
    $select->where($documentTableName . '.draft = ?', $_GET['status']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
        $select->where($documentTableName . '.is_approved = ?', $_GET['is_approved']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
    $select->where($documentTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
    $select->where($documentTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
        $select->where($documentTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
        $select->where($documentTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
    $select->where($documentTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->edocument_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $edocument = Engine_Api::_()->getItem('edocument', $id);
        // delete the edocument entry into the database
        Engine_Api::_()->edocument()->deleteDocument($edocument);
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

//   public function approvedAction() {
//     $viewer = Engine_Api::_()->user()->getViewer();
//     $edocument_id = $this->_getParam('id');
//     if (!empty($edocument_id)) {
//       $edocument = Engine_Api::_()->getItem('edocument', $edocument_id);
//       $edocument->is_approved = !$edocument->is_approved;
//       $edocument->save();
//       if ($edocument->is_approved) {
//         $mailType = 'edocument_adminapproved';
//         $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
//         $getActivity = $activityApi->getActionsByObject($edocument);
//         if (!count($getActivity)) {
//           $action = $activityApi->addActivity($viewer, $edocument, 'edocument_create');
//           if ($action) {
//             $activityApi->attachActivity($action, $edocument);
//           }
//         }
//         Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($edocument->getOwner(), $viewer, $edocument, 'edocument_adminapproved');
//
//         Engine_Api::_()->getApi('mail', 'core')->sendSystem($edocument->getOwner(), 'notify_edocument_approvedbyadmin', array('document_title' => $edocument->getTitle(), 'pageowner_title' => $edocument->getOwner()->getTitle(), 'object_link' => $edocument->getHref(), 'host' => $_SERVER['HTTP_HOST']));
//       } else {
//         $mailType = 'edocument_admindisapproved';
//         Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($edocument->getOwner(), $viewer, $edocument, 'edocument_admindisapproved');
//
//         Engine_Api::_()->getApi('mail', 'core')->sendSystem($edocument->getOwner(), 'notify_edocument_disapprovedbyadmin', array('page_title' => $edocument->getTitle(), 'pageowner_title' => $edocument->getOwner()->getTitle(), 'object_link' => $edocument->getHref(), 'host' => $_SERVER['HTTP_HOST']));
//       }
//     }
//     $this->_redirect('admin/edocument/manage');
//   }

  //Approved Action
  public function approvedAction() {

    $edocument_id = $this->_getParam('id');
    if (!empty($edocument_id)) {
      $edocument = Engine_Api::_()->getItem('edocument', $edocument_id);
      $edocument->is_approved = !$edocument->is_approved;
      $edocument->save();
      if ($edocument->is_approved) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $getActivity = $activityApi->getActionsByObject($edocument);
        if (!count($getActivity)) {
          $action = $activityApi->addActivity($viewer, $edocument, 'edocument_new');
          if ($action) {
            $activityApi->attachActivity($action, $edocument);
          }
        }
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($edocument->getOwner(), $viewer, $edocument, 'edocument_adminapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($edocument->getOwner(), 'notify_edocument_approvedbyadmin', array('document_title' => $edocument->getTitle(), 'documentowner_title' => $edocument->getOwner()->getTitle(), 'object_link' => $edocument->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } else {
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($edocument->getOwner(), $viewer, $edocument, 'edocument_admindisapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($edocument->getOwner(), 'notify_edocument_disapprovedbyadmin', array('document_title' => $edocument->getTitle(), 'documentowner_title' => $edocument->getOwner()->getTitle(), 'object_link' => $edocument->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
    }
    $this->_redirect('admin/edocument/manage');
  }

  //Featured Action
  public function featuredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('edocument', $event_id);
      $event->featured = !$event->featured;
      $event->save();
    }
    $this->_redirect('admin/edocument/manage');
  }


  //Sponsored Action
  public function sponsoredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('edocument', $event_id);
      $event->sponsored = !$event->sponsored;
      $event->save();
    }
    $this->_redirect('admin/edocument/manage');
  }

  //Verify Action
  public function verifyAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('edocument', $event_id);
      $event->verified = !$event->verified;
      $event->save();
    }
    $this->_redirect('admin/edocument/manage');
  }

  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Edocument_Form_Admin_Oftheday();

    $item = Engine_Api::_()->getItem('edocument', $id);

    $form->setTitle("Document of the Day");
    $form->setDescription('Here, choose the start date and end date for this document to be displayed as "Document of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Document of the Day");

    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update('engine4_edocument_documents', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("edocument_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_edocument_documents', array('offtheday' => 0, 'starttime' => '', 'endtime' => ''), array("edocument_id = ?" => $id));
      } else {
        $db->update('engine4_edocument_documents', array('offtheday' => 1), array("edocument_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }

  public function viewAction() {
    $this->view->item = $item = Engine_Api::_()->getItem('edocument', $this->_getParam('id', null));
  }
}
