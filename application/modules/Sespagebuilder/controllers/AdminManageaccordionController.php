<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageaccordionController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_AdminManageaccordionController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manageaccordions');
    $this->view->pages = Engine_Api::_()->getItemTable('sespagebuilder_content')->getContent('accordion');
  }

  public function createAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manageaccordions');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Accordion_Createaccordion();

    //If not post or form not valid, return
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $table = Engine_Api::_()->getDbtable('contents', 'sespagebuilder');
    $values = $form->getValues();

    $db = Engine_Db_Table::getDefaultAdapter();
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      $createAccordion = $table->createRow();
      $values['type'] = 'accordion';
      $createAccordion->setFromArray($values);
      $createAccordion->save();
      $accordionId = $createAccordion->content_id;
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit', 'id' => $accordionId), 'admin_default', true);
    else
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion'), 'admin_default', true);
  }

  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manageaccordions');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Accordion_Editaccordion();

    $accordionId = $this->_getParam('id');
    $accordionObject = Engine_Api::_()->getItem('sespagebuilder_content', $accordionId);
    $this->view->show_short_code = $accordionObject->show_short_code;

    //Populate form
    $form->populate($accordionObject->toArray());

    //Check post/form
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();
      $accordionObject->setFromArray($values);
      $accordionObject->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit', 'id' => $accordionId), 'admin_default', true);
    else
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion'), 'admin_default', true);
  }

  public function manageAccordionsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manageaccordions');

    $this->view->content_id = $id = $this->_getParam('content_id');

    //Get all accordions
    $this->view->accordions = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->getAccordion($id);
  }

  //Add accordion
  public function addAccordionAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manageaccordions');

    $accordion_id = $this->_getParam('accordion_id');
    $subaccordion_id = $this->_getParam('subaccordion_id');
    $contentId = $this->_getParam('content_id');

    //Generate and assign form
    $this->view->form = $form = new Sespagebuilder_Form_Admin_Accordion_Add();
    if (empty($accordion_id)) {
      $form->setTitle('Add New Accordion Menu Item');
      $form->setDescription('Here, create a new accordion menu item.');
      $form->accordion_name->setLabel('Menu Item Title');
      $form->accordion_name->setDescription('Enter a title for this menu item.');
    } elseif ($accordion_id && empty($subaccordion_id)) {
      $form->setTitle('Add Sub Accordion Menu Item');
      $form->setDescription('Here, create a new sub accordion menu item.');
      $form->accordion_name->setLabel('Sub Menu Item Title');
      $form->accordion_name->setDescription('Enter a title for this sub menu item.');
    } else {
      $form->setTitle('Add 3rd Accordion Name');
      $form->accordion_name->setLabel('3rd Accordion Name');
      $form->accordion_name->setLabel('3rd Menu Item Title');
      $form->accordion_name->setDescription('Enter a title for this 3rd menu item.');
    }

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      if (empty($values['accordion_icon']))
        unset($values['accordion_icon']);

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        //Create row in accordions table
        $row = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->createRow();
        $values['id'] = $contentId;

        //Subaccordion and third level accordion work
        if ($accordion_id && empty($subaccordion_id))
          $values['subaccordion_id'] = $accordion_id;
        elseif ($accordion_id && $subaccordion_id)
          $values['subsubaccordion_id'] = $accordion_id;

        $row->setFromArray($values);
        $row->save();
        $accordionId = $row->accordion_id;

        //Upload accordions icon
        if (isset($_FILES['accordion_icon'])) {
          $Icon = $row->setPhoto($form->accordion_icon, $row->accordion_id);
          if (!empty($Icon->file_id))
            $row->accordion_icon = $Icon->file_id;
        }

        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      if (isset($_POST['save'])) {
        if ($accordion_id)
          return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit-accordion', 'id' => $accordionId, 'cataccordion' => 'sub', 'accordion_id' => $accordion_id, 'content_id' => $contentId), 'admin_default', true);
        else
          return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit-accordion', 'id' => $accordionId, 'cataccordion' => 'maincat', 'content_id' => $contentId), 'admin_default', true);
      } else
        return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'manage-accordions', 'content_id' => $contentId), 'admin_default', true);
    }
  }

  //Edit Accordion
  public function editAccordionAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manageaccordions');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Accordion_Edit();

    $cataccordion = $this->_getParam('cataccordion');
    if ($cataccordion == 'maincat') {
      $form->setTitle('Edit Menu Item');
      $form->accordion_name->setLabel('Menu Item Title');
      $form->setDescription('Below, edit this accordion menu item.');
      $form->accordion_name->setDescription('Enter a title for this menu item.');
    } elseif ($cataccordion == 'sub') {
      $form->setTitle('Edit Sub Menu Item');
      $form->setDescription('Below, edit this sub accordion menu item.');
      $form->accordion_name->setLabel('Sub Menu Item Title');
      $form->accordion_name->setDescription('Enter a title for this sub menu item.');
    } elseif ($cataccordion == 'subsub') {
      $form->setTitle('Edit 3rd Menu Item');
      $form->setDescription('Below, edit this 3rd accordion menu item.');
      $form->accordion_name->setLabel('3rd Menu Item Title');
      $form->accordion_name->setDescription('Enter a title for this 3rd menu item.');
    }

    $accordion_id = $this->_getParam('id');
    $this->view->content_id = $contentId = $this->_getParam('content_id');
    $mainAccordionId = $this->_getParam('accordion_id');
    $accordion = Engine_Api::_()->getItem('sespagebuilder_accordions', $accordion_id);
    $form->populate($accordion->toArray());

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check 
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $values = $form->getValues();
    if (empty($values['accordion_icon']))
      unset($values['accordion_icon']);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {

      $accordion->accordion_name = $values['accordion_name'];
      $accordion->accordion_url = $values['accordion_url'];
      $accordion->save();

      //Upload accordions icon
      if (isset($_FILES['accordion_icon']) && !empty($_FILES['accordion_icon']['name'])) {
        $previousCatIcon = $accordion->accordion_icon;
        $Icon = $accordion->setPhoto($form->accordion_icon, $accordion_id);
        if (!empty($Icon->file_id)) {
          if ($previousCatIcon) {
            $accordionIcon = Engine_Api::_()->getItem('storage_file', $previousCatIcon);
            $accordionIcon->delete();
          }
          $accordion->accordion_icon = $Icon->file_id;
          $accordion->save();
        }
      }

      if (isset($values['remove_accordion_icon']) && !empty($values['remove_accordion_icon'])) {
        //Delete accordions icon
        $accordionIcon = Engine_Api::_()->getItem('storage_file', $accordion->accordion_icon);
        $accordion->accordion_icon = 0;
        $accordion->save();
        $accordionIcon->delete();
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    if (isset($_POST['save'])) {
      if ($mainAccordionId)
        return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit-accordion', 'id' => $accordion_id, 'cataccordion' => 'sub', 'accordion_id' => $mainAccordionId, 'content_id' => $contentId), 'admin_default', true);
      else
        return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit-accordion', 'id' => $accordion_id, 'cataccordion' => 'maincat', 'content_id' => $contentId), 'admin_default', true);
    } else
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'manage-accordions', 'content_id' => $contentId), 'admin_default', true);
  }

  public function deleteAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->cataccordion = $menuType = $this->_getParam('cataccordion');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->submit->setLabel('Delete');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $accordionTable = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder');
        $selectAccordionTable = $accordionTable->select()->where('id =?', $this->_getParam('id'));
        $accordions = $accordionTable->fetchAll($selectAccordionTable);

        if (count($accordions) && $menuType != 'maincat' && $menuType != 'sub') {
          foreach ($accordions as $accordion) {
            $selectAccordionTable = $accordionTable->select()->where('id =?', $accordion->accordion_id);
            $subAccordions = $accordionTable->fetchAll($selectAccordionTable);
            if (count($subAccordions)) {
              foreach ($subAccordions as $subAccordion) {
                $accordionTable->delete(array('accordion_id =?' => $subAccordion->accordion_id));
              }
            }
            $accordionTable->delete(array('accordion_id =?' => $accordion->accordion_id));
          }
        } else {
          foreach ($accordions as $accordion) {
            $accordionTable->delete(array('accordion_id =?' => $accordion->accordion_id));
          }
        }

        if ($menuType != 'maincat' && $menuType != 'sub') {
          $tab = Engine_Api::_()->getItem('sespagebuilder_content', $this->_getParam('id'));
          $tab->delete();
        }
        // if($menuType == 'sub') {
        $accordion = Engine_Api::_()->getItem('sespagebuilder_accordions', $this->_getParam('id'));
        $accordion->delete();
        //}
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully deleted this.')
      ));
    }
  }

  //Delete accordion icon
  public function deleteIconAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Icon?');
    $form->setDescription('Are you sure that you want to delete this icon? It will not be recoverable after being deleted. ');
    $form->submit->setLabel('Delete');

    $this->view->id = $id = $this->_getParam('accordion_id');
    $cataccordion = $this->_getParam('cataccordion');
    $accordionTable = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder');

    //Check post
    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $mainPhoto = Engine_Api::_()->getItemTable('storage_file')->getFile($this->_getParam('file_id'));
        $mainPhoto->delete();

        if ($cataccordion == 'maincat' || $cataccordion == 'sub' || $cataccordion == 'subsub')
          $accordionTable->update(array('accordion_icon' => 0), array('accordion_id = ?' => $id));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully delete accordion icon.')
      ));
    }
  }

}
