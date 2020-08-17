<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sestestimonial_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestestimonial_admin_main', array(), 'sestestimonial_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sestestimonial_Form_Admin_Filter();

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();


    $values = array_merge(array('order' => isset($_GET['order']) ? $_GET['order'] :'', 'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : ''), $values);
    $this->view->assign($values);

    $page = $this->_getParam('page',1);


    $table = Engine_Api::_()->getDbTable('testimonials', 'sestestimonial');
    $tableName = $table->info('name');

    $select = $table->select()
              ->setIntegrityCheck(false)
              ->from($tableName)
              ->order((!empty($_GET['order']) ? $_GET['order'] : 'testimonial_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['title']))
      $select->where($tableName . '.title LIKE ?', '%' . $_GET['title'] . '%');

    if (!empty($_GET['description']))
      $select->where($tableName . '.description LIKE ?', '%' . $_GET['description'] . '%');

    if (!empty($_GET['designation']))
      $select->where($tableName . '.designation LIKE ?', '%' . $_GET['designation'] . '%');

    if (!empty($_GET['approve']))
        $select->where($tableName . '.approve = ?', $_GET['approve']);

    if (!empty($_GET['rating']))
    $select->where($tableName . '.rating =?', $_GET['rating']);

    if (!empty($_GET['creation_date']))
    $select->where($tableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  //Delete team member
  public function deleteAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('testimonials', 'sestestimonial')->delete(array('testimonial_id =?' => $this->_getParam('testimonial_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully deleted this entry.'))
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Delete multiple team members
  public function multiDeleteAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $testimonials = Engine_Api::_()->getItem('testimonial', (int) $value);
          if (!empty($testimonials))
            $testimonials->delete();
        }
      }
    }
    $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function approveAction() {

    $id = $this->_getParam('testimonial_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('testimonial', $id);
      $item->approve = !$item->approve;
      $item->save();
    }
    $this->_redirect('admin/sestestimonial/manage');
  }
}
