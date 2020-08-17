<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminEmojiController.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemoji_AdminEmojiController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    if(count($_POST)) {
      $emojiiconsTable = Engine_Api::_()->getDbtable('emojiicons', 'sesemoji');
      foreach($_POST as $key => $emoji_id) {
        $emoji = Engine_Api::_()->getItem('sesemoji_emoji', $emoji_id);
        $emojiIconsSelect = $emojiiconsTable->select()->where('emoji_id =?',$emoji_id);
        foreach($emojiiconsTable->fetchAll($emojiIconsSelect) as $emojiicon){
          $emojiicon->delete(); 
        }
        $emoji->delete();
        $this->_helper->redirector->gotoRoute(array());
      }
		}
		
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesemoji_admin_main', array(), 'sesemoji_admin_main_eemojisettings');

    $page = $this->_getParam('page',1);
    $this->view->paginator = Engine_Api::_()->getDbTable('emojis','sesemoji')->getPaginator(array('admin' => 1));
    $this->view->paginator->setItemCountPerPage(100);
    $this->view->paginator->setCurrentPageNumber($page);
  }

  public function orderManageEmojiiconsAction() {

    if (!$this->getRequest()->isPost())
      return;

    $emojisTable = Engine_Api::_()->getDbtable('emojiicons', 'sesemoji');
    $emojiicons = $emojisTable->fetchAll($emojisTable->select());
    foreach ($emojiicons as $emojiicon) {

      $order = $this->getRequest()->getParam('manageemojiicons_' . $emojiicon->emojiicon_id);

      if (!$order)
        $order = 999;
      $emojiicon->order = $order;
      $emojiicon->save();
    }
    return;
  }
  
  public function orderManageEmojiAction() {

    if (!$this->getRequest()->isPost())
      return;

    $emojisTable = Engine_Api::_()->getDbtable('emojis', 'sesemoji');
    $emojiicons = $emojisTable->fetchAll($emojisTable->select());
    foreach ($emojiicons as $emojiicon) {

      $order = $this->getRequest()->getParam('manageemojis_' . $emojiicon->emoji_id);

      if (!$order)
        $order = 999;
      $emojiicon->order = $order;
      $emojiicon->save();
    }
    return;
  }
  
  public function createEmojicategoryAction() {
  
    $id = $this->_getParam('id',false);
    
    $this->view->form = $form = new Sesemoji_Form_Admin_Emoji_Emojicategorycreate();
    if($id){
      $item = Engine_Api::_()->getItem('sesemoji_emoji',$id);
      $form->populate($item->toArray());
      $form->setTitle('Edit This Emoji Category');
      $form->submit->setLabel('Edit');
    }
    
    // Check if post
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Not post');
      return;
    }
    
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->view->status = false;
      $this->view->error =  Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }
    
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    // If we're here, we're done
    $this->view->status = true;
    try {
    
      $catgeoryTable = Engine_Api::_()->getDbtable('emojis', 'sesemoji');
      $values = $form->getValues();

      unset($values['file']); 
      
      if(empty($id))
        $item = $catgeoryTable->createRow();
        
      $item->setFromArray($values);
      $item->save();
      
      if(!empty($_FILES['file']['name'])) {
        $file_ext = pathinfo($_FILES['file']['name']);
        $file_ext = $file_ext['extension'];
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $storageObject = $storage->createFile($form->file, array(
          'parent_id' => $item->getIdentity(),
          'parent_type' => $item->getType(),
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        // Remove temporary file
        @unlink($file['tmp_name']);
        $item->file_id = $storageObject->file_id;
        $item->save();
      }
      
      $db->commit();
    }catch(Exception $e){
      $db->rollBack();
      throw $e;  
    }
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('Emoji Category Created Successfully.')
    ));
  }
  
  public function deleteEmojicategoryAction() {
  
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    
    $form->setTitle('Delete This Emoji Category');
    $form->setDescription('Are you sure that you want to delete this emoji category? It will not be recoverable after being deleted.'); 
    
    $form->submit->setLabel('Delete');
    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $emojiiconsTable = Engine_Api::_()->getDbtable('emojiicons', 'sesemoji');
      $emojiiconSelect = $emojiiconsTable->select()->where('emoji_id =?',$id);
      foreach($emojiiconsTable->fetchAll($emojiiconSelect) as $files){
        $files->delete(); 
      }
      $emojicategory = Engine_Api::_()->getItem('sesemoji_emoji', $id);
      $emojicategory->delete();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Emoji Category Deleteed Successfully.')
      ));
    }
  }
  
  public function emojiiconsAction() {

    if(count($_POST) > 0) { 
      foreach($_POST as $key => $file_id) {
        $file = Engine_Api::_()->getItem('sesemoji_emojiicon', $file_id);
        $file->delete();
      }
      $this->_helper->redirector->gotoRoute(array());
		}
		
    $this->view->emoji_id =  $emoji_id = $this->_getParam('emoji_id',false);
    if(!$emoji_id)
      return  $this->_forward('notfound', 'error', 'core');
      
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesemoji_admin_main', array(), 'sesemoji_admin_main_eemojisettings');

    $page = $this->_getParam('page',1);
    $this->view->paginator = Engine_Api::_()->getDbTable('emojiicons','sesemoji')->getPaginator(array('emoji_id' => $emoji_id));
    $this->view->paginator->setItemCountPerPage(100);
    $this->view->paginator->setCurrentPageNumber($page);
  }
  
  public function addEmojiiconAction() {
  
    $id = $this->_getParam('id',false);
    
    $emoji_id = $this->_getParam('emoji_id',0);
    
    $this->view->form = $form = new Sesemoji_Form_Admin_Emoji_EmojiIcon();
    if($id) {
      $item = Engine_Api::_()->getItem('sesemoji_emojiicon',$id);
      $form->populate($item->toArray());
      $form->setTitle('Edit This Emoji Icon');
      $form->submit->setLabel('Save Changes');
    }
    
    // Check if post
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Not post');
      return;
    }
    
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->view->status = false;
      $this->view->error =  Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }
    
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction(); 
    // If we're here, we're done
    $this->view->status = true;
    try {
      $catgeoryTable = Engine_Api::_()->getDbtable('emojiicons', 'sesemoji');
      
      $values = $form->getValues();
      
      $emoIconCode = "\u{$values['emoji_icon']}";
      $emoIcon = preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;", $emoIconCode);
      $emojisCode = Engine_Api::_()->sesemoji()->EncodeEmoji(IntlChar::chr(hexdec($emoIcon)));
 
      if(empty($id))
       $item = $catgeoryTable->createRow();
      
      $values['emoji_encodecode'] = $emojisCode;

      $values['emoji_id'] = $emoji_id;
      $item->setFromArray($values);
      $item->save();

      if(!empty($_FILES['file']['name'])) {
        $file_ext = pathinfo($_FILES['file']['name']);
        $file_ext = $file_ext['extension'];
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $storageObject = $storage->createFile($form->file, array(
          'parent_id' => $item->getIdentity(),
          'parent_type' => $item->getType(),
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));

        // Remove temporary file
        @unlink($file['tmp_name']);
        $item->file_id = $storageObject->file_id;
        $item->save();
      }

      $db->commit();
    } catch(Exception $e) {
      $db->rollBack();
      throw $e;  
    }
    
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('Emoji Icon Created Successfully.')
    ));
  }
  
  public function deleteEmojiiconAction() {
  
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete This Emoji Icon');
    $form->setDescription('Are you sure that you want to delete this emoji icon? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $file = Engine_Api::_()->getItem('sesemoji_emojiicon', $id);
      $file->delete();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Emoji Icon Deleted Successfully.')
      ));
    }
  }
}