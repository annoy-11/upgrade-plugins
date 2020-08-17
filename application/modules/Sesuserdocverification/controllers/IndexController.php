<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_IndexController extends Core_Controller_Action_Standard {

  public function uploadDocumentAction() {

    $document_id = $this->_getParam('document_id', 0);

    $this->_helper->layout->setLayout('default-simple');
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $this->view->form = $form = new Sesuserdocverification_Form_Upload();

    if($document_id) {
      $document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);
      $form->populate($document->toArray());
    }

    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    if ($this->getRequest()->isPost()) {
      $values = $form->getValues();

      if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

        $storage = Engine_Api::_()->getItemTable('storage_file');
        $filename = $storage->createFile($form->file, array(
          'parent_id' => $viewer_id,
          'parent_type' => 'userdocverification',
          'user_id' => $viewer_id,
        ));
        // Remove temporary file
        @unlink($file['tmp_name']);

        if($document_id) {
          $document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);
          $document->file_id = $filename->file_id;
          $document->storage_path = $filename->storage_path;
          $document->documenttype_id = $values['documenttype_id'] ? $values['documenttype_id'] : '0';
          $document->submintoadmin = '0';
          $document->save();
        } else {
          $table = Engine_Api::_()->getDbTable('documents', 'sesuserdocverification');
          $document = $table->createRow();
          $document->user_id = $viewer_id;
          $document->file_id = $filename->file_id;
          $document->storage_path = $filename->storage_path;
          $document->documenttype_id = $values['documenttype_id'] ? $values['documenttype_id'] : '0';
          $document->submintoadmin = '0';
          $document->save();
        }
      } else if($document_id) {
        $document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);
        //$document->file_id = $filename->file_id;
        //$document->storage_path = $filename->storage_path;
        $document->documenttype_id = $values['documenttype_id'];
        $document->submintoadmin = '0';
        $document->save();
      }


      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Document Uploaded Successfully.')
      ));
    }
  }
}
