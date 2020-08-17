<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageReviewController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_AdminManageReviewController extends Core_Controller_Action_Admin {

  public function reviewSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_admin_main', array(), 'eblog_admin_main_reviewsettings');
    
    $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_admin_main_reviewsettings', array(), 'eblog_admin_main_subreviewsettings');

    $this->view->form = $form = new Eblog_Form_Admin_Review_ReviewSettings();

    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) )
    {
      $values = $form->getValues();

      foreach ($values as $key => $value){
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }

  public function manageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_admin_main', array(), 'eblog_admin_main_reviewsettings');
    
    $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_admin_main_reviewsettings', array(), 'eblog_admin_main_submanagereview');

    $this->view->formFilter = $formFilter = new Eblog_Form_Admin_Review_Filter();

    //Process form
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
          $video = Engine_Api::_()->getItem('eblog_review', $value)->delete();
        }
      }
    }

    $table = Engine_Api::_()->getDbtable('reviews', 'eblog');
    $tableName = $table->info('name');
    
    $uTableName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $select = $table->select()
            ->from($tableName)
            ->setIntegrityCheck(false)
            ->joinLeft($uTableName, "$uTableName.user_id = $tableName.owner_id", 'username')
				    ->order('review_id DESC');

    // Set up select info
    if (!empty($_GET['title']))
      $select->where('title LIKE ?', '%' . $values['title'] . '%');

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where('featured = ?', $values['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where('sponsored = ?', $values['sponsored']);

    if (!empty($values['creation_date']))
      $select->where('date(' . $tableName . '.creation_date) = ?', $values['creation_date']);

    if (!empty($_GET['owner_name']))
      $select->where($uTableName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($tableName . '.offtheday =?', $values['offtheday']);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1);
  }

  public function viewAction() {
    $this->view->item = Engine_Api::_()->getItem('eblog_review', $this->_getParam('id', null));
  }

  //Delete entry
  public function deleteReviewAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Eblog_Form_Admin_Review_Delete();
    $form->setTitle('Delete Review');
    $form->setDescription('Are you sure that you want to delete this review? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $review = Engine_Api::_()->getItem('eblog_review', $this->_getParam('review_id'));
        $review->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully delete entry.')
      ));
    }
  }

  public function profileTypeMappingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_admin_main', array(), 'eblog_admin_main_reviewsettings');
    
    $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_admin_main_reviewsettings', array(), 'eblog_admin_main_subprofiletypemapping');

    $table = Engine_Api::_()->getDbtable('categories', 'eblog');
    $select = $table->select()
            ->from($table->info('name'), array('category_id', 'category_name'))
            ->where('subcat_id = ?', 0)
            ->where('subsubcat_id = ?', 0);
    $this->view->results = $table->fetchAll($select);
  }

  public function categoryMappingAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $category_id = $this->_getParam('category_id');
    $module_name = $this->_getParam('module_name', null);

    $this->view->form = $form = new Eblog_Form_Admin_Review_CategoryMapping();

    $table = Engine_Api::_()->getDbtable('categorymappings', 'eblog');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      $values['category_id'] = $category_id;
      $values['module_name'] = $module_name;
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $isCatMapped = $table->isCategoryMapped(array('module_name' => $module_name, 'category_id' => $category_id, 'column_name' => 'categorymapping_id'));
        if (empty($isCatMapped)) {
          $row = $table->createRow();
          $row->setFromArray($values);
          $row->save();
          $db->commit();
        } else {
          $categorymapping = Engine_Api::_()->getItem('eblog_categorymapping', $isCatMapped);
          $categorymapping->setFromArray($values);
          $categorymapping->save();
          $db->commit();
        }
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_(''))
      ));
    }
  }

  public function removeCategoryMappingAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Eblog_Form_Admin_Review_Delete();
    $form->setTitle('Remove Entry?');
    $form->setDescription('Are you sure that you want to remove this?');
    $form->submit->setLabel('Remove');

    $categorymapping = Engine_Api::_()->getItem('eblog_categorymapping', $this->_getParam('categorymapping_id', null));

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $categorymapping->profile_type = 0;
        $categorymapping->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_(''))
      ));
    }
  }
}
