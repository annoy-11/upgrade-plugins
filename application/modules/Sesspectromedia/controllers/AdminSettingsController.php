<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesspectromedia_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesspectromedia_admin_main', array(), 'sesspectromedia_admin_main_settings');

    $this->view->form = $form = new Sesspectromedia_Form_Admin_Global();

    //Start Make extra file for sesspectromedia theme custom css and sesspectromedia constant
    $this->makeSpFile($form);
    //Start Make extra file for sesspectromedia constant

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['popupstyle']);
      unset($values['layout_settings']);
      include_once APPLICATION_PATH . "/application/modules/Sesspectromedia/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.pluginactivated')) {

        //Header Work
        if(@$values['sesspectromedia_header_set']) {
	        $this->headerWidgetSet();
        }
        //Footer Work
        if(@$values['sesspectromedia_footer_set']) {
	        $this->footerWidgetSet();
        }
        //Landing Page Set Work
        if(@$values['sesspectromedia_landingpage_set']) {
	        $this->landingpageSet();
        }

        foreach ($values as $key => $value) {

          if ($key == 'sm_popup_design' || $key == 'sm_user_photo_round' || $key == 'sm_main_width' || $key == 'sm_left_columns_width' || $key == 'sm_header_fixed_layout' || $key == 'sm_right_columns_width' || $key == 'sm_responsive_layout' || $key == 'sm_body_background_image') {
            Engine_Api::_()->sesspectromedia()->readWriteXML($key, $value);
          }
					if($key == 'sm_header_loggedin_options' || $key == 'sm_header_nonloggedin_options' || $key == 'sm_header_nonloggedin_options' || $key == 'sm_header_loggedin_options'){
						if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key)){
							Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
						}
					}
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }

        //Here we have set the value of theme active.
        if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.themeactive')) {

          Engine_Api::_()->getApi('settings', 'core')->setSetting('sesspectromedia.themeactive', 1);

          $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesspectromedia', 'Spectromedia', '', 0)");

          $themeName = 'sesspectromedia';
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
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesspectromedia_admin_main', array(), 'sesspectromedia_admin_main_typography');

    $this->view->form = $form = new Sesspectromedia_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sm_body']);
      unset($values['sm_heading']);
      unset($values['sm_mainmenu']);
      unset($values['sm_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sesspectromedia_googlefonts']) {
            unset($values['sm_body_fontfamily']);
            unset($values['sm_heading_fontfamily']);
            unset($values['sm_mainmenu_fontfamily']);
            unset($values['sm_tab_fontfamily']);

            unset($values['sm_body_fontsize']);
            unset($values['sm_heading_fontsize']);
            unset($values['sm_mainmenu_fontsize']);
            unset($values['sm_tab_fontsize']);

            if($values['sm_googlebody_fontfamily'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_body_fontfamily', $values['sm_googlebody_fontfamily']);

            if($values['sm_googlebody_fontsize'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_body_fontsize', $values['sm_googlebody_fontsize']);

            if($values['sm_googleheading_fontfamily'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_heading_fontfamily', $values['sm_googleheading_fontfamily']);

            if($values['sm_googleheading_fontsize'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_heading_fontsize', $values['sm_googleheading_fontsize']);

            if($values['sm_googlemainmenu_fontfamily'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_mainmenu_fontfamily', $values['sm_googlemainmenu_fontfamily']);

            if($values['sm_googlemainmenu_fontsize'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_mainmenu_fontsize', $values['sm_googlemainmenu_fontsize']);

            if($values['sm_googletab_fontfamily'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_tab_fontfamily', $values['sm_googletab_fontfamily']);

            if($values['sm_googletab_fontsize'])
              Engine_Api::_()->sesspectromedia()->readWriteXML('sm_tab_fontsize', $values['sm_googletab_fontsize']);

            //Engine_Api::_()->sesspectromedia()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sm_googlebody_fontfamily']);
            unset($values['sm_googleheading_fontfamily']);
            unset($values['sm_googleheading_fontfamily']);
            unset($values['sm_googletab_fontfamily']);

            unset($values['sm_googlebody_fontsize']);
            unset($values['sm_googleheading_fontsize']);
            unset($values['sm_googlemainmenu_fontsize']);
            unset($values['sm_googletab_fontsize']);

            Engine_Api::_()->sesspectromedia()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesspectromedia_admin_main', array(), 'sesspectromedia_admin_main_styling');

    $this->view->form = $form = new Sesspectromedia_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']); unset($values['footer_settings']); unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {
        Engine_Api::_()->sesspectromedia()->readWriteXML($key, $value, '');
        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($stringReplace == 'sm.mainmenu.background.color') {
          $stringReplace = 'sm.mainmenu.backgroundcolor';
          } elseif($stringReplace == 'sm.mainmenu.link.color') {
          $stringReplace = 'sm.mainmenu.linkcolor';
          } elseif($stringReplace == 'sm.minimenu.link.color') {
	            $stringReplace = 'sm.minimenu.linkcolor';
           } elseif($stringReplace == 'sm.font.color') {
	            $stringReplace = 'sm.fontcolor';
           } elseif($stringReplace == 'sm.link.color') {
	            $stringReplace = 'sm.linkcolor';
           } elseif($stringReplace == 'sm.content.border.color') {
	            $stringReplace = 'sm.content.bordercolor';
           } elseif($stringReplace == 'sm.button.background.color') {
	            $stringReplace = 'sm.button.backgroundcolor';
           } else {
          $stringReplace = str_replace('_', '.', $key);
          }
          $columnVal = $settingsTable->select()
									   ->from($settingsTableName, array('value'))
                    ->where('name = ?', $stringReplace)
                    ->query()
                    ->fetchColumn();
          if($columnVal) {
            if($stringReplace == 'sm.mainmenu.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sm.mainmenu.backgroundcolor";');

            } elseif($stringReplace == 'sm.mainmenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sm.mainmenu.linkcolor";');
           } elseif($stringReplace == 'sm.minimenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sm.minimenu.linkcolor";');
           } elseif($stringReplace == 'sm.font.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sm.fontcolor";');
           } elseif($stringReplace == 'sm.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sm.linkcolor";');
           } elseif($stringReplace == 'sm.content.border.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sm.content.bordercolor";');
           } elseif($stringReplace == 'sm.button.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sm.button.backgroundcolor";');
           }
           else {
		          $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "'.$stringReplace.'";');
	          }
          } else {
            if($stringReplace == 'sm.mainmenu.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sm.mainmenu.backgroundcolor", "'.$value.'");');
            } elseif($stringReplace == 'sm.mainmenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sm.mainmenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sm.minimenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sm.minimenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sm.font.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sm.fontcolor", "'.$value.'");');
           } elseif($stringReplace == 'sm.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sm.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sm.content.border.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sm.content.bordercolor", "'.$value.'");');
           } elseif($stringReplace == 'sm.button.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sm.button.backgroundcolor", "'.$value.'");');
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

  public function manageSearchAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesspectromedia_admin_main', array(), 'sesspectromedia_admin_main_menus');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sesspectromedia')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_sesspectromedia_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'sesspectromedia')->getAllSearchOptions();
  }

  public function orderManageSearchAction() {

    if (!$this->getRequest()->isPost())
      return;

    $managesearchoptionsTable = Engine_Api::_()->getDbtable('managesearchoptions', 'sesspectromedia');
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
      $item = Engine_Api::_()->getItem('sesspectromedia_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesspectromedia/settings/manage-search');
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
        $db->update('engine4_sesspectromedia_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
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
    $managesearchoptions = Engine_Api::_()->getItem('sesspectromedia_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sesspectromedia_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sesspectromedia_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sesspectromedia()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_sesspectromedia_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesspectromedia', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => $redirectUrl,
                  'messages' => '',
      ));
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

  public function headerWidgetSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		//Header Default Work
		$content_id = $this->widgetCheck(array('widget_name' => 'sesspectromedia.header', 'page_id' => '1'));

		$minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
		$menulogo = $this->widgetCheck(array('widget_name' => 'core.menu-logo', 'page_id' => '1'));
		$mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
		$searchmini = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));

		$parent_content_id = $db->select()
		        ->from('engine4_core_content', 'content_id')
		        ->where('type = ?', 'container')
		        ->where('page_id = ?', '1')
		        ->where('name = ?', 'main')
		        ->limit(1)
		        ->query()
		        ->fetchColumn();
		if (empty($content_id)) {
		  if($minimenu)
			  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$minimenu.'";');
			if($menulogo)
			  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$menulogo.'";');
			if($mainmenu)
			  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$mainmenu.'";');
      if($searchmini)
			  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$searchmini.'";');
		  $db->insert('engine4_core_content', array(
		      'type' => 'widget',
		      'name' => 'sesspectromedia.header',
		      'page_id' => 1,
		      'parent_content_id' => $parent_content_id,
		      'order' => 20,
		  ));
		}

  }

  public function footerWidgetSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		//Footer Default Work
		$footerContent_id = $this->widgetCheck(array('widget_name' => 'sesspectromedia.footer', 'page_id' => '2'));
		$footerMenu = $this->widgetCheck(array('widget_name' => 'core.menu-footer', 'page_id' => '2'));
		$parent_content_id = $db->select()
		        ->from('engine4_core_content', 'content_id')
		        ->where('type = ?', 'container')
		        ->where('page_id = ?', '2')
		        ->where('name = ?', 'main')
		        ->limit(1)
		        ->query()
		        ->fetchColumn();
		if (empty($footerContent_id)) {
		  if($footerMenu)
			  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$footerMenu.'";');

		  $db->insert('engine4_core_content', array(
		      'type' => 'widget',
		      'name' => 'sesspectromedia.footer',
		      'page_id' => 2,
		      'parent_content_id' => $parent_content_id,
		      'order' => 10,
		  ));
		}
  }

  public function landingpageSet() {

	  $db = Zend_Db_Table_Abstract::getDefaultAdapter();
	  //Landing Page Set and Already Landing Page Make Backup
		$orlanpage_id = $db->select()
				      ->from('engine4_core_pages', 'page_id')
				      ->where('name = ?', 'core_index_index')
				      ->limit(1)
				      ->query()
				      ->fetchColumn();
		if($orlanpage_id) {
		  $db->query('UPDATE `engine4_core_content` SET `page_id` = "123456789" WHERE `engine4_core_content`.`page_id` = "'.$orlanpage_id.'";');
		  $db->query('UPDATE `engine4_core_pages` SET `page_id` = "123456789" WHERE `engine4_core_pages`.`page_id` = "'.$orlanpage_id.'";');
		  $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index_1" WHERE `engine4_core_pages`.`name` = "core_index_index";');
		}

		//New Landing Page
		$page_id = $db->select()
					      ->from('engine4_core_pages', 'page_id')
					      ->where('name = ?', 'sesspectromedia_index_sesbackuplandingppage')
					      ->limit(1)
					      ->query()
					      ->fetchColumn();
		if( !$page_id ) {
		   $widgetOrder = 1;
		  //Insert page
		  $db->insert('engine4_core_pages', array(
		    'name' => 'sesspectromedia_index_sesbackuplandingppage',
		    'displayname' => 'Landing Page',
		    'title' => 'Landing Page',
		    'description' => 'This is your site\'s landing page.',
		    'custom' => 0,
		  ));
		  $newpagelastId = $page_id = $db->lastInsertId();

		  // Insert main
		  $db->insert('engine4_core_content', array(
		    'type' => 'container',
		    'name' => 'main',
		    'page_id' => $page_id,
		  ));
		  $main_id = $db->lastInsertId();

		  // Insert middle
		  $db->insert('engine4_core_content', array(
		    'type' => 'container',
		    'name' => 'middle',
		    'page_id' => $page_id,
		    'parent_content_id' => $main_id,
		    'order' => 2,
		  ));
		  $middle_id = $db->lastInsertId();

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'seshtmlbackground.slideshow',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"gallery_id":"1","full_width":"1","logo":"1","main_navigation":"1","mini_navigation":"1","autoplay":"1","thumbnail":"1","searchEnable":"1","height":"670","signupformtopmargin":"150","title":"","nomobile":"0","name":"seshtmlbackground.slideshow"}',
		  ));

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesvideo.popularity-videos',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"popularity":"is_sponsored","textVideo":"Videos we love","show_criteria":["like","comment","rating","favourite","view","title","by"],"pagging":"fixedbutton","video_limit":"10","height":"160px","width":"160px","title":"","nomobile":"0","name":"sesvideo.popularity-videos"}',
		  ));

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesspectromedia.landing-page-text',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		  ));

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesmusic.featured-sponsored-hot-carousel',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"contentType":"songs","popularity":"like_count","displayContentType":"feaspo","information":["title"],"viewType":"horizontal","height":"210","width":"235","limit":"9","title":"SONGS WE LOVE LISTENING TO","nomobile":"0","name":"sesmusic.featured-sponsored-hot-carousel"}',
		  ));

		    // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesspectromedia.paralex',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"paralextitle":"<h2 style=\"font-size: 35px; font-weight: normal; margin-bottom: 20px; text-transform: uppercase;\">OUR ACHIEVEMENTS<\/h2>\r\n<p style=\"padding: 0 100px; font-size: 17px; margin-bottom: 20px;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.<\/p>\r\n<ul>\r\n<li style=\"display: inline-block; width: 30%;\">\r\n<h3 style=\"font-size: 50px; font-weight: normal; border-width: 0;\">11000+<\/h3>\r\n<span style=\"font-size: 17px;\">HAPPY CLIENTS<\/span>\r\n<p style=\"font-size: 15px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.<\/p>\r\n<\/li>\r\n<li style=\"display: inline-block; width: 30%;\">\r\n<h3 style=\"font-size: 50px; font-weight: normal; border-width: 0;\">3000+<\/h3>\r\n<span style=\"font-size: 17px;\">Videos<\/span>\r\n<p style=\"font-size: 15px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.<\/p>\r\n<\/li>\r\n<li style=\"display: inline-block; width: 30%;\">\r\n<h3 style=\"font-size: 50px; font-weight: normal; border-width: 0;\">4000+<\/h3>\r\n<span style=\"font-size: 17px;\">Photos<\/span>\r\n<p style=\"font-size: 15px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.<\/p>\r\n<\/li>\r\n<\/ul>","height":"450","title":"","nomobile":"0","name":"sesspectromedia.paralex"}',
		  ));

		    // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesalbum.tabbed-widget',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"photo_album":"photo","tab_option":"filter","view_type":"masonry","description_truncation":"80","hide_row":"1","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"limit_data":"8","show_limited_data":"yes","pagging":"pagging","title_truncation":"45","height":"300","width":"140","search_type":["featured"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPfavourite_order":"2","mostSPfavourite_label":"Most Favourite","dummy4":null,"mostSPdownloaded_order":"2","mostSPdownloaded_label":"Most Downloaded","dummy5":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy6":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy7":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy8":null,"featured_order":"6","featured_label":"Featured","dummy9":null,"sponsored_order":"7","sponsored_label":"Sponsored","title":"Our Featured Photos","nomobile":"0","name":"sesalbum.tabbed-widget"}',
		  ));

		      // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesspectromedia.members',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"heading":"1","memberCount":"50","showTitle":"1","height":"150","width":"148","title":"","nomobile":"0","name":"sesspectromedia.members"}',
		  ));

		  $newbakpage_id = $db->select()
					      ->from('engine4_core_pages', 'page_id')
					      ->where('name = ?', 'sesspectromedia_index_sesbackuplandingppage')
					      ->limit(1)
					      ->query()
					      ->fetchColumn();
		  if($newbakpage_id) {

			  $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "'.$newbakpage_id.'";');

			  $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "'.$newbakpage_id.'";');

		    $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "sesspectromedia_index_sesbackuplandingppage";');
			  $db->query('UPDATE `engine4_core_pages` SET `name` = "sesspectromedia_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
			  $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Spectro Media Theme - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sesspectromedia_index_sesbackuplandingppage";');
		  }
		}
  }

  public function makeSpFile($form) {

    //Start Make extra file for sesspectromedia theme custom css
    $themeDirName = APPLICATION_PATH . '/application/themes/sesspectromedia';
    @chmod($themeDirName, 0777);
    if (!is_readable($themeDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
      $form->addError($itemError);
      return;
    }
    $fileName = $themeDirName . '/sesspectromedia-custom.css';
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
    //Start Make extra file for sesspectromedia theme custom css

    //Start Make extra file for sesspectromedia constant
    $moduleDirName = APPLICATION_PATH . '/application/modules/Sesspectromedia/externals/styles/';
    @chmod($moduleDirName, 0777);
    if (!is_readable($moduleDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $moduleDirName);
      $form->addError($itemError);
      return;
    }
    $fileNameXML = $moduleDirName . '/sesspectromedia.xml';
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
    //Start Make extra file for sesspectromedia constant
  }
}
