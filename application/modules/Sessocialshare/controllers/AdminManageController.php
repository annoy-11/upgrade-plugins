<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_AdminManageController extends Core_Controller_Action_Admin {

  public function manageAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialshare_admin_main', array(), 'sessocialshare_admin_main_manage');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('socialicons', 'sessocialshare')->getSocialInfo();
  }
  
  public function orderManageAction() {

    if (!$this->getRequest()->isPost())
      return;

    $socialiconsTable = Engine_Api::_()->getDbtable('socialicons', 'sessocialshare');
    $socialicons = $socialiconsTable->fetchAll($socialiconsTable->select());
    foreach ($socialicons as $managesearchoption) {

      $order = $this->getRequest()->getParam('managesocialicons_' . $managesearchoption->socialicon_id);

      if (!$order)
        $order = 999;
      $managesearchoption->order = $order;
      $managesearchoption->save();
    }
    return;
  }

  public function enabledAction() {

    $id = $this->_getParam('socialicon_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sessocialshare_socialicons', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sessocialshare/manage/manage');
  }

  public function editAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $socialicons = Engine_Api::_()->getItem('sessocialshare_socialicons', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sessocialshare_socialicons')
            ->where('socialicon_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sessocialshare_Form_Admin_Edit();
    
    $translate = Zend_Registry::get('Zend_Translate');
    if ($socialicons->title)
      $form->title->setValue($translate->translate($socialicons->title));

    if ($this->getRequest()->isPost()) {
    
      $values = $form->getValues();
      
      $db->update('engine4_sessocialshare_socialicons', array('title' => $_POST['title']), array('socialicon_id = ?' => $id));

//       if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
// 
//         $photoFile = Engine_Api::_()->sessocialshare()->setPhoto($_FILES['photo'], $id);
//         if (!empty($photoFile->file_id)) {
//           $previous_file_id = $menu->file_id;
//           $db->update('engine4_sessocialshare_socialicons', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('socialicon_id = ?' => $id));
//           $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
//           if (!empty($file))
//             $file->delete();
//         }
//       }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessocialshare', 'controller' => 'manage', 'action' => 'manage'), 'admin_default', true);
      return $this->_forward('success', 'utility', 'core', array(
        'parentRedirect' => $redirectUrl,
        'messages' => 'You have successfully edit details.',
      ));
    }
  }
}
