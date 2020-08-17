<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespoke_admin_main', array(), 'sespoke_admin_main_manage');

    // Process form
    $values = array();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $poke = Engine_Api::_()->getItem('sespoke_poke', $value);
          $poke->delete();
        }
      }
    }

    $select = Engine_Api::_()->getDbtable('pokes', 'sespoke')->select()->order('poke_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $poke = Engine_Api::_()->getItem('sespoke_poke', $this->_getParam('id'));
        $poke->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Entry deleted successfully.')
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }

}
