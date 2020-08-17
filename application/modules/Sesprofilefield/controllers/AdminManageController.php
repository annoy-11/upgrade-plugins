<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesprofilefield_AdminManageController extends Core_Controller_Action_Admin {


  public function languagesAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_managelanguages');
    $this->view->languages = Engine_Api::_()->getDbtable('managelanguages', 'sesprofilefield')->getSkill(array('column_name' => '*', 'param' => 'admin'));
  }



  public function skillsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_manageskills');
    $this->view->skills = Engine_Api::_()->getDbtable('manageskills', 'sesprofilefield')->getSkill(array('column_name' => '*', 'param' => 'admin'));
  }

  public function addLanguageAction() {

    $this->_helper->layout->setLayout('admin-simple');

    //Generate and assign form
    $this->view->form = $form = new Sesprofilefield_Form_Admin_Manage_AddLanguage();
    $form->setTitle('Add New Language');
    $form->languagename->setLabel('Language Name');

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      $table = Engine_Api::_()->getDbtable('managelanguages', 'sesprofilefield');
      try {

        $languagenames = preg_split('/[,]+/', $values['languagename']);
        foreach($languagenames as $languagename) {
          if(empty($languagename)) continue;
          $row = $table->createRow();
          $values['languagename'] = $languagename;
          $values['enabled'] = '1';
          $row->setFromArray($values);
          $row->save();
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully create language.')
      ));
    }
  }

  public function editLanguageAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesprofilefield_Form_Admin_Manage_EditLanguage();
    $form->setTitle('Edit this Language');
    $form->languagename->setLabel('Language Name');

    $cat_id = $this->_getParam('id');
    $manageLanguages = Engine_Api::_()->getItem('sesprofilefield_managelanguages', $cat_id);
    $form->populate($manageLanguages->toArray());

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check
    if (!$form->isValid($this->getRequest()->getPost())) {
      if (empty($_POST['languagename'])) {
        $form->addError($this->view->translate("Language Name * Please complete this field - it is required."));
      }
      return;
    }

    $values = $form->getValues();
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $manageLanguages->languagename = $values['languagename'];
      $manageLanguages->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array('You have successfully edit language.')
    ));
  }


  public function deleteLanguageAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id');
    $value = $this->_getParam('value');
    $manageLanguagesTable = Engine_Api::_()->getDbtable('managelanguages', 'sesprofilefield');
    $manageLanguages = $manageLanguagesTable->find($id)->current();

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
       $db->query('DELETE FROM `engine4_sesprofilefield_languages` WHERE `engine4_sesprofilefield_languages`.`managelanguage_id` = "'.$id.'"');
        $manageLanguages->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully delete language.')
      ));
    }
    //Output
    $this->renderScript('admin-manage/delete-language.tpl');
  }

  public function enabledLanguageAction() {
    $managelanguage_id = $this->_getParam('id');
    if (!empty($managelanguage_id)) {
      $managelanguage = Engine_Api::_()->getItem('sesprofilefield_managelanguages', $managelanguage_id);
      $managelanguage->enabled = !$managelanguage->enabled;
      $managelanguage->save();
    }
    $this->_redirect('admin/sesprofilefield/manage/languages');
  }


  public function addSkillAction() {

    $this->_helper->layout->setLayout('admin-simple');

    //Generate and assign form
    $this->view->form = $form = new Sesprofilefield_Form_Admin_Manage_AddSkill();
    $form->setTitle('Add New Skill');
    $form->skillname->setLabel('Skill Name');

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      $table = Engine_Api::_()->getDbtable('manageskills', 'sesprofilefield');
      try {

        $skillnames = preg_split('/[,]+/', $values['skillname']);
        foreach($skillnames as $skillname) {
          if(empty($skillname)) continue;
          $row = $table->createRow();
          $values['skillname'] = $skillname;
          $values['enabled'] = '1';
          $row->setFromArray($values);
          $row->save();
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully create skill.')
      ));
    }
  }


  public function editSkillAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesprofilefield_Form_Admin_Manage_EditSkill();
    $form->setTitle('Edit this Skill');
    $form->skillname->setLabel('Skill Name');

    $cat_id = $this->_getParam('id');
    $manageSkills = Engine_Api::_()->getItem('sesprofilefield_manageskills', $cat_id);
    $form->populate($manageSkills->toArray());

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check
    if (!$form->isValid($this->getRequest()->getPost())) {
      if (empty($_POST['skillname'])) {
        $form->addError($this->view->translate("Skill Name * Please complete this field - it is required."));
      }
      return;
    }

    $values = $form->getValues();
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $manageSkills->skillname = $values['skillname'];
      $manageSkills->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array('You have successfully edit skill.')
    ));
  }


  public function deleteSkillAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id');
		$value = $this->_getParam('value');
    $manageSkillsTable = Engine_Api::_()->getDbtable('manageskills', 'sesprofilefield');
    $manageSkills = $manageSkillsTable->find($id)->current();

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
       $db->query('DELETE FROM `engine4_sesprofilefield_skills` WHERE `engine4_sesprofilefield_skills`.`manageskill_id` = "'.$id.'"');
        $manageSkills->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully delete skill.')
      ));
    }
    //Output
    $this->renderScript('admin-manage/delete-skill.tpl');
  }

  public function enabledSkillAction() {
    $manageskill_id = $this->_getParam('id');
    if (!empty($manageskill_id)) {
      $manageskill = Engine_Api::_()->getItem('sesprofilefield_manageskills', $manageskill_id);
      $manageskill->enabled = !$manageskill->enabled;
      $manageskill->save();
    }
    $this->_redirect('admin/sesprofilefield/manage/skills');
  }

  public function authoritiesAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_manageauthorities');

    $this->view->formFilter = $formFilter = new Sesprofilefield_Form_Admin_Manage_Authority();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('authorities', 'sesprofilefield');

    $select = $table->select();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'authority_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $select->order((!empty($values['order']) ? $values['order'] : 'authority_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

