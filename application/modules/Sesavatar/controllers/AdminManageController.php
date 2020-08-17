<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $image = Engine_Api::_()->getItem('sesavatar_image', $value);
          if($image)
          $image->delete();
        }
      }
    }

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesavatar_admin_main', array(), 'sesavatar_admin_main_manageavatar');

    $imagesTable = Engine_Api::_()->getDbTable('images','sesavatar');
    $rName = $imagesTable->info('name');

    $select = $imagesTable->select()
            ->from($rName)
            ->order('image_id DESC' );

    $this->view->paginator = Zend_Paginator::factory($select);
    $this->view->paginator->setItemCountPerPage(100);
    $this->view->paginator->setCurrentPageNumber($this->_getParam('page',1));
  }


  public function createAction() {

    $id = $this->_getParam('id',false);

    $this->view->form = $form = new Sesavatar_Form_Admin_Image_Create();
    if($id){
      $item = Engine_Api::_()->getItem('sesavatar_image',$id);
      $form->populate($item->toArray());
      $form->setTitle('Edit this Avatar Image');
      $form->submit->setLabel('Save Changes');
    }

    // Check if post
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Not post');
      return;
    }

    if(!$form->isValid($this->getRequest()->getPost()) && !$id) {
      $this->view->status = false;
      $this->view->error =  Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $values = $form->getValues();
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    // If we're here, we're done
    $this->view->status = true;
    try {

      $imagesTable = Engine_Api::_()->getDbtable('images', 'sesavatar');

      unset($values['file']);
      if(empty($id))
        $item = $imagesTable->createRow();
      $item->setFromArray($values);
      $item->save();
      $item->order = $item->image_id;
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
      'messages' => array('Avatar Image Image Uploaded Successfully.')
    ));
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesavatar_image', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesavatar/manage');
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $imagesTable = Engine_Api::_()->getDbtable('images', 'sesavatar');
    $images = $imagesTable->fetchAll($imagesTable->select());
    foreach ($images as $image) {
      $order = $this->getRequest()->getParam('manageimages_' . $image->image_id);
      if (!$order)
        $order = 999;
      $image->order = $order;
      $image->save();
    }
    return;
  }


  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();

    $form->setTitle('Delete This Avatar Image');
    $form->setDescription('Are you sure that you want to delete this avatar image? It will not be recoverable after being deleted.');

    $form->submit->setLabel('Delete');
    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $image = Engine_Api::_()->getItem('sesavatar_image', $id);
      $image->delete();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Avatar Image Image Deleteed Successfully.')
      ));
    }
  }

  public function uploadZipFileAction() {

    $this->view->form = $form = new Sesavatar_Form_Admin_Image_Zipupload();

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

    if(!empty($_FILES["file"]["name"])) {

      $file = $_FILES["file"];
      $filename = $file["name"];
      $tmp_name = $file["tmp_name"];
      $type = $file["type"];

      $name = explode(".", $filename);
      $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');

      if(in_array($type,$accepted_types)) { //If it is Zipped/compressed File
        $okay = true;
      }

      $continue = strtolower($name[1]) == 'zip' ? true : false; //Checking the file Extension

      if(!$continue) {
        $form->addError("The file you are trying to upload is not a .zip file. Please try again.");
        return;
      }

      /* here it is really happening */
      $ran = $name[0]."-".time()."-".rand(1,time());
      $dir = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary/';
      $targetdir = $dir.$ran;
      $targetzip = $dir.$ran.".zip";

      if(move_uploaded_file($tmp_name, $targetzip)) { //Uploading the Zip File
        /* Extracting Zip File */
        $zip = new ZipArchive();
        $x = $zip->open($targetzip);  // open the zip file to extract
        if ($x === true) {
            $zip->extractTo($targetdir); // place in the directory with same name
            $zip->close();

            @unlink($targetzip); //Deleting the Zipped file
            // Get subdirectories
            chmod($targetdir, 0777) ;
            $directories = glob($targetdir.'*', GLOB_ONLYDIR);
            if ($directories !== FALSE) {
              $db = Engine_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
              // If we're here, we're done
              $this->view->status = true;
              try {
                foreach($directories as $directory) {
                  $path = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
                    foreach ($path as $file) {
                      if (!$file->isFile())
                        continue;
                      $base_name = basename($file->getFilename());
                      if (!($pos = strrpos($base_name, '.')))
                        continue;
                      $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
                      if (!in_array($extension, array('gif', 'GIF', 'png', 'PNG', 'jpg', 'JPG', 'JPEG', 'jpeg')))
                        continue;
                      $this->uploadZipFile($file->getPathname(), $_POST['tags']);
                  }
                }
                $db->commit();
                $this->rrmdir($targetdir);
               } catch(Exception $e) {
                  $db->rollBack();
                  throw $e;
               }
            }
        }
      } else {
        $form->addError("There was a problem with the upload. Please try again.");
        return;
      }
    }
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('Zip images uploaded Successfully.')
    ));
  }

  private function uploadZipFile($file = '', $tags = '') {

    $imagesTable = Engine_Api::_()->getDbtable('images', 'sesavatar');
    $viewer = Engine_Api::_()->user()->getViewer();
    $item = $imagesTable->createRow();
    $values['enabled'] = 1;
    $item->setFromArray($values);
    $item->save();
    $item->order = $item->image_id;
    $item->save();

    if(!empty($file)) {
      $file_ext = pathinfo($file);
      $file_ext = $file_ext['extension'];
      $storage = Engine_Api::_()->getItemTable('storage_file');
      $fileUpload = array('name'=>basename($file),'tmp_name' => $file,'size'=>filesize($file),'error'=>0);
      $storageObject = $storage->createFile($file, array(
        'parent_id' => $item->getIdentity(),
        'parent_type' => $item->getType(),
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
      ));
      // Remove temporary file
      @unlink($file['tmp_name']);
      $item->file_id = $storageObject->file_id;
      $item->save();
    }
  }

  private function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                $this->rrmdir($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
  }
}
