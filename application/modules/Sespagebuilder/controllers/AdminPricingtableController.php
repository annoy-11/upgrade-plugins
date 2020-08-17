<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPricingtableController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_AdminPricingtableController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_pricingtable');
    $this->view->pages = Engine_Api::_()->getItemTable('sespagebuilder_content')->getContent('pricing_table');
  }

  public function createAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_pricingtable');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Managecontent_Create();
    $form->setTitle('Create New Pricing Table');
    $form->setDescription('Below, create a new pricing table and choose the various display criterias in the “Pricing Table” widget or while getting the shortcode.');
    $form->title->setLabel('Title');
    $form->title->setDescription('Enter the title of this pricing table.');

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
      $tabs = $table->createRow();
      $values['type'] = 'pricing_table';
      $tabs->setFromArray($values);
      $tabs->save();
      $content_id = $tabs->content_id;
      $tabs->short_code = '[price_table_' . $content_id . ']';
      $tabs->save();
      $db->commit();
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'index'), 'admin_default', true);
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_pricingtable');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Managecontent_Edit();
    
    $form->setTitle('Edit Pricing Table');
    $form->setDescription('Below, edit this pricing table content and other parameters.');
    $form->title->setLabel('Title');
    $form->title->setDescription('Enter the title of this pricing table.');

    $table = Engine_Api::_()->getItem('sespagebuilder_content', $this->_getParam('id'));
    $this->view->show_short_code = $table->show_short_code;

    //Populate form
    $form->populate($table->toArray());

    //Check post/form
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $table->setFromArray($form->getValues());
      $table->save();
      $content_id = $table->content_id;
      $table->short_code = '[price_table_' . $content_id . ']';
      $table->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'index'), 'admin_default', true);
  }

  public function manageTablesAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_pricingtable');

    $this->view->content_id = $id = $this->_getParam('content_id');

    //Get all table columns
    $this->view->columns = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder')->getPricingTable($id);
  }

  //Add table column
  public function addColumnAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_pricingtable');

    //Generate and assign form
    $this->view->form = $form = new Sespagebuilder_Form_Admin_Pricingtable_Add();
    $this->view->content_id = $tableId = $this->_getParam('content_id');

    //POPULATE CURRENCY 
    $this->getCurrencyOptions($form);

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      $existColumnArray = array('column_name', 'column_title', 'column_width', 'column_row_color', 'column_row_text_color', 'icon_position', 'currency', 'show_currency', 'currency_value', 'currency_duration', 'column_description', 'footer_text', 'footer_text_color', 'footer_bg_color', 'column_text_color', 'text_url', 'column_color', 'show_highlight', 'submit', 'MAX_FILE_SIZE');

      $db = Engine_Db_Table::getDefaultAdapter();

      foreach ($_POST as $key => $value) {
        $columnName = $key;
        if (in_array($columnName, $existColumnArray))
          continue;

        $explodedColumnName = explode('_', $columnName);

        if (!isset($explodedColumnName[2]))
          continue;

        $explodeKey = end(explode('_', $key));
        $column = $db->query("SHOW COLUMNS FROM engine4_sespagebuilder_pricingtables LIKE '$columnName'")->fetch();
        if (empty($column)) {
          if ($explodeKey == 'text')
            $db->query("ALTER TABLE `engine4_sespagebuilder_pricingtables` ADD $columnName VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");
          else
            $db->query("ALTER TABLE `engine4_sespagebuilder_pricingtables` ADD $columnName TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        }
      }

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $pricingTable = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder');
        $row = $pricingTable->createRow();
        $row->setFromArray($values);
        $row->table_id = $tableId;
        $row->save();
        $column_id = $row->pricingtable_id;

        $rowCount = Engine_Api::_()->getItem('sespagebuilder_content', $tableId)->num_row;
        $tabs_count = array();
        for ($i = 1; $i <= $rowCount; $i++) {
          $columnCountArray[] = $i;
        }

        //Upload accordions icon
        foreach ($columnCountArray as $coulmnCount) {
          $tableColumnName = 'row' . $coulmnCount . '_file_id';
          if (isset($_FILES[$tableColumnName]) && !empty($_FILES[$tableColumnName]['name'])) {
            $Icon = $row->setPhoto($form->$tableColumnName, $row->pricingtable_id);
            if (!empty($Icon->file_id))
              $row->$tableColumnName = $Icon->file_id;
          }
        }

        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      if (isset($_POST['save']))
        return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'edit-column', 'id' => $column_id, 'content_id' => $tableId), 'admin_default', true);
      else
        return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'manage-tables', 'content_id' => $tableId), 'admin_default', true);
    }
  }

  public function editColumnAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_pricingtable');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Pricingtable_Edit();

    $this->view->content_id = $tableId = $this->_getParam('content_id');
    $this->view->column_id = $column_id = $this->_getParam('id');
    $this->view->showElements = $column = Engine_Api::_()->getItem('sespagebuilder_pricingtables', $column_id);
    $form->populate($column->toArray());

    $this->getCurrencyOptions($form);

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check 
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {

      $values = $form->getValues();

      $rowCount = Engine_Api::_()->getItem('sespagebuilder_content', $tableId)->num_row;
      $tabs_count = array();
      for ($i = 1; $i <= $rowCount; $i++) {
        $columnCountArray[] = $i;
      }

      foreach ($columnCountArray as $coulmnCount) {
        $tableColumnName = 'row' . $coulmnCount . '_file_id';
        if (empty($values[$tableColumnName]))
          unset($values[$tableColumnName]);
      }

      $column->setFromArray($values);
      $column->save();

      foreach ($columnCountArray as $coulmnCount) {

        $tableColumnName = 'row' . $coulmnCount . '_file_id';
        if (isset($_FILES[$tableColumnName]) && !empty($_FILES[$tableColumnName]['name'])) {
          $Icon = $column->setPhoto($form->$tableColumnName, $row->pricingtable_id);
          $previousColumnIcon = $column->$tableColumnName;

          if (!empty($Icon->file_id)) {
            if ($previousColumnIcon) {
              $columnIcon = Engine_Api::_()->getItem('storage_file', $previousColumnIcon);
              if ($columnIcon)
                $columnIcon->delete();
            }
            $column->$tableColumnName = $Icon->file_id;
            $column->save();
          }
        }

        if (isset($values['remove_row' . $coulmnCount . '_icon']) && !empty($values['remove_row' . $coulmnCount . '_icon'])) {
          $columnIcon = Engine_Api::_()->getItem('storage_file', $column->$tableColumnName);
          $column->$tableColumnName = 0;
          $column->save();
          $columnIcon->delete();
        }
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'edit-column', 'id' => $column_id, 'content_id' => $this->_getParam('content_id')), 'admin_default', true);
    else
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'manage-tables', 'content_id' => $this->_getParam('content_id')), 'admin_default', true);
  }

  public function deleteAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Pricing Table?');
    $form->setDescription('Are you sure that you want to delete this pricing table entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder')->delete(array('table_id =?' => $this->_getParam('id')));

        $tab = Engine_Api::_()->getItem('sespagebuilder_content', $this->_getParam('id'));
        $tab->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully delete this tab entry.')
      ));
    }
    //Output
    $this->renderScript('admin-pricingtable/deletetable.tpl');
  }

  public function duplicateTableAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $tableId = $this->_getParam('content_id');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $contentItem = Engine_Api::_()->getItem('sespagebuilder_content', $tableId);

        $contentTable = Engine_Api::_()->getDbtable('contents', 'sespagebuilder');
        $tabs = $contentTable->createRow();
        $tabs->title = $contentItem->title;
        $tabs->description = $contentItem->description;
        $tabs->type = 'pricing_table';
        $tabs->save();
        $content_id = $tabs->content_id;
        $tabs->short_code = '[price_table_' . $content_id . ']';
        $tabs->save();

        $pricingTable = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder');
        $tableColumns = $pricingTable->getPricingTable($tableId);

        foreach ($tableColumns as $columnObject) {

          $row = $pricingTable->createRow();
          $row->table_id = $content_id;


          $columns = $db->query("SHOW COLUMNS FROM engine4_sespagebuilder_pricingtables")->fetchAll();
          foreach ($columns as $tableColumn) {
            $coulmn = $tableColumn['Field'];
            $fileIdArray = array('row1_file_id', 'row2_file_id', 'row3_file_id', 'row4_file_id', 'row5_file_id', 'row6_file_id', 'row7_file_id', 'row8_file_id', 'row9_file_id', 'row10_file_id', 'row11_file_id', 'row12_file_id', 'row13_file_id');
            if ($coulmn == 'pricingtable_id' || $coulmn == 'table_id' || in_array($coulmn, $fileIdArray))
              continue;
            $row->$coulmn = $columnObject->$coulmn;
          }
          $row->save();
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'edit', 'id' => $content_id), 'admin_default', true),
          'messages' => array('You have successfully duplicate this t entry.')
      ));
    }
    //Output
    $this->renderScript('admin-pricingtable/duplicate-table.tpl');
  }

  //Delete accordion
  public function deleteColumnAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete This Column?');
    $form->setDescription('Are you sure that you want to delete this column entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    $this->view->id = $id = $this->_getParam('id');

    $columnTable = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder');
    $column = $columnTable->find($id)->current();

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $column->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully delete table column.')
      ));
    }
    //Output
    $this->renderScript('admin-pricingtable/delete.tpl');
  }

  //Duplicate column
  public function duplicateColumnAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->id = $id = $this->_getParam('id');

    $columnTable = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder');
    $columnObject = $columnTable->find($id)->current();

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $row = $columnTable->createRow();
        $row->table_id = $columnObject->table_id;

        $columns = $db->query("SHOW COLUMNS FROM engine4_sespagebuilder_pricingtables")->fetchAll();
        foreach ($columns as $tableColumn) {
          $coulmn = $tableColumn['Field'];
          $fileIdArray = array('row1_file_id', 'row2_file_id', 'row3_file_id', 'row4_file_id', 'row5_file_id', 'row6_file_id', 'row7_file_id', 'row8_file_id', 'row9_file_id', 'row10_file_id', 'row11_file_id', 'row12_file_id');
          if ($coulmn == 'pricingtable_id' || $coulmn == 'table_id' || in_array($coulmn, $fileIdArray))
            continue;
          $row->$coulmn = $columnObject->$coulmn;
        }
        $row->save();
        $newColumnId = $row->pricingtable_id;

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'edit-column', 'id' => $newColumnId, 'content_id' => $columnObject->table_id), 'admin_default', true),
                  'messages' => array('You have successfully duplicate column.')
      ));
    }
    //Output
    $this->renderScript('admin-pricingtable/duplicate-column.tpl');
  }

  public function getCurrencyOptions($form) {

    //POPULATE CURRENCY 
    $supportedCurrencyIndex = array();
    $fullySupportedCurrencies = array();
    $supportedCurrencies = array();
    $gateways = array();
    $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    foreach ($gatewaysTable->fetchAll() as $gateway) {
      $gateways[$gateway->gateway_id] = $gateway->title;
      $gatewayObject = $gateway->getGateway();
      $currencies = $gatewayObject->getSupportedCurrencies();
      if (empty($currencies))
        continue;
      $supportedCurrencyIndex[$gateway->title] = $currencies;
      if (empty($fullySupportedCurrencies))
        $fullySupportedCurrencies = $currencies;
      else
        $fullySupportedCurrencies = array_intersect($fullySupportedCurrencies, $currencies);
      $supportedCurrencies = array_merge($supportedCurrencies, $currencies);
    }
    $supportedCurrencies = array_diff($supportedCurrencies, $fullySupportedCurrencies);

    $translationList = Zend_Locale::getTranslationList('nametocurrency', Zend_Registry::get('Locale'));
    $fullySupportedCurrencies = array_intersect_key($translationList, array_flip($fullySupportedCurrencies));
    $supportedCurrencies = array_intersect_key($translationList, array_flip($supportedCurrencies));

    $form->getElement('currency')->setMultiOptions(array(
        '' => '',
        'Fully Supported' => $fullySupportedCurrencies,
        'Partially Supported' => $supportedCurrencies,
    ));
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder');
    $columns = $table->fetchAll($table->select());
    foreach ($columns as $column) {
      $order = $this->getRequest()->getParam('columns_' . $column->pricingtable_id);
      if ($order) {
        $column->order = $order;
        $column->save();
      }
    }
    return;
  }

}
