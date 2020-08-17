<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesexpose_AdminSettingsController extends Core_Controller_Action_Admin {


  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesexpose_admin_main', array(), 'sesexpose_admin_main_settings');

    $this->view->form = $form = new Sesexpose_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      //Start Make extra file for expose theme custom css and constant xml file
      $this->makeExposeFile($form);

      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesexpose/controllers/License.php";

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.pluginactivated')) {

				if (!empty($values['sesexpose_layout_enable'])) {
          //Landing Page
					$this->landingpageDefault();
				}
        unset($values['popup_settings']);

				foreach ($values as $key => $value) {
          if ($key == 'exp_body_background_image') {
            if(empty($value)) {
              $value = 'public/admin/blank.png';
            }
            Engine_Api::_()->sesexpose()->readWriteXML($key, $value);
          }
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
				}

				//Here we have set the value of theme active.
				if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.themeactive')) {

					$db = Engine_Db_Table::getDefaultAdapter();

					Engine_Api::_()->getApi('settings', 'core')->setSetting('sesexpose.themeactive', 1);

					$db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesexpose', 'Expose', '', 0)");

					$themeName = 'sesexpose';
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
				}

				$form->addNotice('Your changes have been saved.');
				if($error)
				$this->_helper->redirector->gotoRoute(array());
      }
    }
  }


  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesexpose_admin_main', array(), 'sesexpose_admin_main_typography');

    $this->view->form = $form = new Sesexpose_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['exp_body']);
      unset($values['exp_heading']);
      unset($values['exp_mainmenu']);
      unset($values['exp_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sesexpose_googlefonts']) {
            unset($values['exp_body_fontfamily']);
            unset($values['exp_heading_fontfamily']);
            unset($values['exp_mainmenu_fontfamily']);
            unset($values['exp_tab_fontfamily']);

            unset($values['exp_body_fontsize']);
            unset($values['exp_heading_fontsize']);
            unset($values['exp_mainmenu_fontsize']);
            unset($values['exp_tab_fontsize']);

            if($values['exp_googlebody_fontfamily'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_body_fontfamily', $values['exp_googlebody_fontfamily']);

            if($values['exp_googlebody_fontsize'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_body_fontsize', $values['exp_googlebody_fontsize']);

            if($values['exp_googleheading_fontfamily'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_heading_fontfamily', $values['exp_googleheading_fontfamily']);

            if($values['exp_googleheading_fontsize'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_heading_fontsize', $values['exp_googleheading_fontsize']);

            if($values['exp_googlemainmenu_fontfamily'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_mainmenu_fontfamily', $values['exp_googlemainmenu_fontfamily']);

            if($values['exp_googlemainmenu_fontsize'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_mainmenu_fontsize', $values['exp_googlemainmenu_fontsize']);

            if($values['exp_googletab_fontfamily'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_tab_fontfamily', $values['exp_googletab_fontfamily']);

            if($values['exp_googletab_fontsize'])
              Engine_Api::_()->sesexpose()->readWriteXML('exp_tab_fontsize', $values['exp_googletab_fontsize']);

            //Engine_Api::_()->sesexpose()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['exp_googlebody_fontfamily']);
            unset($values['exp_googleheading_fontfamily']);
            unset($values['exp_googleheading_fontfamily']);
            unset($values['exp_googletab_fontfamily']);

            unset($values['exp_googlebody_fontsize']);
            unset($values['exp_googleheading_fontsize']);
            unset($values['exp_googlemainmenu_fontsize']);
            unset($values['exp_googletab_fontsize']);

            Engine_Api::_()->sesexpose()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }


  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesexpose_admin_main', array(), 'sesexpose_admin_main_styling');

    $this->view->form = $form = new Sesexpose_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']);
      unset($values['footer_settings']);
      unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {
        Engine_Api::_()->sesexpose()->readWriteXML($key, $value, '');
        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($stringReplace == 'exp.mainmenu.background.color') {
						$stringReplace = 'exp.mainmenu.backgroundcolor';
          } elseif($stringReplace == 'exp.mainmenu.link.color') {
						$stringReplace = 'exp.mainmenu.linkcolor';
          } elseif($stringReplace == 'exp.minimenu.links.color') {
	          $stringReplace = 'exp.minimenu.linkscolor';
           } elseif($stringReplace == 'exp.font.color') {
	          $stringReplace = 'exp.fontcolor';
           } elseif($stringReplace == 'exp.link.color') {
	          $stringReplace = 'exp.linkcolor';
           } elseif($stringReplace == 'exp.content.border.color') {
	          $stringReplace = 'exp.content.bordercolor';
           } elseif($stringReplace == 'exp.button.background.color') {
	          $stringReplace = 'exp.button.backgroundcolor';
           } else {
						$stringReplace = str_replace('_', '.', $key);
          }
          $columnVal = $settingsTable->select()
									   ->from($settingsTableName, array('value'))
                    ->where('name = ?', $stringReplace)
                    ->query()
                    ->fetchColumn();
          if($columnVal) {
            if($stringReplace == 'exp.mainmenu.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "exp.mainmenu.backgroundcolor";');

            } elseif($stringReplace == 'exp.mainmenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "exp.mainmenu.linkcolor";');
           } elseif($stringReplace == 'exp.minimenu.links.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "exp.minimenu.linkscolor";');
           } elseif($stringReplace == 'exp.font.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "exp.fontcolor";');
           } elseif($stringReplace == 'exp.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "exp.linkcolor";');
           } elseif($stringReplace == 'exp.content.border.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "exp.content.bordercolor";');
           } elseif($stringReplace == 'exp.button.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "exp.button.backgroundcolor";');
           }
           else {
		          $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "'.$stringReplace.'";');
	          }
          } else {
            if($stringReplace == 'exp.mainmenu.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("exp.mainmenu.backgroundcolor", "'.$value.'");');
            } elseif($stringReplace == 'exp.mainmenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("exp.mainmenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'exp.minimenu.links.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("exp.minimenu.linkscolor", "'.$value.'");');
           } elseif($stringReplace == 'exp.font.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("exp.fontcolor", "'.$value.'");');
           } elseif($stringReplace == 'exp.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("exp.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'exp.content.border.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("exp.content.bordercolor", "'.$value.'");');
           } elseif($stringReplace == 'exp.button.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("exp.button.backgroundcolor", "'.$value.'");');
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

  public function makeExposeFile($form) {

    //Start Make extra file for expose theme custom css
    $themeDirName = APPLICATION_PATH . '/application/themes/sesexpose';
    @chmod($themeDirName, 0777);
    if (!is_readable($themeDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
      $form->addError($itemError);
      return;
    }
    $fileName = $themeDirName . '/sesexpose-custom.css';
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


    //Start Make extra file for sesexpose constant
    $moduleDirName = APPLICATION_PATH . '/application/modules/Sesexpose/externals/styles/';
    @chmod($moduleDirName, 0777);
    if (!is_readable($moduleDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $moduleDirName);
      $form->addError($itemError);
      return;
    }
    $fileNameXML = $moduleDirName . '/sesexpose.xml';
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
    //Start Make extra file for sesexpose constant

  }


	public function uploadBanner(){

		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$slideData = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
		foreach($slideData as $data) {
      $data1 = explode('_', $data);
      $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesexpose' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "banners" . DIRECTORY_SEPARATOR;

      if (is_file($PathFile . $data . '.jpg')) {
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $filename = $storage->createFile($PathFile . $data.'.jpg', array(
            'parent_id' => $data1[1],
            'parent_type' => 'sesexpose_slide',
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        $file_id = $filename->file_id;
        $db->query("UPDATE `engine4_sesexpose_slides` SET `file_id` = '" . $file_id . "' WHERE slide_id = " . $data);
      }
		}
	}

	public function landingpageDefault() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3;");
    $page_id = $pageId = 3;
    $LandingPageOrder = 1;
    // Insert top
    $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $pageId,
      'order' => $LandingPageOrder++,
    ));
    $topId = $db->lastInsertId();

    // Insert main
    $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => $LandingPageOrder++,
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
      'order' => $LandingPageOrder++,
    ));
    $mainMiddleId = $db->lastInsertId();

    // Insert main-right
    $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => $LandingPageOrder++,
    ));
    $mainRightId = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesexpose.banner-slideshow',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $topMiddleId,
        'params' => '{"banner_id":"2","full_width":"1","height":"555","title":"","nomobile":"0","name":"sesexpose.banner-slideshow"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbasic.html-block',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $topMiddleId,
        'params' => '{"body":"<div style=\"margin: 10px auto 0; text-align: center;\">\r\n<h2 style=\"padding: 0px; margin: 15px 0px; border: 0px solid #e7e7e7; outline: none; font-family: \'Open Sans\'; color: #000000; font-weight: normal; font-size: 25px; box-sizing: border-box; letter-spacing: 2px; display: block; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-style: initial; text-decoration-color: initial;\"><strong>SHARE YOUR IDEAS & STORIES WITH THE WORLD<\/strong><\/h2>\r\n<p style=\"padding: 0 100px; font-size: 16px; margin-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nisi dui, consectetur et justo quis, euismod vulputate augue. Pellentesque molestie sed lacus vitae egestas.<\/p>\r\n<ul style=\"overflow: hidden; margin: 0 -10px; list-style: none; padding: 0;\">\r\n<li style=\"float: left; width: 33.33%; padding: 10px; box-sizing: border-box;\">\r\n<div style=\"background-color: #eeeeee; text-align: center; padding: 20px;\">\r\n<div style=\"background-position: center; background-repeat: no-repeat; display: block; margin: 0 auto 20px; height: 117px; width: 117px; background-image: url(\'application\/modules\/Sesexpose\/externals\/images\/icon1.png\'); background-color: #fff; border-radius: 50%;\">&nbsp;<\/div>\r\n<p style=\"font-size: 20px;\"><a style=\"text-decoration: none;\" href=\"http:\/\/expose.socialenginesolutions.com\/blogs\/home\">Explore Popular Blogs<\/a><\/p>\r\n<p style=\"line-height: 25px;\">It is a long established fact that a reader will be distracted by the readable content<\/p>\r\n<\/div>\r\n<\/li>\r\n<li style=\"float: left; width: 33.33%; padding: 10px; box-sizing: border-box;\">\r\n<div style=\"background-color: #eeeeee; text-align: center; padding: 20px;\">\r\n<div style=\"background-position: center; background-repeat: no-repeat; display: block; margin: 0 auto 20px; height: 117px; width: 117px; background-image: url(\'application\/modules\/Sesexpose\/externals\/images\/icon2.png\'); background-color: #fff; border-radius: 50%;\">&nbsp;<\/div>\r\n<p style=\"font-size: 20px;\"><a style=\"text-decoration: none;\" href=\"http:\/\/expose.socialenginesolutions.com\/blogs\/create\">Create Your Unique Blog<\/a><\/p>\r\n<p style=\"line-height: 25px;\">It is a long established fact that a reader will be distracted by the readable content<\/p>\r\n<\/div>\r\n<\/li>\r\n<li style=\"float: left; width: 33.33%; padding: 10px; box-sizing: border-box;\">\r\n<div style=\"background-color: #eeeeee; text-align: center; padding: 20px;\">\r\n<div style=\"background-position: center; background-repeat: no-repeat; display: block; margin: 0 auto 20px; height: 117px; width: 117px; background-image: url(\'application\/modules\/Sesexpose\/externals\/images\/icon3.png\'); border-radius: 50%; background-color: #fff;\">&nbsp;<\/div>\r\n<p style=\"font-size: 20px;\"><a style=\"text-decoration: none;\" href=\"http:\/\/expose.socialenginesolutions.com\/blogs\/categories\">Explore By Category<\/a><\/p>\r\n<p style=\"line-height: 25px;\">It is a long established fact that a reader will be distracted by the readable content<\/p>\r\n<\/div>\r\n<\/li>\r\n<\/ul>\r\n<\/div>","en_US_body":"<div style=\"margin: 10px auto 0; text-align: center;\">\r\n<h2 style=\"padding: 0px; margin: 15px 0px; border: 0px solid #e7e7e7; outline: none; font-family: \'Open Sans\'; color: #000000; font-weight: normal; font-size: 25px; box-sizing: border-box; letter-spacing: 2px; display: block; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-style: initial; text-decoration-color: initial;\"><strong>SHARE YOUR IDEAS & STORIES WITH THE WORLD<\/strong><\/h2>\r\n<p style=\"padding: 0 100px; font-size: 16px; margin-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nisi dui, consectetur et justo quis, euismod vulputate augue. Pellentesque molestie sed lacus vitae egestas.<\/p>\r\n<ul style=\"overflow: hidden; margin: 0 -10px; list-style: none; padding: 0;\">\r\n<li style=\"float: left; width: 33.33%; padding: 10px; box-sizing: border-box;\">\r\n<div style=\"background-color: #eeeeee; text-align: center; padding: 20px;\">\r\n<div style=\"background-position: center; background-repeat: no-repeat; display: block; margin: 0 auto 20px; height: 117px; width: 117px; background-image: url(\'application\/modules\/Sesexpose\/externals\/images\/icon1.png\'); background-color: #fff; border-radius: 50%;\">&nbsp;<\/div>\r\n<p style=\"font-size: 20px;\"><a style=\"text-decoration: none;\" href=\"http:\/\/expose.socialenginesolutions.com\/blogs\/home\">Explore Popular Blogs<\/a><\/p>\r\n<p style=\"line-height: 25px;\">It is a long established fact that a reader will be distracted by the readable content<\/p>\r\n<\/div>\r\n<\/li>\r\n<li style=\"float: left; width: 33.33%; padding: 10px; box-sizing: border-box;\">\r\n<div style=\"background-color: #eeeeee; text-align: center; padding: 20px;\">\r\n<div style=\"background-position: center; background-repeat: no-repeat; display: block; margin: 0 auto 20px; height: 117px; width: 117px; background-image: url(\'application\/modules\/Sesexpose\/externals\/images\/icon2.png\'); background-color: #fff; border-radius: 50%;\">&nbsp;<\/div>\r\n<p style=\"font-size: 20px;\"><a style=\"text-decoration: none;\" href=\"http:\/\/expose.socialenginesolutions.com\/blogs\/create\">Create Your Unique Blog<\/a><\/p>\r\n<p style=\"line-height: 25px;\">It is a long established fact that a reader will be distracted by the readable content<\/p>\r\n<\/div>\r\n<\/li>\r\n<li style=\"float: left; width: 33.33%; padding: 10px; box-sizing: border-box;\">\r\n<div style=\"background-color: #eeeeee; text-align: center; padding: 20px;\">\r\n<div style=\"background-position: center; background-repeat: no-repeat; display: block; margin: 0 auto 20px; height: 117px; width: 117px; background-image: url(\'application\/modules\/Sesexpose\/externals\/images\/icon3.png\'); border-radius: 50%; background-color: #fff;\">&nbsp;<\/div>\r\n<p style=\"font-size: 20px;\"><a style=\"text-decoration: none;\" href=\"http:\/\/expose.socialenginesolutions.com\/blogs\/categories\">Explore By Category<\/a><\/p>\r\n<p style=\"line-height: 25px;\">It is a long established fact that a reader will be distracted by the readable content<\/p>\r\n<\/div>\r\n<\/li>\r\n<\/ul>\r\n<\/div>","content_height":"","content_width":"","content_class":"sesexp_features_block","show_content":"1","title":"","nomobile":"0","name":"sesbasic.html-block"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesblog.tabbed-widget-blog',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $mainMiddleId,
        'params' => '{"enableTabs":["grid2"],"openViewType":"grid2","tabOption":"default","htmlTitle":"0","category_id":"","show_criteria":["socialSharing","like","favourite","view","title","category","by","creationDate","descriptiongrid2"],"show_limited_data":"yes","pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_simplelist":"50","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_advgrid2":"20","title_truncation_supergrid":"45","title_truncation_pinboard":"45","limit_data_pinboard":"5","limit_data_list":"5","limit_data_grid":"5","limit_data_grid2":"15","limit_data_simplelist":"5","limit_data_advlist":"5","limit_data_advgrid":"5","limit_data_supergrid":"5","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_advgrid2":"60","description_truncation_simplelist":"150","description_truncation_advlist":"45","description_truncation_advgrid":"45","description_truncation_supergrid":"45","description_truncation_pinboard":"45","height_grid":"200","width_grid":"300","height_list":"230","width_list":"260","height_simplelist":"150","width_simplelist":"230","height_advgrid":"230","width_advgrid":"260","height_advgrid2":"240","width_advgrid2":"274","height_supergrid":"230","width_supergrid":"260","width_pinboard":"300","search_type":["mostSPfavourite"],"dummy1":null,"recentlySPcreated_order":"2","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Read Blogs","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked Blogs","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"1","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"FAVOURITE BLOGS","nomobile":"0","name":"sesblog.tabbed-widget-blog"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesblog.top-bloggers',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $mainRightId,
        'params' => '{"showType":"simple","view_type":"vertical","show_criteria":["ownername"],"height":"110","width":"144","showLimitData":"0","limit_data":"4","title":"Top Bloggers","nomobile":"0","name":"sesblog.top-bloggers"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesblog.featured-sponsored',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $mainRightId,
        'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_rated","show_criteria":["like","comment","view","title","by","category","socialSharing"],"show_star":"0","showLimitData":"0","title_truncation":"45","description_truncation":"60","height":"100","width":"100","limit_data":"3","title":"RECENT POSTS","nomobile":"0","name":"sesblog.featured-sponsored"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesblog.tag-cloud-category',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $mainRightId,
        'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"50","title":"CATEGORIES","nomobile":"0","name":"sesblog.tag-cloud-category"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesblog.featured-sponsored',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $mainRightId,
        'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_viewed","show_criteria":["like","comment","view","title","by","category"],"show_star":"0","showLimitData":"0","title_truncation":"45","description_truncation":"60","height":"100","width":"100","limit_data":"3","title":"MOST READ BLOGS","nomobile":"0","name":"sesblog.featured-sponsored"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbasic.column-layout-width',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $mainRightId,
        'params' => '{"layoutColumnWidthType":"px","columnWidth":"330","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesblog.tag-cloud-blogs',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $mainRightId,
        'params' => '{"color":"#000","type":"cloud","text_height":"12","height":"150","itemCountPerPage":"35","title":"","nomobile":"0","name":"sesblog.tag-cloud-blogs"}',
    ));
	}
}
