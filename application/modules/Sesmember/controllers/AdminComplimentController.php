<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminComplimentController.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_AdminComplimentController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main', array(), 'sesmember_admin_main_complements');

    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('compliments', 'sesmember');
    $select = $table->select();

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(80);
  }

  public function editAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesmember_Form_Admin_Compliment();
    $id = $this->_getParam('id', 0);

    $compliment = Engine_Api::_()->getItem('sesmember_compliment', $id);
    $form->populate($compliment->toArray());
    $form->submit->setLabel('Update');
    if ($this->getRequest()->isPost()) {

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

      // Process
      $complimentTable = Engine_Api::_()->getDbTable('compliments', 'sesmember');
      $values = $form->getValues();
      $db = $complimentTable->getAdapter();
      $db->beginTransaction();

      try {
        $compliment->setFromArray($values);
        if (!empty($_FILES['file']['name'])) {
          $photo = $_FILES['file'];


          //GET PHOTO DETAILS
          $mainName = dirname($photo['tmp_name']) . '/' . $photo['name'];

          //GET VIEWER ID
          $photo_params = array(
              'parent_id' => $compliment->getIdentity(),
              'parent_type' => "sesmember_compliment",
          );
          copy($photo['tmp_name'], $mainName);
          try {
            $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
          } catch (Exception $e) {
            if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
              echo $e->getMessage();
              exit();
            }
          }
          $compliment->file_id = $photoFile->file_id;
        }
        $compliment->save();
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        return;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Compliment type updated successfully')
      ));
    }
  }

  //delete playlist
  public function deleteAction() {
  
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Compliment Type?');
    $form->setDescription('Are you sure that you want to delete this compliment type? It will not be recoverable after being deleted. ');
    $form->submit->setLabel('Delete');

    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sesmember_compliment', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Compliment Type Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-compliment/delete.tpl');
  }

  public function addAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesmember_Form_Admin_Compliment();

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      // Process
      $complimentTable = Engine_Api::_()->getDbTable('compliments', 'sesmember');
      $values = $form->getValues();
      $db = $complimentTable->getAdapter();
      $db->beginTransaction();

      try {
        $compliment = $complimentTable->createRow();
        $compliment->setFromArray($values);
        $photo = $_FILES['file'];
        //GET PHOTO DETAILS
        $mainName = dirname($photo['tmp_name']) . '/' . $photo['name'];
        //GET VIEWER ID
        $photo_params = array(
            'parent_id' => $compliment->getIdentity(),
            'parent_type' => "sesmember_compliment",
        );
        copy($photo['tmp_name'], $mainName);
        try {
          $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
        } catch (Exception $e) {
          if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
            echo $e->getMessage();
            exit();
          }
        }
        $compliment->file_id = $photoFile->file_id;
        $compliment->save();
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        return;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Compliment type created successfully')
      ));
    }
  }

}
