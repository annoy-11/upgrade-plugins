<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesytube_admin_main', array(), 'sesytube_admin_main_settings');

    $this->view->form = $form = new Sesytube_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesytube/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.pluginactivated')) {
        //Landing Page Work
				if (!empty($values['sesytube_layout_enable'])) {
                    $this->landingpagesetup();
				}
				//Landing Page Work
                if (@$values['sesytube_changememberhomepage']) {
                    $this->memberhomepageSet();
                }

				//Here we have set the value of theme active.
				$themeactive = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.themeactive');
				if (empty($themeactive)) {

					$db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesytube', 'YouTube', '', 0)");
                    $themeName = 'sesytube';
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
					Engine_Api::_()->getApi('settings', 'core')->setSetting('sesytube.themeactive', 1);
				}

				//Start Make extra file for ytube theme custom css
        $themeDirName = APPLICATION_PATH . '/application/themes/sesytube';
        @chmod($themeDirName, 0777);
        if (!is_readable($themeDirName)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
          $form->addError($itemError);
          return;
        }
        $fileName = $themeDirName . '/sesytube-custom.css';
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
        //Start Make extra file for ytube theme custom css

				foreach ($values as $key => $value) {
				 if ($key == 'sesytube_body_background_image' || $key == 'sesytube_left_columns_width' || $key == 'sesytube_right_columns_width' || $key == 'sesytube_feed_style' || $key == 'sesytube_user_photo_round') {
					 	if($key ==  'sesytube_body_background_image') {
							if($value == '0') {
								$value = 'public/admin/blank.png';
              }
						}
           Engine_Api::_()->sesytube()->readWriteXML($key, $value);
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

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesytube_admin_main', array(), 'sesytube_admin_main_support');

    }
  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesytube_admin_main', array(), 'sesytube_admin_main_styling');

    $this->view->customtheme_id = $this->_getParam('customtheme_id', null);

    $this->view->form = $form = new Sesytube_Form_Admin_Styling();

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
          Engine_Api::_()->sesytube()->readWriteXML($key, $value, '');
        }

        if ((isset($_POST['submit']) || isset($_POST['save'])) && $values['custom_theme_color'] > '13') {
          if ($values['custom_theme_color'] > '13') {
            $description = serialize($values);
            $db->query("UPDATE `engine4_sesytube_customthemes` SET `description` = '".$description."' WHERE `engine4_sesytube_customthemes`.`customtheme_id` = '".$values['custom_theme_color']."'");
          }
        }

        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($key == 'sesytube_button_background_color') {
            $stringReplace = 'sesytube.button.backgroundcolor';
          }
          if($key == 'sesytube_content_background_color') {
            $stringReplace = 'sesytube.content.backgroundcolor';
          }
          if($key == 'sesytube_font_color') {
            $stringReplace = 'sesytube.fontcolor';
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
        $this->_helper->redirector->gotoRoute(array('module' => 'sesytube', 'controller' => 'settings', 'action' => 'styling'),'admin_default',true);
      } else if($values['theme_color'] == 5 && $values['custom_theme_color'] > 13) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sesytube', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $values['custom_theme_color']),'admin_default',true);
      }
    }
    $this->view->activatedTheme = Engine_Api::_()->sesytube()->getContantValueXML('custom_theme_color');
  }

  //Get Custom theme color values
  public function getcustomthemecolorsAction() {

    $customtheme_id = $this->_getParam('customtheme_id', 22);
    if(empty($customtheme_id))
      return;
    $customthemeItem = Engine_Api::_()->getItem('sesytube_customthemes', $customtheme_id);
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
    $this->view->form = $form = new Sesytube_Form_Admin_CustomTheme();
    if ($customtheme_id) {
      $form->setTitle("Edit Custom Theme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme = Engine_Api::_()->getItem('sesytube_customthemes', $customtheme_id);
      $form->populate($customtheme->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('customthemes', 'sesytube')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('customthemes', 'sesytube');
        $values = $form->getValues();

        if(!$customtheme_id)
          $customtheme = $table->createRow();
        $customtheme->setFromArray($values);
        $customtheme->save();

        if(!empty($values['customthemeid'])) {
          $customthemeItem = Engine_Api::_()->getItem('sesytube_customthemes', $values['customthemeid']);
          $description = unserialize($customthemeItem->description);
          $finalDescription = serialize(array_merge($description, array('custom_theme_color' => $customtheme->customtheme_id)));
          $customtheme->description = $finalDescription;
          $customtheme->save();
        }
        $db->commit();
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesytube', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $customtheme->customtheme_id),'admin_default',true),
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
        $slideImage = Engine_Api::_()->getItem('sesytube_customthemes', $customtheme_id);
        $slideImage->delete();
        $db->commit();
        $activatedTheme = Engine_Api::_()->sesytube()->getContantValueXML('custom_theme_color');
        $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesytube', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $activatedTheme),'admin_default',true),
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
    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3  AND `engine4_core_content`.`name` !='main' AND `engine4_core_content`.`name` !='middle' AND `engine4_core_content`.`type`='container';");

    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3;");
    $LandingPageOrder = 1;
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
        'name' => 'sesytube.home-slider',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $top_middle_id,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesytube.videos',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesytube.photos',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"popularitycriteria":"creation_date","show_criteria":"","limit":"8","title":"Recent Photos","nomobile":"0","name":"sesytube.photos"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesytube.text-block',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesytube.member-cloud',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"heading":"1","showTitle":"1","memberCount":"","height":"","width":"","title":"","nomobile":"0","name":"sesytube.member-cloud"}',
    ));
  }

  //Upload Home Banner images
	public function uploadHomeBanner(){

		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$slideData = array('slide_1', 'slide_2', 'slide_3');
		foreach($slideData as $data) {
      $data1 = explode('_', $data);
      $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesytube' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "homebanner" . DIRECTORY_SEPARATOR;
      if (is_file($PathFile . $data . '.jpg')) {
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $filename = $storage->createFile($PathFile . $data.'.jpg', array(
            'parent_id' => $data1[1],
            'parent_type' => 'sesytube_slide',
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        $file_id = $filename->file_id;
        $db->query("UPDATE `engine4_sesytube_slides` SET `file_id` = '" . $file_id . "' WHERE slide_id = " . $data1[1]);
      }
		}
	}


  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesytube_admin_main', array(), 'sesytube_admin_main_typography');

    $this->view->form = $form = new Sesytube_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sesytube_body']);
      unset($values['sesytube_heading']);
      unset($values['sesytube_mainmenu']);
      unset($values['sesytube_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sesytube_googlefonts']) {
            unset($values['sesytube_body_fontfamily']);
            unset($values['sesytube_heading_fontfamily']);
            unset($values['sesytube_mainmenu_fontfamily']);
            unset($values['sesytube_tab_fontfamily']);

            unset($values['sesytube_body_fontsize']);
            unset($values['sesytube_heading_fontsize']);
            unset($values['sesytube_mainmenu_fontsize']);
            unset($values['sesytube_tab_fontsize']);

            if($values['sesytube_googlebody_fontfamily'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_body_fontfamily', $values['sesytube_googlebody_fontfamily']);

            if($values['sesytube_googlebody_fontsize'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_body_fontsize', $values['sesytube_googlebody_fontsize']);

            if($values['sesytube_googleheading_fontfamily'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_heading_fontfamily', $values['sesytube_googleheading_fontfamily']);

            if($values['sesytube_googleheading_fontsize'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_heading_fontsize', $values['sesytube_googleheading_fontsize']);

            if($values['sesytube_googlemainmenu_fontfamily'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_mainmenu_fontfamily', $values['sesytube_googlemainmenu_fontfamily']);

            if($values['sesytube_googlemainmenu_fontsize'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_mainmenu_fontsize', $values['sesytube_googlemainmenu_fontsize']);

            if($values['sesytube_googletab_fontfamily'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_tab_fontfamily', $values['sesytube_googletab_fontfamily']);

            if($values['sesytube_googletab_fontsize'])
              Engine_Api::_()->sesytube()->readWriteXML('sesytube_tab_fontsize', $values['sesytube_googletab_fontsize']);

            //Engine_Api::_()->sesytube()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sesytube_googlebody_fontfamily']);
            unset($values['sesytube_googleheading_fontfamily']);
            unset($values['sesytube_googleheading_fontfamily']);
            unset($values['sesytube_googletab_fontfamily']);

            unset($values['sesytube_googlebody_fontsize']);
            unset($values['sesytube_googleheading_fontsize']);
            unset($values['sesytube_googlemainmenu_fontsize']);
            unset($values['sesytube_googletab_fontsize']);

            Engine_Api::_()->sesytube()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function memberhomepageSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $orlanpage_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'user_index_home')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($orlanpage_id) {
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "999900" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "999900" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "user_index_home_1" WHERE `engine4_core_pages`.`name` = "user_index_home";');
    }

    //New Member Home Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesytube_index_sesbackupmemberhomepage')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {
      $widgetOrder = 1;
      $LandingPageOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'sesytube_index_sesbackupmemberhomepage',
          'displayname' => 'Member Home Page',
          'title' => 'Member Home Page',
          'description' => 'This is your site\'s member home page.',
          'custom' => 0,
      ));
      $newpagelastId = $pageId = $db->lastInsertId();
// Insert top
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'top',
          'page_id' => $pageId,
          'order' => 1,
      ));
      $topId = $db->lastInsertId();
// Insert main
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'main',
          'page_id' => $pageId,
          'order' => 2,
      ));
      $mainId = $db->lastInsertId();

// Insert top-middle
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $pageId,
          'parent_content_id' => $topId,
      ));
      $topMiddleId = $db->lastInsertId();
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
            'name' => 'sesytube.home-slider',
            'page_id' => $pageId,
            'order' => $LandingPageOrder++,
            'parent_content_id' => $topMiddleId,
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesytube.videos',
            'page_id' => $pageId,
            'order' => $LandingPageOrder++,
            'parent_content_id' => $mainMiddleId,
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesytube.photos',
            'page_id' => $pageId,
            'order' => $LandingPageOrder++,
            'parent_content_id' => $mainMiddleId,
            'params' => '{"popularitycriteria":"creation_date","show_criteria":"","limit":"8","title":"Recent Photos","nomobile":"0","name":"sesytube.photos"}',
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesytube.text-block',
            'page_id' => $pageId,
            'order' => $LandingPageOrder++,
            'parent_content_id' => $mainMiddleId,
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesytube.member-cloud',
            'page_id' => $pageId,
            'order' => $LandingPageOrder++,
            'parent_content_id' => $mainMiddleId,
            'params' => '{"heading":"1","showTitle":"1","memberCount":"","height":"","width":"","title":"","nomobile":"0","name":"sesytube.member-cloud"}',
        ));

      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesytube_index_sesbackupmemberhomepage')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "4" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "4" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "user_index_home" WHERE `engine4_core_pages`.`name` = "sesytube_index_sesbackupmemberhomepage";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sesytube_index_sesbackupmemberhomepage" WHERE `engine4_core_pages`.`name` = "user_index_home_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Advanced Page - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sesytube_index_sesbackupmemberhomepage";');
      }
    }
  }
}