//     if (isset($values['enabled']) && $values['enabled'] != -1)
//       $select->where('enabled = ?', $values['enabled']);

    if (!empty($values['authority_id']))
      $select->where('authority_id = ?', (int) $values['authority_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Reset enabled bit
    if (isset($values['enabled']) && $values['enabled'] == 0) {
      $valuesCopy['enabled'] = 0;
    }

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
  }

  public function schoolsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_manageschools');

    $this->view->formFilter = $formFilter = new Sesprofilefield_Form_Admin_Manage_School();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('schools', 'sesprofilefield');

    $select = $table->select();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'school_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $select->order((!empty($values['order']) ? $values['order'] : 'school_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

//     if (isset($values['enabled']) && $values['enabled'] != -1)
//       $select->where('enabled = ?', $values['enabled']);

    if (!empty($values['school_id']))
      $select->where('school_id = ?', (int) $values['school_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Reset enabled bit
    if (isset($values['enabled']) && $values['enabled'] == 0) {
      $valuesCopy['enabled'] = 0;
    }

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
  }

  public function degreesAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_managedegrees');

    $this->view->formFilter = $formFilter = new Sesprofilefield_Form_Admin_Manage_Degree();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('degrees', 'sesprofilefield');

    $select = $table->select();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'degree_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $select->order((!empty($values['order']) ? $values['order'] : 'degree_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

//     if (isset($values['enabled']) && $values['enabled'] != -1)
//       $select->where('enabled = ?', $values['enabled']);

    if (!empty($values['degree_id']))
      $select->where('degree_id = ?', (int) $values['degree_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Reset enabled bit
    if (isset($values['enabled']) && $values['enabled'] == 0) {
      $valuesCopy['enabled'] = 0;
    }

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
  }

  public function studysAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_managefieldofstudys');

    $this->view->formFilter = $formFilter = new Sesprofilefield_Form_Admin_Manage_Study();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('studies', 'sesprofilefield');

    $select = $table->select();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'study_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $select->order((!empty($values['order']) ? $values['order'] : 'study_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

//     if (isset($values['enabled']) && $values['enabled'] != -1)
//       $select->where('enabled = ?', $values['enabled']);

    if (!empty($values['study_id']))
      $select->where('study_id = ?', (int) $values['study_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Reset enabled bit
    if (isset($values['enabled']) && $values['enabled'] == 0) {
      $valuesCopy['enabled'] = 0;
    }

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
  }

  public function companiesAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_managecompanies');

    $this->view->formFilter = $formFilter = new Sesprofilefield_Form_Admin_Manage_Company();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('companies', 'sesprofilefield');

    $select = $table->select();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'company_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $select->order((!empty($values['order']) ? $values['order'] : 'company_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

//     if (isset($values['enabled']) && $values['enabled'] != -1)
//       $select->where('enabled = ?', $values['enabled']);

    if (!empty($values['company_id']))
      $select->where('company_id = ?', (int) $values['company_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Reset enabled bit
    if (isset($values['enabled']) && $values['enabled'] == 0) {
      $valuesCopy['enabled'] = 0;
    }

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
  }


  public function positionsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_managepositions');

    $this->view->formFilter = $formFilter = new Sesprofilefield_Form_Admin_Manage_Position();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('positions', 'sesprofilefield');

    $select = $table->select();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'position_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $select->order((!empty($values['order']) ? $values['order'] : 'position_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

//     if (isset($values['enabled']) && $values['enabled'] != -1)
//       $select->where('enabled = ?', $values['enabled']);

    if (!empty($values['position_id']))
      $select->where('position_id = ?', (int) $values['position_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Reset enabled bit
    if (isset($values['enabled']) && $values['enabled'] == 0) {
      $valuesCopy['enabled'] = 0;
    }

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
  }

  public function addAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $type = $this->_getParam('type', null);

    $this->view->form = $form = new Sesprofilefield_Form_Admin_Manage_Add();

    if($type == 'school') {
      $form->setTitle('Add New School');
      $form->name->setLabel('Name');
      $tablename = 'schools';
    } else if($type == 'degree') {
      $form->setTitle('Add New Degree');
      $form->name->setLabel('Name');
      $tablename = 'degrees';
    } else if($type == 'study') {
      $form->setTitle('Add New Field of Study');
      $form->name->setLabel('Name');
      $tablename = 'studies';
    } else if($type == 'position') {
      $form->setTitle('Add New Position');
      $form->name->setLabel('Name');
      $tablename = 'positions';
    } else if($type == 'company') {
      $form->setTitle('Add New Company');
      $form->name->setLabel('Name');
      $tablename = 'companies';
    } else if($type == 'authority') {
      $form->setTitle('Add New Authority');
      $form->name->setLabel('Name');
      $tablename = 'authorities';
    }

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      if (empty($values['photo_id']))
        unset($values['photo_id']);

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $row = Engine_Api::_()->getDbtable($tablename, 'sesprofilefield')->createRow();
        $row->setFromArray($values);
        $row->save();

        if(in_array($type, array('school', 'company', 'authority'))) {
          if (isset($_FILES['photo_id'])) {
            $Icon = $this->setPhoto($form->photo_id, $row->getIdentity());
            if (!empty($Icon->file_id))
              $row->photo_id = $Icon->file_id;
          }
        }

        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully added.')
      ));
    }
  }


  public function editAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $type = $this->_getParam('type', null);
    $id = $this->_getParam('id');

    $this->view->form = $form = new Sesprofilefield_Form_Admin_Manage_Edit();

    if($type == 'school') {
      $form->setTitle('Edit this School');
      $form->name->setLabel('Name');
      $itemType = 'sesprofilefield_school';
    } else if($type == 'degree') {
      $form->setTitle('Edit this Degree');
      $form->name->setLabel('Name');
      $itemType = 'sesprofilefield_degree';
    } else if($type == 'study') {
      $form->setTitle('Edit this Study');
      $form->name->setLabel('Name');
      $itemType = 'sesprofilefield_study';
    } else if($type == 'position') {
      $form->setTitle('Edit this Position');
      $form->name->setLabel('Name');
      $itemType = 'sesprofilefield_position';
    } else if($type == 'company') {
      $form->setTitle('Edit this Company');
      $form->name->setLabel('Name');
      $itemType = 'sesprofilefield_company';
    } else if($type == 'authority') {
      $form->setTitle('Edit this Authority');
      $form->name->setLabel('Name');
      $itemType = 'sesprofilefield_authority';
    }

    $item = Engine_Api::_()->getItem($itemType, $id);

    $form->populate($item->toArray());

    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost())) {
      if (empty($_POST['name'])) {
        $form->addError($this->view->translate("School Name * Please complete this field - it is required."));
      }
      return;
    }

    $values = $form->getValues();

    if (empty($values['photo_id']))
      unset($values['photo_id']);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {

      $item->name = $values['name'];
      $item->save();

      if(in_array($type, array('school', 'company', 'authority'))) {
        if (isset($_FILES['photo_id']) && !empty($_FILES['photo_id']['name'])) {
          $previousIcon = $item->photo_id;
          $Icon = $this->setPhoto($form->photo_id, $cat_id);
          if (!empty($Icon->file_id)) {
            if ($previousIcon) {
              $icon = Engine_Api::_()->getItem('storage_file', $previousIcon);
              $icon->delete();
            }
            $item->photo_id = $Icon->file_id;
            $item->save();
          }
        }

        if (isset($values['remove_photo_id']) && !empty($values['remove_photo_id'])) {
          $icon = Engine_Api::_()->getItem('storage_file', $item->photo_id);
          $item->photo_id = 0;
          $item->save();
          $icon->delete();
        }
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array('You have successfully edited.')
    ));
  }


  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->type = $type = $this->_getParam('type');

    if($type == 'school') {
      $tablename = 'schools';
    } else if($type == 'degree') {
      $tablename = 'degrees';
    } else if($type == 'study') {
      $tablename = 'studies';
    } else if($type == 'position') {
      $tablename = 'positions';
    } else if($type == 'company') {
      $tablename = 'companies';
    } else if($type == 'authority') {
      $tablename = 'authorities';
    }

    $itemTable = Engine_Api::_()->getDbtable($tablename, 'sesprofilefield');

    $item = $itemTable->find($id)->current();

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $item->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully deleted.')
      ));
    }

    $this->renderScript('admin-manage/delete.tpl');
  }

  public function enabledAction() {

    $type = $this->_getParam('type');
    if($type == 'school') {
      $itemType = 'sesprofilefield_school';
      $redirectUrl = 'admin/sesprofilefield/manage/schools';
    } else if($type == 'degree') {
      $itemType = 'sesprofilefield_degree';
      $redirectUrl = 'admin/sesprofilefield/manage/degrees';
    } else if($type == 'study') {
      $itemType = 'sesprofilefield_study';
      $redirectUrl = 'admin/sesprofilefield/manage/studys';
    } else if($type == 'position') {
      $itemType = 'sesprofilefield_position';
      $redirectUrl = 'admin/sesprofilefield/manage/positions';
    } else if($type == 'company') {
      $itemType = 'sesprofilefield_company';
      $redirectUrl = 'admin/sesprofilefield/manage/companies';
    } else if($type == 'authority') {
      $itemType = 'sesprofilefield_authority';
      $redirectUrl = 'admin/sesprofilefield/manage/authorities';
    }

    $id = $this->_getParam('id');

    if (!empty($id)) {
      $item = Engine_Api::_()->getItem($itemType, $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect($redirectUrl);
  }

  public function setPhoto($photo, $cat_id) {

    if ($photo instanceof Zend_Form_Element_File)
      $icon = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
      $icon = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo))
      $icon = $photo;
    else
      return;

    if (empty($icon))
      return;

    $mainName = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary' . '/' . basename($icon);

    $photo_params = array(
        'parent_id' => $cat_id,
        'parent_type' => "sesprofilefield",
    );

    //Resize category icon
    $image = Engine_Image::factory();
    $image->open($icon);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;
    $image->open($icon)
            ->resample($x, $y, $size, $size, 100, 100)
            ->write($mainName)
            ->destroy();
    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }
    //Delete temp file.
    @unlink($mainName);
    return $photoFile;
  }
}
