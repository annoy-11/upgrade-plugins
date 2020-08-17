<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_sespageoffer');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespageoffer_admin_main', array(), 'sespageoffer_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sespageoffer_Form_Admin_Manage_Filter();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams())) {
      $values = $formFilter->getValues();
    }
    foreach ($_GET as $key => $value) {
      if ('' === $value) {
        unset($_GET[$key]);
      } else
        $values[$key] = $value;
    }
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $offer = Engine_Api::_()->getItem('pageoffer', $value);
          Engine_Api::_()->getApi('core', 'sespageoffer')->deleteOffer($offer);
          //Engine_Api::_()->getItem('pageoffer', $value)->delete();
        }
      }
    }

    $table = Engine_Api::_()->getDbtable('pageoffers', 'sespageoffer');
    $tableName = $table->info('name');

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $tablePageName = Engine_Api::_()->getItemTable('sespage_page')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
						->joinLeft($tablePageName, "$tablePageName.page_id = $tableName.parent_id", 'page_id');

    $select->where($tablePageName.'.page_id != ?','');
    $select->order('pageoffer_id DESC');
    // Set up select info
    if (!empty($_GET['title']))
      $select->where($tableName.'.title LIKE ?', '%' . $values['title'] . '%');

		if (!empty($_GET['page_title']))
      $select->where($tablePageName.'.title LIKE ?', '%' . $values['page_title'] . '%');

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($tableName.'.featured = ?', $values['featured']);

    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($tableName.'.hot = ?', $values['hot']);

	 if (isset($_GET['new']) && $_GET['new'] != '')
      $select->where($tableName.'.new = ?', $values['new']);

    if (!empty($values['creation_date']))
      $select->where($tableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($tableName . '.offtheday =?', $values['offtheday']);

    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }

  //Featured Action
  public function featuredAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('pageoffer', $page_id);
      $page->featured = !$page->featured;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sespageoffer/manage';
    $this->_redirect($url);
  }

  //Hot Action
  public function hotAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('pageoffer', $page_id);
      $page->hot = !$page->hot;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sespageoffer/manage';
    $this->_redirect($url);
  }

  //New Action
  public function newAction() {
    $page_id = $this->_getParam('id');
    if (!empty($page_id)) {
      $page = Engine_Api::_()->getItem('pageoffer', $page_id);
      $page->new = !$page->new;
      $page->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/sespageoffer/manage';
    $this->_redirect($url);
  }


  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Offer?');
    $form->setDescription('Are you sure that you want to delete this offer? It will not be recoverable after being deleted. ');
    $form->submit->setLabel('Delete');

    $id = $this->_getParam('id');
    $this->view->offer_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $offer = Engine_Api::_()->getItem('pageoffer', $id);
        Engine_Api::_()->getApi('core', 'sespageoffer')->deleteOffer($offer);
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
  }

  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Sespageoffer_Form_Admin_Oftheday();
    if ($type == 'pageoffer') {
      $item = Engine_Api::_()->getItem('pageoffer', $id);
      $form->setTitle("Offer of the Day");
      $form->setDescription('Here, choose the start date and end date for this offer to be displayed as "Offer of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Offer of the Day");
      $table = 'engine4_sespageoffer_pageoffers';
      $item_id = 'pageoffer_id';
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
}
