<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminReviewController.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_AdminReviewController extends Core_Controller_Action_Admin {

  public function reviewSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_rwsettings');
   

    $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_rwsettings', array(), 'seslisting_admin_main_review_settings');
     
    $this->view->form = $form = new Seslisting_Form_Admin_Review_ReviewSettings();

    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) )
    {
      $values = $form->getValues();

      foreach ($values as $key => $value){
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }

  public function manageReviewsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_rwsettings');

    $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_rwsettings', array(), 'seslisting_admin_main_managereview');

    $this->view->formFilter = $formFilter = new Seslisting_Form_Admin_Review_Filter();

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
          $video = Engine_Api::_()->getItem('seslistingreview', $value)->delete();
        }
      }
    }

    $table = Engine_Api::_()->getDbtable('seslistingreviews', 'seslisting');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
				    ->order('review_id DESC');

    // Set up select info
    if (!empty($_GET['title']))
      $select->where('title LIKE ?', '%' . $values['title'] . '%');

    if (!empty($values['creation_date']))
      $select->where('date(' . $tableName . '.creation_date) = ?', $values['creation_date']);

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($tableName . '.oftheday =?', $values['offtheday']);



    if (!empty($_GET['featured']) && $_GET['featured'] != '')
      $select->where($tableName.'.featured = ?', $values['featured']);


		if (!empty($_GET['verified']) && $_GET['verified'] != '')
      $select->where($tableName.'.verified = ?', $values['verified']);


    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);
  }

  public function viewAction() {
    $this->view->item = Engine_Api::_()->getItem('seslistingreview', $this->_getParam('id', null));
  }

  //Delete entry
  public function deleteReviewAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Review');
    $form->setDescription('Are you sure that you want to delete this review? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $review = Engine_Api::_()->getItem('seslistingreview', $this->_getParam('review_id'));
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

    $this->view->module_name = 'seslisting';

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_rwsettings');

    $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_rwsettings', array(), 'seslisting_admin_main_subprofiletypemapping');

    $categories_table = Engine_Api::_()->getDbtable('categories', 'seslisting');
    $select = $categories_table->select()
            ->from($categories_table->info('name'), array('category_id', 'category_name'))
            ->where('subcat_id = ?', 0)
            ->where('subsubcat_id = ?', 0);
    $this->view->results = $results = $categories_table->fetchAll($select);
  }

  public function categoryMappingAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $category_id = $this->_getParam('category_id');
    $module_name = $this->_getParam('module_name', null);

    $this->view->form = $form = new Seslisting_Form_Admin_Review_CategoryMapping();

    $categorymapping_table = Engine_Api::_()->getDbtable('categorymappings', 'seslisting');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      $values['category_id'] = $category_id;
      $values['module_name'] = $module_name;
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $isCatMapped = $categorymapping_table->isCategoryMapped(array('module_name' => $module_name, 'category_id' => $category_id, 'column_name' => 'categorymapping_id'));
        if (empty($isCatMapped)) {
          $row = $categorymapping_table->createRow();
          $row->setFromArray($values);
          $row->save();
          $db->commit();
        } else {
          $categorymapping = Engine_Api::_()->getItem('seslisting_categorymapping', $isCatMapped);
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

    $module_name = $this->_getParam('module_name', null);
    $categorymapping_id = $this->_getParam('categorymapping_id', null);

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Remove Entry?');
    $form->setDescription('Are you sure that you want to remove this?');
    $form->submit->setLabel('Remove');

    $categorymapping = Engine_Api::_()->getItem('seslisting_categorymapping', $categorymapping_id);

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

    public function levelSettingsAction() {

		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_rwsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_rwsettings', array(), 'seslisting_admin_main_levelsettings');

    //Get level id
    if (null !== ($id = $this->_getParam('level_id', $this->_getParam('id'))))
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    else
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();

    if (!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');

    $id = $level->level_id;

    //Make form
    $this->view->form = $form = new Seslisting_Form_Admin_Review_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);

    $content_type = 'seslistingreview';
    $module_name = $this->_getParam('module_name', null);

    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed($content_type, $id, array_keys($form->getValues())));

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check validitiy
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $values = $form->getValues();

    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      //Set permissions
      $permissionsTable->setAllowed($content_type, $id, $values);
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }

  public function featuredAction() {

    $id = $this->_getParam('review_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seslistingreview', $id);
      $item->featured = !$item->featured;
      $item->save();
    }
    $this->_redirect('admin/seslisting/review/manage-reviews');
  }

  public function verifiedAction() {
    $id = $this->_getParam('review_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seslistingreview', $id);
      $item->verified = !$item->verified;
      $item->save();
    }
    $this->_redirect('admin/seslisting/review/manage-reviews');
  }

  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id');

    $this->view->form = $form = new Seslisting_Form_Admin_Oftheday();
    $form->setTitle('Review of the Day');
    $item = Engine_Api::_()->getItem('seslistingreview', $id);

    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
      return;
      $values = $form->getValues();

      $values['starttime'] = date('Y-m-d', strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));

      $db->update('engine4_seslisting_reviews', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("review_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_seslisting_reviews', array('oftheday' => 0), array("review_id = ?" => $id));
      } else {
        $db->update('engine4_seslisting_reviews', array('oftheday' => 1), array("review_id = ?" => $id));
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

}
