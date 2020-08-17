<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_admin_main', array(), 'sestwitterclone_admin_main_settings');

    $this->view->form = $form = new Sestwitterclone_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sestwitterclone/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sestwitterclone.pluginactivated')) {

        if (@$values['sestwitterclone_changelanding']) {
          $this->landingpageSet();
        }
        if($values['sestwitterclone_header_fixed_layout'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_header_fixed_layout', $values['sestwitterclone_header_fixed_layout']);

        //Here we have set the value of theme active.
        $themeactive = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestwitterclone.themeactive');
        if (empty($themeactive)) {

            $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sestwitterclone', 'Professional Twitter Clone', '', 0)");
            $themeName = 'sestwitterclone';
            $themeTable = Engine_Api::_()->getDbtable('themes', 'core');
            $themeSelect = $themeTable->select()
                            ->orWhere('theme_id = ?', $themeName)
                            ->orWhere('name = ?', $themeName)
                            ->limit(1);
            $theme = $themeTable->fetchRow($themeSelect);
            if ($theme) {
                $db = $themeTable->getAdapter();
                $db->beginTransaction();
                try {
                    $themeTable->update(array('active' => 0), array('1 = ?' => 1));
                    $theme->active = true;
                    $theme->save();
                    // clear scaffold cache
                    Core_Model_DbTable_Themes::clearScaffoldCache();
                    // Increment site counter
                    $settings = Engine_Api::_()->getApi('settings', 'core');
                    $settings->core_site_counter = $settings->core_site_counter + 1;
                    $db->commit();
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
            }
            Engine_Api::_()->getApi('settings', 'core')->setSetting('sestwitterclone.themeactive', 1);
        }

		//Start Make extra file for ariana theme custom css
        $themeDirName = APPLICATION_PATH . '/application/themes/sestwitterclone';
        @chmod($themeDirName, 0777);
        if (!is_readable($themeDirName)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
          $form->addError($itemError);
          return;
        }
        $fileName = $themeDirName . '/sestwitterclone-custom.css';
        $fileexists = @file_exists($fileName);
        if (empty($fileexists)) {
          @chmod($themeDirName, 0777);
          if (!is_writable($themeDirName)) {
            $itemError = Zend_Registry::get('Zend_Translate')->_("You have not writable permission on below file path. So, please give chmod 777 recursive permission to continue this process. <br /> Path Name: $themeDirName");
            $form->addError($itemError);
            return;
          }
          $fh = @fopen($fileName, 'w');
          @fwrite($fh, '/* ADD YOUR CUSTOM CSS HERE */');
          @chmod($fileName, 0777);
          @fclose($fh);
          @chmod($fileName, 0777);
          @chmod($fileName, 0777);
        }
        //Start Make extra file for ariana theme custom css die;
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

  public function supportAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_admin_main', array(), 'sestwitterclone_admin_main_support');

  }
  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_admin_main', array(), 'sestwitterclone_admin_main_styling');

    $this->view->customtheme_id = $this->_getParam('customtheme_id', null);

    $this->view->form = $form = new Sestwitterclone_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']);
      unset($values['footer_settings']);
      unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {

//         if($value == '')
//             continue;
        if (isset($_POST['save'])) {
          Engine_Api::_()->sestwitterclone()->readWriteXML($key, $value, '');
        }

//         if ((isset($_POST['submit']) || isset($_POST['save'])) && $values['custom_theme_color'] > '13') {
//           if ($values['custom_theme_color'] > '13') {
//
//             //$db->query("INSERT INTO `engine4_sestwitterclone_customthemes` (`name`, `value`, `column_key`,`default`,`theme_id`) VALUES ('Theme - 12', '".$value."','".$key."','0','13') ON DUPLICATE KEY UPDATE `value`='".$value."';");
//             $theme_id = $values['custom_theme_color'];
//             $dbInsert = Engine_Db_Table::getDefaultAdapter();
//             foreach($values as $key => $value) {
//                $dbInsert->query("UPDATE `engine4_sestwitterclone_customthemes` SET `value` = '".$value."' WHERE `engine4_sestwitterclone_customthemes`.`theme_id` = '".$theme_id."' AND  `engine4_sestwitterclone_customthemes`.`column_key` = '".$key."';");
//                //echo "UPDATE `engine4_sestwitterclone_customthemes` SET `value` = '".$value."' WHERE `engine4_sestwitterclone_customthemes`.`theme_id` = '".$theme_id."' AND  `engine4_sestwitterclone_customthemes`.`column_key` = '".$key."';";
//             }
//             //$description = serialize($values);
//             //$db->query("UPDATE `engine4_sestwitterclone_customthemes` SET `description` = '".$description."' WHERE `engine4_sestwitterclone_customthemes`.`customtheme_id` = '".$values['custom_theme_color']."'");
//           }
//         }

        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($key == 'sestwitterclone_button_background_color') {
            $stringReplace = 'sestwitterclone.button.backgroundcolor';
          }
          if($key == 'sestwitterclone_font_color') {
            $stringReplace = 'sestwitterclone.fontcolor';
          }

          $columnVal = $settingsTable->select()
                                    ->from($settingsTableName, array('value'))
                                    ->where('name = ?', $stringReplace)
                                    ->query()
                                    ->fetchColumn();
          if($columnVal) {
            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "'.$stringReplace.'";');
          } else {
            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("'.$stringReplace.'", "'.$value.'");');
          }
        }
      }


      //Clear scaffold cache
      Core_Model_DbTable_Themes::clearScaffoldCache();
      //Increment site counter
      Engine_Api::_()->getApi('settings', 'core')->core_site_counter = Engine_Api::_()->getApi('settings', 'core')->core_site_counter + 1;

      $form->addNotice('Your changes have been saved.');

      if($values['theme_color'] != 5 || $values['custom_theme_color'] < 13) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sestwitterclone', 'controller' => 'settings', 'action' => 'styling'),'admin_default',true);
      } else if($values['theme_color'] == 5 && $values['custom_theme_color'] > 13) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sestwitterclone', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $values['custom_theme_color']),'admin_default',true);
      }
    }
    $this->view->activatedTheme = Engine_Api::_()->sestwitterclone()->getContantValueXML('custom_theme_color');
  }

  //Get Custom theme color values
  public function getcustomthemecolorsAction() {

    $customtheme_id = $this->_getParam('customtheme_id', 22);
    if(empty($customtheme_id))
      return;

    $themecustom = Engine_Api::_()->getDbTable('customthemes','sestwitterclone')->getThemeKey(array('theme_id'=>$customtheme_id,'default'=>1));
    $customthecolorArray = array();
    foreach($themecustom as $value) {

      $customthecolorArray[] = $value['column_key'].'||'.$value['value'];
    }
    echo json_encode($customthecolorArray);die;
  }

  public function addCustomThemeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $customtheme_id = $this->_getParam('customtheme_id', 0);
    $this->view->form = $form = new Sestwitterclone_Form_Admin_CustomTheme();
    if ($customtheme_id) {
      $form->setTitle("Edit Custom Theme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme = Engine_Api::_()->getItem('sestwitterclone_customthemes', $customtheme_id);
      $form->populate($customtheme->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('customthemes', 'sestwitterclone')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('customthemes', 'sestwitterclone');
        $values = $form->getValues();

        if(!$customtheme_id) {
            $customtheme = $table->createRow();
            $customtheme->setFromArray($values);
            $customtheme->save();

            $theme_id = $customtheme->customtheme_id;

            if(!empty($values['customthemeid'])) {

                $dbInsert = Engine_Db_Table::getDefaultAdapter();

                $getThemeValues = Engine_Api::_()->getDbTable('customthemes', 'sestwitterclone')->getThemeValues(array('customtheme_id' => $values['customthemeid']));
                foreach($getThemeValues as $key => $value) {
                    $dbInsert->query("INSERT INTO `engine4_sestwitterclone_customthemes` (`name`, `value`, `column_key`,`default`,`theme_id`) VALUES ('".$values['name']."','".$value->value."','".$value->column_key."','1','".$theme_id."') ON DUPLICATE KEY UPDATE `value`='".$value->value."';");
                }
                $db->query("UPDATE `engine4_sestwitterclone_customthemes` SET `value` = '" . $theme_id . "' WHERE theme_id = " . $theme_id . " AND column_key = 'custom_theme_color';");
                $db->query('DELETE FROM `engine4_sestwitterclone_customthemes` WHERE `engine4_sestwitterclone_customthemes`.`theme_id` = "0";');
            }
        } else if(!empty($customtheme_id)) {
            $db->query("UPDATE `engine4_sestwitterclone_customthemes` SET `name` = '" . $values['name'] . "' WHERE theme_id = " . $customtheme_id);
        }
        $db->commit();
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sestwitterclone', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $customtheme->customtheme_id),'admin_default',true),
          'messages' => array('New Custom theme created successfully.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

    }

  }

  public function deleteCustomThemeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->customtheme_id = $customtheme_id = $this->_getParam('customtheme_id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $dbQuery = Zend_Db_Table_Abstract::getDefaultAdapter();
        $dbQuery->query("DELETE FROM engine4_sestwitterclone_customthemes WHERE theme_id = ".$customtheme_id);
        $db->commit();
        $activatedTheme = Engine_Api::_()->sestwitterclone()->getContantValueXML('custom_theme_color');
        $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sestwitterclone', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $activatedTheme),'admin_default',true),
            'messages' => array('You have successfully delete custom theme.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

    } else {
      // Output
      $this->renderScript('admin-settings/delete-custom-theme.tpl');
    }
  }

  public function widgetCheck($params = array()) {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    return $db->select()
              ->from('engine4_core_content', 'content_id')
              ->where('type = ?', 'widget')
              ->where('page_id = ?', $params['page_id'])
              ->where('name = ?', $params['widget_name'])
              ->limit(1)
              ->query()
              ->fetchColumn();
  }

  public function landingpageSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    //Set Landing page as Landing Page and backup of Old Landing Page
    $orlanpage_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'core_index_index')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($orlanpage_id) {
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "999010" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "999010" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index_1" WHERE `engine4_core_pages`.`name` = "core_index_index";');
    }

    //New Landing Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sestwitterclone_index_sesbackuplandingppage')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {

      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'sestwitterclone_index_sesbackuplandingppage',
          'displayname' => 'Landing Page',
          'title' => 'Landing Page',
          'description' => 'This is your site\'s landing page.',
          'custom' => 0,
      ));
      $newpagelastId = $pageId = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'main',
          'page_id' => $pageId,
          'order' => 2,
      ));
      $mainId = $db->lastInsertId();

      // Insert main-middle
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $pageId,
          'parent_content_id' => $mainId,
          'order' => 2,
      ));
      $mainMiddleId = $db->lastInsertId();

      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sestwitterclone.landing-page',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"socialloginbutton":"1","title":"","nomobile":"0","name":"sestwitterclone.landing-page"}',
      ));

      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sestwitterclone_index_sesbackuplandingppage')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "sestwitterclone_index_sesbackuplandingppage";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sestwitterclone_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Professional Twitter Clone - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sestwitterclone_index_sesbackuplandingppage";');
      }
    }
  }

   public function manageSearchAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_admin_main', array(), 'sestwitterclone_admin_main_search');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sestwitterclone')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_sestwitterclone_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'sestwitterclone')->getAllSearchOptions();
  }

   public function enabledAction() {

    $id = $this->_getParam('managesearchoption_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sestwitterclone_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sestwitterclone/settings/manage-search');
  }

    public function editSearchAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id', null);

    $type = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $managesearchoptions = Engine_Api::_()->getItem('sestwitterclone_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sestwitterclone_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sestwitterclone_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sestwitterclone()->setPhotoIcons($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_sestwitterclone_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sestwitterclone', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => $redirectUrl,
                  'messages' => '',
      ));
    }
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
        $db->update('engine4_sestwitterclone_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
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

  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_admin_main', array(), 'sestwitterclone_admin_main_typography');

    $this->view->form = $form = new Sestwitterclone_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sestwitterclone_body']);
      unset($values['sestwitterclone_heading']);
      unset($values['sestwitterclone_mainmenu']);
      unset($values['sestwitterclone_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sestwitterclone.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sestwitterclone_googlefonts']) {
            unset($values['sestwitterclone_body_fontfamily']);
            unset($values['sestwitterclone_heading_fontfamily']);
            unset($values['sestwitterclone_mainmenu_fontfamily']);
            unset($values['sestwitterclone_tab_fontfamily']);

            unset($values['sestwitterclone_body_fontsize']);
            unset($values['sestwitterclone_heading_fontsize']);
            unset($values['sestwitterclone_mainmenu_fontsize']);
            unset($values['sestwitterclone_tab_fontsize']);

            if($values['sestwitterclone_googlebody_fontfamily'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_body_fontfamily', $values['sestwitterclone_googlebody_fontfamily']);

            if($values['sestwitterclone_googlebody_fontsize'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_body_fontsize', $values['sestwitterclone_googlebody_fontsize']);

            if($values['sestwitterclone_googleheading_fontfamily'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_heading_fontfamily', $values['sestwitterclone_googleheading_fontfamily']);

            if($values['sestwitterclone_googleheading_fontsize'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_heading_fontsize', $values['sestwitterclone_googleheading_fontsize']);

            if($values['sestwitterclone_googlemainmenu_fontfamily'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_mainmenu_fontfamily', $values['sestwitterclone_googlemainmenu_fontfamily']);

            if($values['sestwitterclone_googlemainmenu_fontsize'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_mainmenu_fontsize', $values['sestwitterclone_googlemainmenu_fontsize']);

            if($values['sestwitterclone_googletab_fontfamily'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_tab_fontfamily', $values['sestwitterclone_googletab_fontfamily']);

            if($values['sestwitterclone_googletab_fontsize'])
              Engine_Api::_()->sestwitterclone()->readWriteXML('sestwitterclone_tab_fontsize', $values['sestwitterclone_googletab_fontsize']);

            //Engine_Api::_()->sestwitterclone()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sestwitterclone_googlebody_fontfamily']);
            unset($values['sestwitterclone_googleheading_fontfamily']);
            unset($values['sestwitterclone_googleheading_fontfamily']);
            unset($values['sestwitterclone_googletab_fontfamily']);

            unset($values['sestwitterclone_googlebody_fontsize']);
            unset($values['sestwitterclone_googleheading_fontsize']);
            unset($values['sestwitterclone_googlemainmenu_fontsize']);
            unset($values['sestwitterclone_googletab_fontsize']);

            Engine_Api::_()->sestwitterclone()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
