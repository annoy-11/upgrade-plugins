<?php

class Estore_AdminTaxesController extends Core_Controller_Action_Admin {

    public function indexAction() {

      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_taxes');
      $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_taxes', array(), 'estore_admin_main_admintaxes');

      if ($this->getRequest()->isPost()) {
          $values = $this->getRequest()->getPost();
          foreach ($values as $key => $value) {
              if ($key == 'delete_' . $value) {
                  Engine_Api::_()->getDbtable('taxes', 'estore')->delete(array('tax_id = ?' => $value));
              }
          }
      }

      $this->view->type = $type = $this->_getParam('type',0);
      $this->view->search = $form = new Estore_Form_Admin_Taxes_Search();
      $form->populate($_GET);
      $table = Engine_Api::_()->getDbTable('taxes','estore');
      $taxesTable = $table->info('name');
      $select = $table->select()->from($table->info('name'),'*');

      if($type) {
          $storeTableName = Engine_Api::_()->getDbTable('stores', 'estore')->info('name');
          $select->setIntegrityCheck(false)
                ->joinLeft($storeTableName, $storeTableName . '.store_id =' . $table->info('name').'.store_id', null);
          if(!empty($_GET['store'])){
              $select->where($storeTableName.".title LIKE ? ", '%' . $_GET['store'] . '%');
          }
      }

      if(isset($_GET['status']) && strlen($_GET['status'])){
          $select->where($taxesTable.'.status =?',$_GET['status']);
      }
      if(isset($_GET['type']) && strlen($_GET['type'])){
          $select->where($taxesTable.'.type =?',$_GET['type']);
      }
      if(!empty($_GET['title'])){
          $select->where($taxesTable.".title LIKE ? ", '%' . $_GET['title'] . '%');
      }

      if(!$type){
          $select->where('is_admin =?',1);
      } else
        $select->where('is_admin =?',0);

      $select->order('tax_id DESC');
      $this->view->paginator = $paginator = Zend_Paginator::factory($select);
      $paginator->setItemCountPerPage(10);
      $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
    }

  function addTaxAction() {

      $this->_helper->layout->setLayout('admin-simple');

      $this->view->form = $form = new Estore_Form_Admin_Taxes_Addtaxes();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

          $values = $form->getValues();

          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              $table = Engine_Api::_()->getDbTable('taxes','estore');
              $row = $table->createRow();
              $values = $form->getValues();
              $values['is_admin'] = 1;
              $row->setFromArray($values);
              $row->save();
              $db->commit();
          } catch (Exception $e) {
              $db->rollBack();
              throw $e;
          }

