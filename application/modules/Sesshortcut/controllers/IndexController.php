<?php

class Sesshortcut_IndexController extends Core_Controller_Action_Standard {

  public function editpopupAction() {
    if($_POST) {
      foreach($_POST as $key => $options) {
        $explodeKey = explode('_', $key);
        $shortcut = Engine_Api::_()->getItem('sesshortcut_shortcut', $explodeKey[1]);
        if($options == 1) {
          $shortcut->order = $shortcut->shortcut_id;
          $shortcut->save();
        } elseif($options == 2) {
          $shortcut->order = $shortcut->order;
          $shortcut->save();
        } elseif($options == 3) {
          Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->delete(array('shortcut_id =?' => $explodeKey[1]));
        }
      }
      echo Zend_Json::encode(array('status' => 1));exit();
    }
  }

  public function pintotopAction() {
    
    $shortcut_id = $this->_getParam('shortcut_id', null);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();


    $table = Engine_Api::_()->getDbtable('shortcuts', 'sesshortcut');
    $select = $table->select()->where('poster_id =?', $viewer_id)->where('shortcut_id <>?', $shortcut_id)->order('order ASC');
    $shortcuts = $table->fetchAll();
    foreach ($shortcuts as $shortcuto) {
      $shortcuto->order = $shortcuto->order + 1;
      $shortcuto->save();
    }
    
    $shortcut = Engine_Api::_()->getItem('sesshortcut_shortcut', $shortcut_id);
    $shortcut->order = 1;
    $shortcut->pintotop = 1;
    $shortcut->save();
    return;
  }
  
  public function unpintotopAction() {
    
    $shortcut_id = $this->_getParam('shortcut_id', null);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $shortcut = Engine_Api::_()->getItem('sesshortcut_shortcut', $shortcut_id);
    $shortcut->order = 999;
    $shortcut->pintotop = 0;
    $shortcut->save();
    return;
  }

  public function getAllShortcutsAction() {
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    
    $this->view->user_id = $user_id = $this->_getParam('user_id', 0);
    if (!$user_id)
      return $this->_forward('notfound', 'error', 'core');

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    
    $this->view->titlePage = Zend_Registry::get('Zend_Translate')->_('Edit Shortcuts');
    $this->view->urlpage = 'sesshortcut/index/get-all-shortcuts/user_id';

    $shortCutTable = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut');
    $select = $shortCutTable->select()->where('poster_id = ?', $user_id)->order('shortcut_id DESC');

    $this->view->paginator = $friends = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);
  }
  
  public function addshortcutsAction() {

    if (!$this->_helper->requireUser()->isValid())
      return;
    
    $resource_type = $this->_getParam('resource_type', null);
    $resource_id = $this->_getParam('resource_id', null);
    $viewer = Engine_Api::_()->user()->getViewer();
    if(empty($resource_id) && $empty($resource_type))
      return;
    
    $resource = Engine_Api::_()->getItem($resource_type, $resource_id);

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesshortcut_Form_AddShortcuts();

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $shortcutTable = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut');
    $db = $shortcutTable->getAdapter();
    $db->beginTransaction();
    try {
      $shortcutTable->addShortcut($resource, $viewer)->shortcut_id;
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('This content has been successfully added as Shortcut.'))
    ));
  }
  
  public function removeshortcutsAction() {

    if (!$this->_helper->requireUser()->isValid())
      return;
    
    $shortcut_id = $this->_getParam('shortcut_id', null);
    if(empty($shortcut_id))
      return;
      
    $resource_type = $this->_getParam('resource_type', null);
    $resource_id = $this->_getParam('resource_id', null);
    $viewer = Engine_Api::_()->user()->getViewer();
    if(empty($resource_id) && $empty($resource_type))
      return;
    
    $resource = Engine_Api::_()->getItem($resource_type, $resource_id);

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesshortcut_Form_RemoveShortcuts();

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $shortcutTable = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut');
    $db = $shortcutTable->getAdapter();
    $db->beginTransaction();
    try {
      $shortcutTable->delete(array('shortcut_id =?' => $shortcut_id));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('This content has been successfully removed as Shortcut.'))
    ));
  }
  
  public function shortcutAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id))
      return;

    $resource_id = $this->_getParam('id');
    $resource_type = $this->_getParam('type');
    $shortcut_id = $this->_getParam('contentId');
    $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
    
    $shortcutTable = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut');
    
    if (empty($shortcut_id)) {

      $isShortcut = $shortcutTable->isShortcut(array('resource_type' => $resource_type, 'resource_id' => $resource_id));

      if (empty($isShortcut)) {
        $shortcutTable = $shortcutTable;
        $db = $shortcutTable->getAdapter();
        $db->beginTransaction();
        try {
          if (!empty($resource))
            $shortcut_id = $shortcutTable->addShortcut($resource, $viewer)->shortcut_id;
          $this->view->shortcut_id = $shortcut_id;
          $db->commit();
        } catch (Exception $e) {
          $db->rollBack();
          throw $e;
        }
      } else {
        $this->view->shortcut_id = $isShortcut;
      }
    } else {
      $shortcutTable->delete(array('shortcut_id =?' => $shortcut_id));
    }
  }
}