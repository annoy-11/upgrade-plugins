<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesadvancedheader_customheaders\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvancedheader.pluginactivated', 1);
    }

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvancedheader_admin_main', array(), 'sesadvancedheader_admin_main_settings');

    $this->view->form = $form = new Sesadvancedheader_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesadvancedheader/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedheader.pluginactivated')) {
        foreach ($values as $key => $value) {
          if($value != '')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvancedheader_admin_main', array(), 'sesadvancedheader_admin_main_typography');

    $this->view->form = $form = new Sesadvancedheader_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sesadvheader_mainmenu']);

      $db = Engine_Db_Table::getDefaultAdapter();
        foreach ($values as $key => $value) {

          if($values['sesadvancedheader_googlefonts']) {
            unset($values['sesadvheader_mainmenu_fontfamily']);
            unset($values['sesadvheader_mainmenu_fontsize']);
            if($values['sesadvheader_googlemainmenu_fontfamily'])
              Engine_Api::_()->sesadvancedheader()->readWriteXML('sesadvheader_mainmenu_fontfamily', $values['sesadvheader_googlemainmenu_fontfamily']);
            if($values['sesadvheader_googlemainmenu_fontsize'])
              Engine_Api::_()->sesadvancedheader()->readWriteXML('sesadvheader_mainmenu_fontsize', $values['sesadvheader_googlemainmenu_fontsize']);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sesadvheader_googleheading_fontfamily']);
            unset($values['sesadvheader_googlemainmenu_fontsize']);
            Engine_Api::_()->sesadvancedheader()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());

    }
  }

  public function stylingAction() {

    //create default theme and custom theme
    /*$db = Engine_Db_Table::getDefaultAdapter();
    $defaultConstants = Engine_Api::_()->sesadvancedheader()->themeConstants();
    //insert theme constans in table
    for($i = 1;$i<7;$i++){
        if($i == 1){
           $values = Engine_Api::_()->sesadvancedheader()->themeOneConstants();
        }else if($i == 2){
           $values = Engine_Api::_()->sesadvancedheader()->themeTwoConstants();
        }else if($i == 3){
           $values = Engine_Api::_()->sesadvancedheader()->themeThreeConstants();
        }else if($i == 4){
           $values = Engine_Api::_()->sesadvancedheader()->themeFourConstants();
        }else if($i == 5){
           $values = Engine_Api::_()->sesadvancedheader()->themeFiveConstants();
        }else if($i == 6){
           $values = Engine_Api::_()->sesadvancedheader()->themeSixConstants();
        }
        foreach($defaultConstants as $key=>$value){
          if(!empty($values[$key]))
            $valueConstant = $values[$key];
          else
            $valueConstant = "";
          $db->query("INSERT IGNORE INTO engine4_sesadvancedheader_customheaders (column_key,is_custom,header_id,value) VALUES ('".$value."','0','".$i."','".$valueConstant."')");
        }
    }

    //create custon theme
    $db->query("INSERT IGNORE INTO engine4_sesadvancedheader_customheaders (column_key,is_custom,header_id,value) SELECT column_key,1,header_id,value FROM engine4_sesadvancedheader_customheaders");*/


    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvancedheader_admin_main', array(), 'sesadvancedheader_admin_main_styling');

    $this->view->customheader_id = $this->_getParam('customheader_id', null);

    $this->view->form = $form = new Sesadvancedheader_Form_Admin_Styling();

    $isDefaultTheme = isset($_POST['header_color']) && $_POST['header_color'] == 5 ? true : (count($_POST) == 0 ? true : false);

    if (($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) || !$isDefaultTheme ) {

      $values = $form->getValues();

      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      $is_custom = $_POST['header_color'] == 5 ? 1 : 0;
      $header_id =  $_POST['header_color'] != $_POST['header_color'] ? 1 : $_POST['custom_header_color'];

      if($is_custom) {
        if(empty($_POST['submit'])) {
          if($_POST['header_color']) {
            Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvancedheaderheader_color',$_POST['header_color']);
          }
          if($_POST['custom_header_color']) {
            Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvancedheadercustom_header_color',$_POST['custom_header_color']);
          }
        }
        unset($values['header_color']);
        unset($values['custom_header_color']);
        unset($values['save']);
        unset($values['submit']);
        if($_POST['header_color'] == 5) {
          foreach ($values as $key => $value) {
            $db->query("INSERT INTO `engine4_sesadvancedheader_customheaders` (`value`, `column_key`,`is_custom`,`header_id`) VALUES ('".$value."','".$key."','".$is_custom."','".$header_id."') ON DUPLICATE KEY UPDATE `value`='".$value."';");
            Engine_Api::_()->sesadvancedheader()->readWriteXML($key, $value, '');
          }
        }
      } else {
        $header_id = $_POST['header_color'];
        $themecustom = Engine_Api::_()->getDbTable('customheaders','sesadvancedheader')->getHeaderKey(array('header_id'=>$header_id, 'is_custom' => 0));
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvancedheaderheader_color',$_POST['header_color']);
        foreach($themecustom as $key => $value) {
          Engine_Api::_()->sesadvancedheader()->readWriteXML($value->column_key, $value->value, '');
        }
      }

//       //Clear scaffold cache
//       Core_Model_DbTable_Themes::clearScaffoldCache();
//       //Increment site counter
//       $settings->core_site_counter = Engine_Api::_()->getApi('settings', 'core')->core_site_counter + 1;

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }


  //Get Custom header color values
  public function getcustomheadercolorsAction() {

    $customheader_id = $this->_getParam('customheader_id', 1);
    if(empty($customheader_id))
      return;
    $themecustom = Engine_Api::_()->getDbTable('customheaders','sesadvancedheader')->getHeaderKey(array('header_id'=>$customheader_id, 'is_custom' => 1));
    $customthecolorArray = array();
    foreach($themecustom as $value) {
      $customthecolorArray[] = $value['column_key'].'||'.$value['value'];
    }
    echo json_encode($customthecolorArray);die;
  }

  public function addCustomHeaderAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $customheader_id = $this->_getParam('customheader_id', 0);
    $this->view->form = $form = new Sesadvancedheader_Form_Admin_CustomHeader();
    if ($customheader_id) {
      $form->setTitle("Edit Custom Color Scheme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme = Engine_Api::_()->getItem('sesadvancedheader_headers', $customheader_id);
      $form->populate($customtheme->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('headers', 'sesadvancedheader')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('headers', 'sesadvancedheader');
        $values = $form->getValues();

        if(!$customheader_id)
          $customtheme = $table->createRow();
        $customtheme->setFromArray($values);
        $customtheme->save();
        $header_id = $customtheme->header_id;
        if(!empty($values['customthemeid'])) {
          $dbInsert = Engine_Db_Table::getDefaultAdapter();
           $db->query("INSERT IGNORE INTO engine4_sesadvancedheader_customheaders (column_key,is_custom,header_id,value) SELECT column_key,1,'".$header_id."',value FROM engine4_sesadvancedheader_customheaders WHERE header_id = '".$customheader_id."'");
        }
        $db->commit();
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesadvancedheader', 'controller' => 'settings', 'action' => 'styling', 'customheader_id' => $customtheme->header_id),'admin_default',true),
          'messages' => array('New Custom Color Scheme created successfully.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function deleteCustomHeaderAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->customheader_id = $customheader_id = $this->_getParam('customheader_id', 0);
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $getActivatedTheme = $settings->getSetting('sesadvancedheaderheader.color',1);
    $customActivatedTheme = $settings->getSetting('sesadvancedheadercustom.header.color',1);

    if($getActivatedTheme == 5) {
      if($customActivatedTheme == $customheader_id){
        // activated header
        $this->renderScript('admin-settings/activated-custom-header.tpl');
        return;
      }
    }

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $header = Engine_Api::_()->getItem('sesadvancedheader_header', $customheader_id);
        $header->delete();
        $db->commit();
        $activatedTheme = Engine_Api::_()->sesadvancedheader()->getContantValueXML('custom_header_color');
        $this->_forward('success', 'utility', 'core', array('parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesadvancedheader', 'controller' => 'settings', 'action' => 'styling', 'customheader_id' => $activatedTheme),'admin_default',true), 'messages' => array('You have successfully delete custom header.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    } else {
      // Output
      $this->renderScript('admin-settings/delete-custom-header.tpl');
    }
  }

  public function manageSearchAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvancedheader_admin_main', array(), 'sesadvancedheader_admin_main_menus');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sesadvancedheader')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_sesadvancedheader_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'sesadvancedheader')->getAllSearchOptions();
  }

  public function orderManageSearchAction() {

    if (!$this->getRequest()->isPost())
      return;

    $managesearchoptionsTable = Engine_Api::_()->getDbtable('managesearchoptions', 'sesadvancedheader');
    $managesearchoptions = $managesearchoptionsTable->fetchAll($managesearchoptionsTable->select());
    foreach ($managesearchoptions as $managesearchoption) {
      $order = $this->getRequest()->getParam('managesearch_' . $managesearchoption->managesearchoption_id);
      if (!$order)
        $order = 999;
      $managesearchoption->order = $order;
      $managesearchoption->save();
    }
    return;
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('managesearchoption_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesadvancedheader_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesadvancedheader/settings/manage-search');
  }

  public function deleteSearchIconAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id', 0);
    $this->view->file_id = $file_id = $this->_getParam('file_id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $mainMenuIcon = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id);
        $mainMenuIcon->delete();
        $db->update('engine4_sesadvancedheader_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
        ));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
    $this->renderScript('admin-settings/delete-search-icon.tpl');
  }

  public function editSearchAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id', null);

    $type = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $managesearchoptions = Engine_Api::_()->getItem('sesadvancedheader_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sesadvancedheader_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sesadvancedheader_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sesadvancedheader()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_sesadvancedheader_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesadvancedheader', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => $redirectUrl,
                  'messages' => '',
      ));
    }
  }
}
