<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminReviewController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_AdminReviewController extends Core_Controller_Action_Admin {

  public function reviewSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_reviewsettings', array(), 'sesproduct_admin_main_review');
     $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_review', array(), 'sesproduct_admin_main_reviewparamstg');
    $this->view->form = $form = new Sesproduct_Form_Admin_Review_ReviewSettings();

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

     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_reviewsettings', array(), 'sesproduct_admin_main_review');
     $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_review', array(), 'sesproduct_admin_main_managereview');

    $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_Review_Filter();

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
          $video = Engine_Api::_()->getItem('sesproductreview', $value)->delete();
        }
      }
    }

    $table = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct');
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


    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);
  }

  public function viewAction() {
    $this->view->item = Engine_Api::_()->getItem('sesproductreview', $this->_getParam('id', null));
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
        $review = Engine_Api::_()->getItem('sesproductreview', $this->_getParam('review_id'));
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

    $this->view->module_name = 'sesproduct';

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main', array(), 'sesproduct_admin_main_reviewsettings');

    $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_reviewsettings', array(), 'sesproduct_admin_main_subprofiletypemapping');

    $categories_table = Engine_Api::_()->getDbtable('categories', 'sesproduct');
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

    $this->view->form = $form = new Sesproduct_Form_Admin_Review_CategoryMapping();

    $categorymapping_table = Engine_Api::_()->getDbtable('categorymappings', 'sesproduct');

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
          $categorymapping = Engine_Api::_()->getItem('sesproduct_categorymapping', $isCatMapped);
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

    $categorymapping = Engine_Api::_()->getItem('sesproduct_categorymapping', $categorymapping_id);

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

	$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_reviewsettings', array(), 'sesproduct_admin_main_review');
     $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_review', array(), 'sesproduct_admin_main_reviewlevel');

    //Get level id
    if (null !== ($id = $this->_getParam('level_id', $this->_getParam('id'))))
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    else
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();

    if (!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');

    $id = $level->level_id;

    //Make form
    $this->view->form = $form = new Sesproduct_Form_Admin_Review_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);

    $content_type = 'sesproductreview';
    //$module_name = $this->_getParam('module_name', null);

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

    public function reviewParameterAction() {

   $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_reviewsettings', array(), 'sesproduct_admin_main_review');
     $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_review', array(), 'sesproduct_admin_main_reviewparam');

    //START PROFILE TYPE WORK
    $optionsData = Engine_Api::_()->getApi('core', 'fields')->getFieldsOptions('user');
    $mapData = Engine_Api::_()->getApi('core', 'fields')->getFieldsMaps('user');
    // Get top level fields
  /*  $topLevelMaps = $mapData->getRowsMatching(array('field_id' => 0, 'option_id' => 0));
    $topLevelFields = array();
    foreach ($topLevelMaps as $map) {
      $field = $map->getChild();
      $topLevelFields[$field->field_id] = $field;
    }
    $topLevelField = array_shift($topLevelFields);
    $topLevelOptions = array();
    foreach ($optionsData->getRowsMatching('field_id', $topLevelField->field_id) as $option) {
      $topLevelOptions[$option->option_id] = $option->label;
    }
    $this->view->topLevelOptions = $topLevelOptions;*/
     $this->view->topLevelOptions = Engine_Api::_()->getDbTable('categories', 'sesproduct')->getCategory(array('column_name' => '*', 'profile_type' => true));
    //END PROFILE TYPE WORK
  }

public function addParameterAction() {
    $category_id = $this->_getParam('id', null);
    if (!$category_id)
      return $this->_forward('notfound', 'error', 'core');
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesproduct_Form_Admin_Parameter_Add();
    $reviewParameters = Engine_Api::_()->getDbtable('parameters', 'sesproduct')->getParameterResult(array('category_id' => $category_id));
    if (!count($reviewParameters))
      $form->setTitle('Add Review Parameters');
    else {
      $form->setTitle('Edit Review Parameters');
      $form->submit->setLabel('Edit');
    }
    $form->setDescription("");
    if (!$this->getRequest()->isPost()) {
      return;
    }
    $table = Engine_Api::_()->getDbtable('parameters', 'sesproduct');
    $tablename = $table->info('name');
    try {
      $values = $form->getValues();

      unset($values['addmore']);
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $deleteIds = explode(',', $_POST['deletedIds']);

      foreach ($deleteIds as $val) {
        if (!$val)
          continue;
        $query = 'DELETE FROM ' . $tablename . ' WHERE parameter_id = ' . $val;
				$dbObject->query($query);
      }
      foreach ($_POST as $key => $value) {

        if (count(explode('_', $key)) != 3 || !$value)
          continue;
        $id = str_replace('sesproduct_review_', '', $key);
        $query = 'UPDATE ' . $tablename . ' SET title = "' . $value . '" WHERE parameter_id = ' . $id;
        $dbObject->query($query);
      }
      foreach ($_POST['parameters'] as $key => $val) {
        if ($_POST['parameters'][$key] != '') {
          $query = 'INSERT IGNORE INTO ' . $tablename . ' (`category_id`, `title`, `rating`) VALUES ("' . $category_id . '","' . $val . '","0")';
          $dbObject->query($query);
        }
      }
    } catch (Exception $e) {
			echo '<pre>';print_r($e->getMessage());die;
      throw $e;
    }
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("Review Parameters have been saved.");
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array($this->view->message)
    ));
  }



}
