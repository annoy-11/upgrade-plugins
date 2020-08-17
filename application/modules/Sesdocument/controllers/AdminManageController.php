<?php


class Sesdocument_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdocument_admin_main', array(), 'sesdocument_admin_main_manage');
    $this->view->formFilter = $formFilter = new Sesdocument_Form_Admin_Filter();

    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $page = Engine_Api::_()->getItem('sesdocument', $value);
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
    $pageTable = Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument');
    $documentTableName = $pageTable->info('name');
    $select = $pageTable->select()
            ->setIntegrityCheck(false)
            ->from($documentTableName)
            ->joinLeft($tableUserName, "$documentTableName.user_id = $tableUserName.user_id", 'username')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'sesdocument_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
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

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($documentTableName . '.verified = ?', $_GET['verified']);


    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($documentTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($documentTableName . '.is_approved = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
      $select->where($documentTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
      

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
      $select->where($documentTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
      $select->where($documentTableName . '.rating = ?', $_GET['rating']);
      endif;
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
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->sesevent_id = $id = $this->_getParam('id');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Document?');
    $form->setDescription('Are you sure that you want to delete this document? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $event = Engine_Api::_()->getItem('sesdocument', $id);
        $event->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully delete document.')
      ));
    }
  }


  //Featured Action
  public function featuredAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sesdocument', $page_id);
      $page->featured = !$page->featured;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesdocument/manage';
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sesdocument', $page_id);
      $page->sponsored = !$page->sponsored;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesdocument/manage';
    $this->_redirect($url);
  }

  //Verify Action
  public function verifyAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sesdocument', $page_id);
      $page->verified = !$page->verified;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sesdocument/manage';
    $this->_redirect($url);
  }


  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Sesdocument_Form_Admin_Oftheday();
    if ($type == 'sesdocument') {
      $item = Engine_Api::_()->getItem('sesdocument', $id);
      $form->setTitle("Document of the Day");
      $form->setDescription('Here, choose the start date and end date for this document to be displayed as "Document of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Document of the Day");
      $table = 'engine4_sesdocument_sesdocuments';
      $item_id = 'sesdocument_id';
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
        $db->update($table, array('startdate' => '', 'enddate' =>''), array("$item_id = ?" => $id));
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
    $this->view->item = Engine_Api::_()->getItem('sesdocument', $this->_getParam('id', null));
  }

  //Approved Action
  public function approvedAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('sesdocument', $page_id);
      $page->is_approved = !$page->is_approved;
      $page->save();
      if ($page->is_approved) {
        $mailType = 'sesdocument_adminapproved';
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $getActivity = $activityApi->getActionsByObject($page);
        if (!count($getActivity)) {
          $action = $activityApi->addActivity($viewer, $page, 'sesdocument_create');
          if ($action) {
            $activityApi->attachActivity($action, $page);
          }
        }
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($page->getOwner(), $viewer, $page, 'sesdocument_adminapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), 'notify_sesdocument_approvedbyadmin', array('page_title' => $page->getTitle(), 'pageowner_title' => $page->getOwner()->getTitle(), 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } else {
        $mailType = 'sesdocument_admindisapproved';
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($page->getOwner(), $viewer, $page, 'sesdocument_admindisapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), 'notify_sesdocument_disapprovedbyadmin', array('page_title' => $page->getTitle(), 'pageowner_title' => $page->getOwner()->getTitle(), 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
      //Page approved mail send to page owner
      //Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), $mailType, array('member_name' => $page->getOwner()->getTitle(), 'page_title' => $page->title, 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    }
    $this->_redirect('admin/sesdocument/manage');
  }

  


  


  
}
