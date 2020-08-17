<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbstyle_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfbstyle_admin_main', array(), 'sesfbstyle_admin_main_settings');

    $this->view->form = $form = new Sesfbstyle_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesfbstyle/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfbstyle.pluginactivated')) {

        if (@$values['sesfbstyle_changelanding']) {
          $this->landingpageSet();
        }

        //Here we have set the value of theme active.
        $themeactive = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfbstyle.themeactive');
        if (empty($themeactive)) {

            $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesfbstyle', 'Professional FB Clone', '', 0)");
            $themeName = 'sesfbstyle';
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
            Engine_Api::_()->getApi('settings', 'core')->setSetting('sesfbstyle.themeactive', 1);
        }

		//Start Make extra file for ariana theme custom css
        $themeDirName = APPLICATION_PATH . '/application/themes/sesfbstyle';
        @chmod($themeDirName, 0777);
        if (!is_readable($themeDirName)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
          $form->addError($itemError);
          return;
        }
        $fileName = $themeDirName . '/sesfbstyle-custom.css';
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

  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfbstyle_admin_main', array(), 'sesfbstyle_admin_main_styling');

    $this->view->customtheme_id = $this->_getParam('customtheme_id', null);

    $this->view->form = $form = new Sesfbstyle_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']);
      unset($values['footer_settings']);
      unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {

        if (isset($_POST['save'])) {
          Engine_Api::_()->sesfbstyle()->readWriteXML($key, $value, '');
        }

        if ((isset($_POST['submit']) || isset($_POST['save'])) && $values['custom_theme_color'] > '3') {
          if ($values['custom_theme_color'] > '3') {
            $description = serialize($values);
            $db->query("UPDATE `engine4_sesfbstyle_customthemes` SET `description` = '".$description."' WHERE `engine4_sesfbstyle_customthemes`.`customtheme_id` = '".$values['custom_theme_color']."'");
          }
        }

        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($key == 'sesfbstyle_button_background_color') {
            $stringReplace = 'sesfbstyle.button.backgroundcolor';
          }
          if($key == 'sesfbstyle_font_color') {
            $stringReplace = 'sesfbstyle.fontcolor';
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
      $settings->core_site_counter = Engine_Api::_()->getApi('settings', 'core')->core_site_counter + 1;

      $form->addNotice('Your changes have been saved.');

      if($values['theme_color'] != 5 || $values['custom_theme_color'] < 3) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sesfbstyle', 'controller' => 'settings', 'action' => 'styling'),'admin_default',true);
      } else if($values['theme_color'] == 5 && $values['custom_theme_color'] > 3) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sesfbstyle', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $values['custom_theme_color']),'admin_default',true);
      }
    }
    $this->view->activatedTheme = Engine_Api::_()->sesfbstyle()->getContantValueXML('custom_theme_color');
  }

  //Get Custom theme color values
  public function getcustomthemecolorsAction() {

    $customtheme_id = $this->_getParam('customtheme_id', 22);
    if(empty($customtheme_id))
      return;
    $customthemeItem = Engine_Api::_()->getItem('sesfbstyle_customthemes', $customtheme_id);
    $customthecolorvalue = unserialize($customthemeItem->description);
    $customthecolorArray = array();
    foreach($customthecolorvalue as $key =>  $customthecolorvalues) {
      $customthecolorArray[] = $key.'||'.$customthecolorvalues;
    }
    echo json_encode($customthecolorArray);die;
  }

  public function addCustomThemeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $customtheme_id = $this->_getParam('customtheme_id', 0);
    $this->view->form = $form = new Sesfbstyle_Form_Admin_CustomTheme();
    if ($customtheme_id) {
      $form->setTitle("Edit Custom Theme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme = Engine_Api::_()->getItem('sesfbstyle_customthemes', $customtheme_id);
      $form->populate($customtheme->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('customthemes', 'sesfbstyle')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('customthemes', 'sesfbstyle');
        $values = $form->getValues();

        if(!$customtheme_id)
          $customtheme = $table->createRow();
        $customtheme->setFromArray($values);
        $customtheme->save();

        if(!empty($values['customthemeid'])) {
          $customthemeItem = Engine_Api::_()->getItem('sesfbstyle_customthemes', $values['customthemeid']);
          $description = unserialize($customthemeItem->description);
          $finalDescription = serialize(array_merge($description, array('custom_theme_color' => $customtheme->customtheme_id)));
          $customtheme->description = $finalDescription;
          $customtheme->save();
        }
        $db->commit();
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesfbstyle', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $customtheme->customtheme_id),'admin_default',true),
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
        $slideImage = Engine_Api::_()->getItem('sesfbstyle_customthemes', $customtheme_id);
        $slideImage->delete();
        $db->commit();
        $activatedTheme = Engine_Api::_()->sesfbstyle()->getContantValueXML('custom_theme_color');
        $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesfbstyle', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $activatedTheme),'admin_default',true),
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
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "990010" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "990010" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index_1" WHERE `engine4_core_pages`.`name` = "core_index_index";');
    }

    //New Landing Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesfbstyle_index_sesbackuplandingppage')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {

      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'sesfbstyle_index_sesbackuplandingppage',
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
          'name' => 'sesfbstyle.landing-page',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
      ));

      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesfbstyle_index_sesbackuplandingppage')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "sesfbstyle_index_sesbackuplandingppage";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sesfbstyle_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Professional FB Clone - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sesfbstyle_index_sesbackuplandingppage";');
      }
    }
  }

  public function uploadDashboardIcons() {

    $paginator = Engine_Api::_()->getDbTable('dashboardlinks', 'sesfbstyle')->getInfo(array('sublink' => 1, 'enabled' => 1));
    foreach($paginator as $dashboardlinks) {

      $dashIcons = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesfbstyle' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . $dashboardlinks->name.'.png';

      if (file_exists($dashIcons)) {

        $file_ext = pathinfo($dashIcons);
        $file_ext = $file_ext['extension'];
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $storageObject = $storage->createFile($dashIcons, array(
          'parent_id' => $dashboardlinks->getIdentity(),
          'parent_type' => $dashboardlinks->getType(),
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));

        // Remove temporary file
        @unlink($file['tmp_name']);
        $dashboardlinks->file_id = $storageObject->file_id;
        $dashboardlinks->save();
      }
    }
  }
}
