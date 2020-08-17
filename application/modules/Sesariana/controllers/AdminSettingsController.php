<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesariana_admin_main', array(), 'sesariana_admin_main_settings');

    $this->view->form = $form = new Sesariana_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesariana/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.pluginactivated')) {
        //Landing Page Work
				if (!empty($values['sesariana_layout_enable'])) {
          $this->landingpagesetup();
				}
				//Landing Page Work

				//Here we have set the value of theme active.
				$themeactive = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.themeactive');
				if (empty($themeactive)) {

					$db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesariana', 'Ariana', '', 0)");
          $themeName = 'sesariana';
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
					Engine_Api::_()->getApi('settings', 'core')->setSetting('sesariana.themeactive', 1);
				}

				//Start Make extra file for ariana theme custom css
        $themeDirName = APPLICATION_PATH . '/application/themes/sesariana';
        @chmod($themeDirName, 0777);
        if (!is_readable($themeDirName)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
          $form->addError($itemError);
          return;
        }
        $fileName = $themeDirName . '/sesariana-custom.css';
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
        //Start Make extra file for ariana theme custom css

				foreach ($values as $key => $value) {
				 if ($key == 'sesariana_responsive_layout' || $key == 'sesariana_body_background_image' || $key == 'sesariana_left_columns_width' || $key == 'sesariana_right_columns_width' || $key == 'sesariana_feed_style' || $key == 'sesariana_user_photo_round') {
					 	if($key ==  'sesariana_body_background_image') {
							if($value == '0') {
								$value = 'public/admin/blank.png';
              }
						}
           Engine_Api::_()->sesariana()->readWriteXML($key, $value);
          }
          if($key ==  'sesariana_loginsignupbgimage') {
            if($value == '0')
              $value = 'public/admin/blank.png';
          }
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

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesariana_admin_main', array(), 'sesariana_admin_main_support');

    }
  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesariana_admin_main', array(), 'sesariana_admin_main_styling');

    $this->view->customtheme_id = $this->_getParam('customtheme_id', null);

    $this->view->form = $form = new Sesariana_Form_Admin_Styling();

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
          Engine_Api::_()->sesariana()->readWriteXML($key, $value, '');
        }

        if ((isset($_POST['submit']) || isset($_POST['save'])) && $values['custom_theme_color'] > '13') {
          if ($values['custom_theme_color'] > '13') {
            $description = serialize($values);
            $db->query("UPDATE `engine4_sesariana_customthemes` SET `description` = '".$description."' WHERE `engine4_sesariana_customthemes`.`customtheme_id` = '".$values['custom_theme_color']."'");
          }
        }

        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($key == 'sesariana_button_background_color') {
            $stringReplace = 'sesariana.button.backgroundcolor';
          }
          if($key == 'sesariana_font_color') {
            $stringReplace = 'sesariana.fontcolor';
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
        $this->_helper->redirector->gotoRoute(array('module' => 'sesariana', 'controller' => 'settings', 'action' => 'styling'),'admin_default',true);
      } else if($values['theme_color'] == 5 && $values['custom_theme_color'] > 13) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sesariana', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $values['custom_theme_color']),'admin_default',true);
      }
    }
    $this->view->activatedTheme = Engine_Api::_()->sesariana()->getContantValueXML('custom_theme_color');
  }

  //Get Custom theme color values
  public function getcustomthemecolorsAction() {

    $customtheme_id = $this->_getParam('customtheme_id', 22);
    if(empty($customtheme_id))
      return;
    $customthemeItem = Engine_Api::_()->getItem('sesariana_customthemes', $customtheme_id);
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
    $this->view->form = $form = new Sesariana_Form_Admin_CustomTheme();
    if ($customtheme_id) {
      $form->setTitle("Edit Custom Theme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme = Engine_Api::_()->getItem('sesariana_customthemes', $customtheme_id);
      $form->populate($customtheme->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('customthemes', 'sesariana')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('customthemes', 'sesariana');
        $values = $form->getValues();

        if(!$customtheme_id)
          $customtheme = $table->createRow();
        $customtheme->setFromArray($values);
        $customtheme->save();

        if(!empty($values['customthemeid'])) {
          $customthemeItem = Engine_Api::_()->getItem('sesariana_customthemes', $values['customthemeid']);
          $description = unserialize($customthemeItem->description);
          $finalDescription = serialize(array_merge($description, array('custom_theme_color' => $customtheme->customtheme_id)));
          $customtheme->description = $finalDescription;
          $customtheme->save();
        }
        $db->commit();
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesariana', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $customtheme->customtheme_id),'admin_default',true),
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
        $slideImage = Engine_Api::_()->getItem('sesariana_customthemes', $customtheme_id);
        $slideImage->delete();
        $db->commit();
        $activatedTheme = Engine_Api::_()->sesariana()->getContantValueXML('custom_theme_color');
        $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesariana', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $activatedTheme),'admin_default',true),
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

  public function landingpagesetup() {

    $db = Engine_Db_Table::getDefaultAdapter();

    //Landing Page
    $LandingPageOrder = 1;
    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3  AND `engine4_core_content`.`name` !='main' AND `engine4_core_content`.`name` !='middle' AND `engine4_core_content`.`type`='container';");

    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3;");
    $page_id = 3;
    // Insert top
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => $LandingPageOrder++,
    ));
    $top_id = $db->lastInsertId();
    // Insert main
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => $LandingPageOrder++,
    ));
    $main_id = $db->lastInsertId();
    // Insert top-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => $LandingPageOrder++,
    ));
    $top_middle_id = $db->lastInsertId();
    // Insert main-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => $LandingPageOrder++,
    ));
    $main_middle_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesariana.home-slider',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $top_middle_id,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesariana.features',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesariana.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesariana_highlight_module":"sesevent_event","popularitycriteria":"view_count","contentbackgroundcolor":"4682B4","sesariana_highlight_design":"1","widgetdescription":"","title":"Popular Events Near You","nomobile":"0","name":"sesariana.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesariana.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesariana_highlight_module":"sesalbum_album","popularitycriteria":"view_count","contentbackgroundcolor":"4682B4","sesariana_highlight_design":"2","widgetdescription":"","title":"Poplular Albums In Our Community","nomobile":"0","name":"sesariana.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesariana.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesariana_highlight_module":"sesblog_blog","popularitycriteria":"view_count","contentbackgroundcolor":"5D94C5","sesariana_highlight_design":"3","widgetdescription":"","title":"Popular Posts - Heads up bloggers!","nomobile":"0","name":"sesariana.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbasic.simple-html-block',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"bodysimple":"<div class=\"sesariana_text_block_wrapper sesbasic_bxs sesbasic_clearfix\">\r\n\t<div class=\"sesariana_text_block\">\r\n  \t<h2 class=\"sesariana_text_block_maintxt\">Check Out What\'s Inside Our Awesome Community<\/h2>\r\n    <div class=\"sesariana_text_block_buttons sesbasic_clearfix\">\r\n    \t<a href=\"\/blogs\/home\" class=\"sesbasic_link_btn sesbasic_animation\">Explore Popular Blogs<\/a>\r\n      <a href=\"\/events\/locations\" class=\"sesbasic_link_btn sesbasic_animation\">Find Nearby Events<\/a>\r\n      <a href=\"\/team\" class=\"sesbasic_link_btn\">Meet Our team<\/a>\r\n    <\/div>\r\n\t\t<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 6px;width: 1200px; margin-left: 50px;\">\r\n\t\t<\/div>\r\n\t\t<div style=\"font-size: 15px;margin-bottom: 10px;  margin-top: 25px;text-align: center;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet consectetur lobortis!<\/div>\r\n  <\/div>\r\n<\/div>","en_US_bodysimple":"<div class=\"sesariana_text_block_wrapper sesbasic_bxs sesbasic_clearfix\">\r\n\t<div class=\"sesariana_text_block\">\r\n  \t<h2 class=\"sesariana_text_block_maintxt\">Check Out What\'s Inside Our Awesome Community<\/h2>\r\n    <div class=\"sesariana_text_block_buttons sesbasic_clearfix\">\r\n    \t<a href=\"\/blogs\/home\" class=\"sesbasic_link_btn sesbasic_animation\">Explore Popular Blogs<\/a>\r\n      <a href=\"\/events\/locations\" class=\"sesbasic_link_btn sesbasic_animation\">Find Nearby Events<\/a>\r\n      <a href=\"\/team\" class=\"sesbasic_link_btn\">Meet Our team<\/a>\r\n    <\/div>\r\n\t\t<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 6px;width: 1200px; margin-left: 50px;\">\r\n\t\t<\/div>\r\n\t\t<div style=\"font-size: 15px;margin-bottom: 10px;  margin-top: 25px;text-align: center;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet consectetur lobortis!<\/div>\r\n  <\/div>\r\n<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesariana.member-cloud',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"heading":"1","showTitle":"1","memberCount":"","height":"","width":"","title":"","nomobile":"0","name":"sesariana.member-cloud"}',
    ));
  }

  //Upload Home Banner images
	public function uploadHomeBanner(){

		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$slideData = array('slide_1', 'slide_2', 'slide_3');
		foreach($slideData as $data) {
      $data1 = explode('_', $data);
      $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesariana' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "homebanner" . DIRECTORY_SEPARATOR;
      if (is_file($PathFile . $data . '.jpg')) {
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $filename = $storage->createFile($PathFile . $data.'.jpg', array(
            'parent_id' => $data1[1],
            'parent_type' => 'sesariana_slide',
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        $file_id = $filename->file_id;
        $db->query("UPDATE `engine4_sesariana_slides` SET `file_id` = '" . $file_id . "' WHERE slide_id = " . $data1[1]);
      }
		}
	}


  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesariana_admin_main', array(), 'sesariana_admin_main_typography');

    $this->view->form = $form = new Sesariana_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sesariana_body']);
      unset($values['sesariana_heading']);
      unset($values['sesariana_mainmenu']);
      unset($values['sesariana_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sesariana_googlefonts']) {
            unset($values['sesariana_body_fontfamily']);
            unset($values['sesariana_heading_fontfamily']);
            unset($values['sesariana_mainmenu_fontfamily']);
            unset($values['sesariana_tab_fontfamily']);

            unset($values['sesariana_body_fontsize']);
            unset($values['sesariana_heading_fontsize']);
            unset($values['sesariana_mainmenu_fontsize']);
            unset($values['sesariana_tab_fontsize']);

            if($values['sesariana_googlebody_fontfamily'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_body_fontfamily', $values['sesariana_googlebody_fontfamily']);

            if($values['sesariana_googlebody_fontsize'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_body_fontsize', $values['sesariana_googlebody_fontsize']);

            if($values['sesariana_googleheading_fontfamily'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_heading_fontfamily', $values['sesariana_googleheading_fontfamily']);

            if($values['sesariana_googleheading_fontsize'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_heading_fontsize', $values['sesariana_googleheading_fontsize']);

            if($values['sesariana_googlemainmenu_fontfamily'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_mainmenu_fontfamily', $values['sesariana_googlemainmenu_fontfamily']);

            if($values['sesariana_googlemainmenu_fontsize'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_mainmenu_fontsize', $values['sesariana_googlemainmenu_fontsize']);

            if($values['sesariana_googletab_fontfamily'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_tab_fontfamily', $values['sesariana_googletab_fontfamily']);

            if($values['sesariana_googletab_fontsize'])
              Engine_Api::_()->sesariana()->readWriteXML('sesariana_tab_fontsize', $values['sesariana_googletab_fontsize']);

            //Engine_Api::_()->sesariana()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sesariana_googlebody_fontfamily']);
            unset($values['sesariana_googleheading_fontfamily']);
            unset($values['sesariana_googleheading_fontfamily']);
            unset($values['sesariana_googletab_fontfamily']);

            unset($values['sesariana_googlebody_fontsize']);
            unset($values['sesariana_googleheading_fontsize']);
            unset($values['sesariana_googlemainmenu_fontsize']);
            unset($values['sesariana_googletab_fontsize']);

            Engine_Api::_()->sesariana()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