          $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 10,
              'parentRefresh' => 10,
              'messages' => array(Zend_Registry::get('Zend_Translate')->_('Tax added successfully.'))
          ));
      }
  }

  function editTaxAction(){

      $this->_helper->layout->setLayout('admin-simple');
      $id = $this->_getParam('id');
      $tax = Engine_Api::_()->getItem('estore_taxes',$id);
      $this->view->form = $form = new Estore_Form_Admin_Taxes_Addtaxes();
      $form->populate($tax->toArray());
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
      $form->setTitle('Edit Tax');
      $form->submit->setLabel('Edit Tax');
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

          $values = $form->getValues();

          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              $table = Engine_Api::_()->getDbTable('taxes','estore');
              $values = $form->getValues();
              $values['is_admin'] = 1;
              $tax->setFromArray($values);
              $tax->save();
              $db->commit();
          } catch (Exception $e) {
              $db->rollBack();
              throw $e;
          }

          $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 10,
              'parentRefresh' => 10,
              'messages' => array(Zend_Registry::get('Zend_Translate')->_('Tax edited successfully.'))
          ));
      }
  }

  function deleteTaxAction() {

      $id = $this->_getParam('id');
      $tax = Engine_Api::_()->getItem('estore_taxes',$id);
      $this->view->form = $form = new Sesbasic_Form_Delete();
      $form->setTitle('Delete Tax?');
      $form->setDescription('Are you sure that you want to delete this tax? It will not be recoverable after being deleted.');
      $form->submit->setLabel('Delete');

      if (!$this->getRequest()->isPost()) {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
          return;
      }

      $db = $tax->getTable()->getAdapter();
      $db->beginTransaction();

      try {
          $tax->delete();
          $db->commit();
      } catch (Exception $e) {
          $db->rollBack();
          throw $e;
      }

      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Tax has been deleted.');
      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array($this->view->message)
      ));
  }

    function deleteLocationAction() {
        $id = $this->_getParam('id');
        $tax = Engine_Api::_()->getItem('estore_taxstate',$id);
        $this->view->form = $form = new Sesbasic_Form_Delete();
        $form->setTitle('Delete Tax Location?');
        $form->setDescription('Are you sure that you want to delete this location? It will not be recoverable after being deleted.');
        $form->submit->setLabel('Delete');

        if (!$this->getRequest()->isPost()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $db = $tax->getTable()->getAdapter();
        $db->beginTransaction();

        try {
            $tax->delete();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Location has been deleted.');
        return $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array($this->view->message)
        ));
    }
  function enableTaxAction(){
      $id = $this->_getParam('id');
      $tax = Engine_Api::_()->getItem('estore_taxes',$id);
      $tax->status = !$tax->status;
      $tax->save();
      header("Location:".$_SERVER['HTTP_REFERER']);
  }
  function manageTaxAction(){
      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_taxes');
      $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_taxes', array(), 'estore_admin_main_admintaxes');

      if ($this->getRequest()->isPost()) {
          $values = $this->getRequest()->getPost();
          foreach ($values as $key => $value) {
              if ($key == 'delete_' . $value) {
                  Engine_Api::_()->getDbtable('taxstates', 'estore')->delete(array('taxstate_id = ?' => $value));
              }
          }
      }
      $this->view->type = $type = $this->_getParam('type',0);
      $this->view->tax_id = $id = $this->_getParam('id');
      $table = Engine_Api::_()->getDbTable('taxstates','estore');
      $tableName = $table->info('name');
      $select = $table->select()->from($tableName,'*')->setIntegrityCheck(false);

      $stateTable = Engine_Api::_()->getDbTable('states','estore')->info('name');
      $countryTable = Engine_Api::_()->getDbTable('countries','estore')->info('name');

      $select->joinLeft($countryTable,$countryTable.".country_id =".$tableName.".country_id",array('country_name' => 'name'));
      $select->joinLeft($stateTable,$stateTable.".state_id =".$tableName.".state_id",array('state_name' => 'name'));

      if(isset($_GET['status'])){
          $select->where('status =?',$_GET['status']);
      }

      $select->where('tax_id =?',$id);

      if(isset($_GET['tax_type'])){
          $select->where('tax_type =?',$_GET['tax_type']);
      }

      if(isset($_GET['title'])){
          $select->where("title LIKE ? ", '%' . $_GET['title'] . '%');
      }

      $this->view->paginator = $paginator = Zend_Paginator::factory($select);
      $paginator->setItemCountPerPage(10);
      $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  function statesAction(){
      $country_id = $this->_getParam('country_id');
      $stateTable = Engine_Api::_()->getDbTable('states','estore');
      $select = $stateTable->select()->where('status =?',1)->where('country_id =?',$country_id);
      $states = $stateTable->fetchAll($select);
      $statesString = '';

      foreach($states as $state){
          $statesString .= '<option value="'.$state->getIdentity().'">'.$state->name.'</option>';
      }
      echo $statesString;die;
  }

  function addLocationAction(){
      $id = $this->_getParam('id',0);
      if (!$this->_helper->requireUser()->isValid())
          return;

      $this->_helper->layout->setLayout('admin-simple');

      $this->view->form = $form = new Estore_Form_Admin_Taxes_AddLocation();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      //get all countries
      $countries = Engine_Api::_()->getDbTable('countries','estore')->fetchAll(Engine_Api::_()->getDbTable('countries','estore')->select()->where('status =?',1));

      $countriesArray = array('0'=>'All Countries');
      foreach($countries as $country){
          $countriesArray[$country->getIdentity()] = $country['name'];
      }
      $form->country_id->setMultiOptions($countriesArray);
      if($id){
          $form->removeElement('country_id');
          $form->removeElement('state_id');
          $form->removeElement('location_type');
          $row = Engine_Api::_()->getItem('estore_taxstate',$id);
          $form->populate($row->toArray());
          $form->submit->setLabel('Edit Location');
          $form->setTitle('Edit Location');

          $tax_type = $row['tax_type'];
          if($tax_type == "0"){
              $form->fixed_price->setValue($row['value']);
          }else{
              $form->percentage_price->setValue($row['value']);
          }


      }
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
          $values = $form->getValues();
          $tax_type = $_POST['tax_type'];
          if($tax_type == "0"){
              $price = $_POST['fixed_price'];
          }else{
              $price = $_POST['percentage_price'];
          }
          if(!Engine_Api::_()->estore()->isValidPriceValue($price)){
              if($tax_type == "0") {
                  $form->addError('Enter valid Price.');
              }else{
                  $form->addError('Enter valid %age Price.');
              }
              return;
          }

          if(!empty($_POST['country_id']) && $_POST['location_type'] == 0 && empty($_POST['state_id'])){
              $form->addError('Select state to enable tax.');
              return;
          }

          //$db = Engine_Db_Table::getDefaultAdapter();
          //$db->beginTransaction();
          try {
              $table = Engine_Api::_()->getDbTable('taxstates','estore');
              $values = $form->getValues();

              if(empty($row)) {
                  $state = !empty($_POST['state_id']) ? $_POST['state_id'] : array('0');
                  if(!$values['country_id']){
                      $state = array(0);
                  }
                  $values['tax_id'] = $this->_getParam('tax_id');
              }else{
                  $state = array(0);
              }

              foreach ($state as $state) {
                  if(empty($row)){
                      $taxstate = $table->createRow();
                      $values['state_id'] = $state;
                  }else{
                      $taxstate = $row;
                  }
                  $tax_type = $_POST['tax_type'];
                  if ($tax_type == "0") {
                      $values['value'] = $_POST['fixed_price'];
                  } else {
                      $values['value'] = $_POST['percentage_price'];
                  }
                  $taxstate->setFromArray($values);
                  $taxstate->save();
                  //$db->commit();
              }
          } catch (Exception $e) {
              //$db->rollBack();
              throw $e;
          }

          $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 100,
              'parentRefresh' => 100,
              'messages' => array(Zend_Registry::get('Zend_Translate')->_('Tax added successfully.'))
          ));
      }
  }
    function enableLocationTaxAction(){
        $id = $this->_getParam('id');
        $tax = Engine_Api::_()->getItem('estore_taxstate',$id);
        $tax->status = !$tax->status;
        $tax->save();
        header("Location:".$_SERVER['HTTP_REFERER']);
    }
}
