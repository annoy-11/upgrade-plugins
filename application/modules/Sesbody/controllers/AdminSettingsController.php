<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbody_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbody_admin_main', array(), 'sesbody_admin_main_settings');

    $this->view->form = $form = new Sesbody_Form_Admin_Global();

    //Start Make extra file for sesbody theme custom css and sesbody constant
    $this->makeSpFile($form);
    //Start Make extra file for sesbody constant

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['layout_settings']);
      include_once APPLICATION_PATH . "/application/modules/Sesbody/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbody.pluginactivated')) {

        foreach ($values as $key => $value) {

          if ($key == 'sesbody_user_photo_round' || $key == 'sesbody_main_width' || $key == 'sesbody_left_columns_width' || $key == 'sesbody_right_columns_width' || $key == 'sesbody_body_background_image' || $key == 'sesbutton_effacts' || $key == 'sesbody_widget_background_image' || $key == "sesbody_header_design" || $key == "sesbody_footer_design") {
            Engine_Api::_()->sesbody()->readWriteXML($key, $value);
          }
            if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
                Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
            if (!$value && strlen($value) == 0)
                continue;
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }

        //Here we have set the value of theme active.
        if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbody.themeactive')) {

          Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbody.themeactive', 1);

          $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesbody', 'Responsive Body Theme', '', 0)");

          $themeName = 'sesbody';
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
              //Clear scaffold cache
              Core_Model_DbTable_Themes::clearScaffoldCache();
              //Increment site counter
              $settings = Engine_Api::_()->getApi('settings', 'core');
              $settings->core_site_counter = $settings->core_site_counter + 1;
              $db->commit();
            } catch (Exception $e) {
              $db->rollBack();
              throw $e;
            }
          }
        }

        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbody_admin_main', array(), 'sesbody_admin_main_typography');

    $this->view->form = $form = new Sesbody_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sesbody_body']);
      unset($values['sesbody_heading']);
      unset($values['sesbody_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbody.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sesbody_googlefonts']) {
            unset($values['sesbody_body_fontfamily']);
            unset($values['sesbody_heading_fontfamily']);
            unset($values['sesbody_tab_fontfamily']);

            unset($values['sesbody_body_fontsize']);
            unset($values['sesbody_heading_fontsize']);
            unset($values['sesbody_tab_fontsize']);

            if($values['sesbody_googlebody_fontfamily'])
              Engine_Api::_()->sesbody()->readWriteXML('sesbody_body_fontfamily', $values['sesbody_googlebody_fontfamily']);

            if($values['sesbody_googlebody_fontsize'])
              Engine_Api::_()->sesbody()->readWriteXML('sesbody_body_fontsize', $values['sesbody_googlebody_fontsize']);

            if($values['sesbody_googleheading_fontfamily'])
              Engine_Api::_()->sesbody()->readWriteXML('sesbody_heading_fontfamily', $values['sesbody_googleheading_fontfamily']);

            if($values['sesbody_googleheading_fontsize'])
              Engine_Api::_()->sesbody()->readWriteXML('sesbody_heading_fontsize', $values['sesbody_googleheading_fontsize']);

            if($values['sesbody_googletab_fontfamily'])
              Engine_Api::_()->sesbody()->readWriteXML('sesbody_tab_fontfamily', $values['sesbody_googletab_fontfamily']);

            if($values['sesbody_googletab_fontsize'])
              Engine_Api::_()->sesbody()->readWriteXML('sesbody_tab_fontsize', $values['sesbody_googletab_fontsize']);

            //Engine_Api::_()->sesbody()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sesbody_googlebody_fontfamily']);
            unset($values['sesbody_googleheading_fontfamily']);
            unset($values['sesbody_googleheading_fontfamily']);
            unset($values['sesbody_googletab_fontfamily']);

            unset($values['sesbody_googlebody_fontsize']);
            unset($values['sesbody_googleheading_fontsize']);
            unset($values['sesbody_googletab_fontsize']);

            Engine_Api::_()->sesbody()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbody_admin_main', array(), 'sesbody_admin_main_styling');

    $this->view->form = $form = new Sesbody_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']); unset($values['footer_settings']); unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {
        Engine_Api::_()->sesbody()->readWriteXML($key, $value, '');
        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($stringReplace == 'sesbody.mainmenu.background.color') {
          $stringReplace = 'sesbody.mainmenu.backgroundcolor';
          } elseif($stringReplace == 'sesbody.mainmenu.link.color') {
          $stringReplace = 'sesbody.mainmenu.linkcolor';
          } elseif($stringReplace == 'sesbody.minimenu.link.color') {
	            $stringReplace = 'sesbody.minimenu.linkcolor';
           } elseif($stringReplace == 'sesbody.font.color') {
	            $stringReplace = 'sesbody.fontcolor';
           } elseif($stringReplace == 'sesbody.link.color') {
	            $stringReplace = 'sesbody.linkcolor';
           } elseif($stringReplace == 'sesbody.content.border.color') {
	            $stringReplace = 'sesbody.content.bordercolor';
           } elseif($stringReplace == 'sesbody.button.background.color') {
	            $stringReplace = 'sesbody.button.backgroundcolor';
           } else {
          $stringReplace = str_replace('_', '.', $key);
          }
          $columnVal = $settingsTable->select()
									   ->from($settingsTableName, array('value'))
                    ->where('name = ?', $stringReplace)
                    ->query()
                    ->fetchColumn();
          if($columnVal) {
            if($stringReplace == 'sesbody.mainmenu.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesbody.mainmenu.backgroundcolor";');

            } elseif($stringReplace == 'sesbody.mainmenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesbody.mainmenu.linkcolor";');
           } elseif($stringReplace == 'sesbody.minimenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesbody.minimenu.linkcolor";');
           } elseif($stringReplace == 'sesbody.font.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesbody.fontcolor";');
           } elseif($stringReplace == 'sesbody.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesbody.linkcolor";');
           } elseif($stringReplace == 'sesbody.content.border.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesbody.content.bordercolor";');
           } elseif($stringReplace == 'sesbody.button.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesbody.button.backgroundcolor";');
           }
           else {
		          $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "'.$stringReplace.'";');
	          }
          } else {
            if($stringReplace == 'sesbody.mainmenu.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesbody.mainmenu.backgroundcolor", "'.$value.'");');
            } elseif($stringReplace == 'sesbody.mainmenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesbody.mainmenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesbody.minimenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesbody.minimenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesbody.font.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesbody.fontcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesbody.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesbody.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesbody.content.border.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesbody.content.bordercolor", "'.$value.'");');
           } elseif($stringReplace == 'sesbody.button.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesbody.button.backgroundcolor", "'.$value.'");');
           }
            else {
		          $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("'.$stringReplace.'", "'.$value.'");');
	          }

          }
        }

      }

      //Clear scaffold cache
      Core_Model_DbTable_Themes::clearScaffoldCache();
      //Increment site counter
      $settings->core_site_counter = Engine_Api::_()->getApi('settings', 'core')->core_site_counter + 1;

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function makeSpFile($form) {

    //Start Make extra file for sesbody theme custom css
    $themeDirName = APPLICATION_PATH . '/application/themes/sesbody';
    @chmod($themeDirName, 0777);
    if (!is_readable($themeDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
      $form->addError($itemError);
      return;
    }
    $fileName = $themeDirName . '/sesbody-custom.css';
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
    //Start Make extra file for sesbody theme custom css

    //Start Make extra file for sesbody constant
    $moduleDirName = APPLICATION_PATH . '/application/modules/Sesbody/externals/styles/';
    @chmod($moduleDirName, 0777);
    if (!is_readable($moduleDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $moduleDirName);
      $form->addError($itemError);
      return;
    }
    $fileNameXML = $moduleDirName . '/sesbody.xml';
    $fileexists = @file_exists($fileNameXML);
    if (empty($fileexists)) {
      @chmod($moduleDirName, 0777);
      if (!is_writable($moduleDirName)) {
        $itemError = Zend_Registry::get('Zend_Translate')->_("You have not writable permission on below file path. So, please give chmod 777 recursive permission to continue this process. <br /> Path Name: $moduleDirName");
        $form->addError($itemError);
        return;
      }
      $fh = @fopen($fileNameXML, 'w');
      @fwrite($fh, '<?xml version="1.0" encoding="UTF-8"?><root></root>');
      @chmod($fileNameXML, 0777);
      @fclose($fh);
      @chmod($fileNameXML, 0777);
      @chmod($fileNameXML, 0777);
    }
    //Start Make extra file for sesbody constant
  }
}
