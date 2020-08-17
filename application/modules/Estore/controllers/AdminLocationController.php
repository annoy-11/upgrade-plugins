<?php

class Estore_AdminLocationController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('estore_admin_main', array(), 'estore_admin_main_location');

    $this->view->formFilter = $formFilter = new Estore_Form_Admin_Shipping_Filter();

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          Engine_Api::_()->getDbtable('countries', 'estore')->delete(array('country LIKE ?' => $value));
        }
      }
    }

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $table = Engine_Api::_()->getDbtable('countries', 'estore');
    $select = $table->select()->order('name');

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

    if (isset($values['status']) && $values['status'] != '')
      $select->where('status = ?', $values['status']);

    $this->view->paginator = $paginator =  Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function addCountryAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Estore_Form_Admin_Location_Addcountry();
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    $country_id = $this->_getParam('country_id');
    if($country_id) {
        $form->country->setValue($country_id);
        $form->country->setAttrib('disabled', 'disabled');
    }

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $states = (array) $this->_getParam('states');
        $states = @array_filter(array_map('trim', $states));
        $states = @array_unique($states);
        $stateTable = Engine_Api::_()->getDbtable('states', 'estore');
        $valuesState = array();
        if($country_id)
            $values['country_id'] = $country_id;
        foreach ($states as $state) {
            //check state exists
            $select = $stateTable->select()->where('name = ?',$state)->where('country_id =?',$values['country']);
            if(!$stateTable->fetchRow($select)) {
                $valuesState['country_id'] = $values['country'];
                $valuesState['name'] = $state;
                $valuesState['status'] = 1;
                $row = $stateTable->createRow();
                $row->setFromArray($valuesState);
                $row->save();
            }
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('States added successfully.'))
      ));
    }
  }

  public function manageStateAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_location');

    $this->view->formFilter = $formFilter = new Estore_Form_Admin_Shipping_FilterState();

    $this->view->country_id = $country_id = $this->_getParam('id', null);
    $this->view->country = Engine_Api::_()->getItem('estore_country',$country_id)->name;

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $state = Engine_Api::_()->getItem('estore_state', $value);
            $state->delete();
        }
      }
    }

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $table = Engine_Api::_()->getDbtable('states', 'estore');
    $select = $table->select()->where('country_id =?',$country_id)->order('name');

    if (!empty($values['name']))
      $select->where('name LIKE ?', '%' . $values['name'] . '%');

    if (isset($values['status']) && $values['status'] != '')
      $select->where('status = ?', $values['status']);

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $this->view->paginator->setItemCountPerPage(20);
    $this->view->paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function enableStateAction() {

    $id = $this->_getParam('id', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $state = Engine_Api::_()->getItem('estore_state', $id);
      $state->status = !$state->status;
      $state->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-state', 'id' => $state->country_id));
  }

  public function enableCountryAction() {
    $id = $this->_getParam('id');
    $country = Engine_Api::_()->getItem('estore_country',$id);
    $country->status = !$country->status;
    $country->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function editStateAction() {

    $this->view->form = $form = new Estore_Form_Admin_Location_Editstate();

    $state = Engine_Api::_()->getItem('estore_state', $this->_getParam('id', false));
    $form->populate($state->toArray());

    $country = Engine_Api::_()->getItem('estore_country',$state->country_id);
    $form->country->setValue($country->name);

    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValidPartial($this->getRequest()->getPost()))
      return;

    $table = Engine_Api::_()->getDbtable('states', 'estore');

    $values = $form->getValues();
    $name = $values['name'];
    $select = $table->select()->where('name =?',$name)->where('country_id =?',$state->country_id)->where('state_id !=?',$state->getIdentity());
    $row = $table->fetchRow($select);
    if (!empty($row)) {
      $form->addError($this->view->translate('State already exist for this country.'));
      return;
    }

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
        $state->name = $values['name'];
        $state->save();
        $db->commit();
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('State edited successfully.'))
        ));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function deleteStateAction() {

    $this->_helper->layout->setLayout('admin-simple');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $state = Engine_Api::_()->getItem('estore_state', $this->_getParam('id'));
        $state->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('State deleted successfully.'))
      ));
    }
  }

  public function importCountryAction() {

    ini_set('memory_limit', '2048M');
    set_time_limit(0);

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Estore_Form_Admin_Location_Import();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $ext = str_replace(".", "", strrchr($_FILES['filename']['name'], "."));
      if (!in_array($ext, array('csv', 'CSV'))) {
        $error = $this->view->translate("Only 'csv' extension is allowed.");
        $error = Zend_Registry::get('Zend_Translate')->_($error);
        $form->addError($error);
        return;
      }

      $fname = $_FILES['filename']['tmp_name'];
      $fp = fopen($fname, "r");

      if (!$fp) {
        $form->addError('Empty file.');
        return;
      }

        $values = $form->getValues();

        if($values['seprator'] == 1)
            $seprator = "|";
        else
            $seprator = ",";

        while ($buffer = fgets($fp, 4096)) {
            $csvData[] = explode($seprator, $buffer);
        }
      $countryTable = Engine_Api::_()->getDbTable('countries','estore');
      $stateTable = Engine_Api::_()->getDbTable('states','estore');
      foreach ($csvData as $data) {
          $insertData = array();
          $insertData['country_id'] = trim($data[0]);
          $insertData['name'] = trim($data[1]);
          $insertData['status'] = trim($data[2]);
        //check countrycode
          $select = $countryTable->select()->where('sortname =?',$data[0]);
          $row = $countryTable->fetchRow($select);
          if(!$row)
              continue;
          $insertData['country_id'] = $row->getIdentity();
        if (empty($insertData['country_id']) || empty($insertData['name']))
          continue;
        //check state exists
        $selectState = $stateTable->select()->where('name =?',$insertData['name']);
        if($stateTable->fetchRow($selectState))
            continue;
        $db = $stateTable->getAdapter();
        $db->beginTransaction();
        try {
          $state = $stateTable->createRow();
          $state->setFromArray($insertData);
          $state->save();
          $db->commit();
        } catch (Exception $e) {
          $db->rollBack();
          throw $e;
        }
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRedirect' => false,
          'format' => 'smoothbox',
		    'messages' => array(Zend_Registry::get('Zend_Translate')->_('CSV file has been imported succesfully !'))
      ));
    }
  }

  public function importAction()
  {
      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
          ->getNavigation('estore_admin_main', array(), 'estore_admin_main_location');

  }

  public function downloadAction() {
      $path = realpath(APPLICATION_PATH . "/application/modules/Estore/externals");
      $path = $path.'/import_location.csv';
      header("Content-Disposition: attachment; filename=" . urlencode(basename($path)), true);
      header("Content-Transfer-Encoding: Binary", true);
      header("Content-Type: application/x-tar", true);
      header("Content-Type: application/force-download", true);
      header("Content-Type: application/octet-stream", true);
      header("Content-Type: application/download", true);
      header("Content-Description: File Transfer", true);
      header("Content-Length: " . filesize($path), true);
      readfile($path);

      exit();
  }

  public function viewCountriesCodeAction()
  {
    $tbale = Engine_Api::_()->getDbTable('countries','estore');
    $countries = $tbale->fetchAll($tbale->select()->order('name'));
    $this->view->countries = $countries;
  }
}
