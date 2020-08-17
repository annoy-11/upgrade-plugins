<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminManagepetitionController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_AdminManagepetitionController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_managepetition');

    $this->view->formFilter = $formFilter = new Epetition_Form_Admin_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $epetition = Engine_Api::_()->getItem('epetition', $value);
          Engine_Api::_()->epetition()->deletePetition($epetition);
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
    $petitionTable = Engine_Api::_()->getDbTable('epetitions', 'epetition');
    $petitionTableName = $petitionTable->info('name');
    $select = $petitionTable->select()
      ->setIntegrityCheck(false)
      ->from($petitionTableName)
      ->joinLeft($tableUserName, "$petitionTableName.owner_id = $tableUserName.user_id", 'username')
      ->order((!empty($_GET['order']) ? $_GET['order'] : 'epetition_id') . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC'));
    if (!empty($_GET['name']))
      $select->where($petitionTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['category_id']))
      $select->where($petitionTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($petitionTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($petitionTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($petitionTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($petitionTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['status']) && $_GET['status'] != '')
      $select->where($petitionTableName . '.draft = ?', $_GET['status']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($petitionTableName . '.is_approved = ?', $_GET['is_approved']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($petitionTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($petitionTableName . '.offtheday = ?', $_GET['offtheday']);

    if (!empty($_GET['creation_date']))
      $select->where($petitionTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    if (isset($_GET['subcat_id'])) {
      $formFilter->subcat_id->setValue($_GET['subcat_id']);
      $this->view->category_id = $_GET['category_id'];
    }

    if (isset($_GET['subsubcat_id'])) {
      $formFilter->subsubcat_id->setValue($_GET['subsubcat_id']);
      $this->view->subcat_id = $_GET['subcat_id'];
    }

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
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
    $this->view->epetition_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $epetition = Engine_Api::_()->getItem('epetition', $id);
        // delete the epetition entry into the database
        Engine_Api::_()->epetition()->deletePetition($epetition);
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-managepetition/delete.tpl');
  }

  //Approved Action
  public function approvedAction()
  {
    $epetition_id = $this->_getParam('id');
    if (!empty($epetition_id)) {
      $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);
      $epetition->is_approved = !$epetition->is_approved;
      $epetition->save();
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($epetition);
      if (count($action->toArray()) <= 0 && (!$epetition->publish_date || strtotime($epetition->publish_date) <= time())) {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $sender = Engine_Api::_()->getItem('user', $viewer_id);
        $viewer = Engine_Api::_()->getItem('user', $epetition->owner_id);
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sender, $epetition, 'epetition_new');
        // make sure action exists before attaching the epetition to the activity
        if ($action) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
        }
      }
    }
    $this->_redirect('admin/epetition/managepetition');
  }

  //Featured Action
  public function featuredAction()
  {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('epetition', $event_id);
      $event->featured = !$event->featured;
      $event->save();
    }
    $this->_redirect('admin/epetition/managepetition');
  }


  //Sponsored Action
  public function sponsoredAction()
  {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('epetition', $event_id);
      $event->sponsored = !$event->sponsored;
      $event->save();
    }
    $this->_redirect('admin/epetition/managepetition');
  }

  //Verify Action
  public function verifyAction()
  {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('epetition', $event_id);
      $event->verified = !$event->verified;
      $event->save();
    }
    $this->_redirect('admin/epetition/managepetition');
  }

  public function ofthedayAction()
  {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Epetition_Form_Admin_Oftheday();
    $item = Engine_Api::_()->getItem('epetition', $id);
    $form->setTitle("Petition of the Day");
    $form->setDescription('Here, choose the start date and end date for this petition to be displayed as "Petition of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Petition of the Day");

    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d', strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update('engine4_epetition_petitions', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("epetition_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_epetition_petitions', array('offtheday' => 0), array("epetition_id = ?" => $id));
      } else {
        $db->update('engine4_epetition_petitions', array('offtheday' => 1), array("epetition_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Successfully updated the item.')
      ));
    }
  }

  //view item function
  public function viewAction()
  {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('epetition', $id);
    $this->view->item = $item;
  }

}
