<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessportz_admin_main', array(), 'sessportz_admin_main_settings');

    $this->view->form = $form = new Sessportz_Form_Admin_Global();

    //Start Make extra file for sessportz theme custom css and sessportz constant
    $this->makeSpFile($form);
    //Start Make extra file for sessportz constant

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['popupstyle']);
      unset($values['layout_settings']);
      include_once APPLICATION_PATH . "/application/modules/Sessportz/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.pluginactivated')) {

        //Header Work
        if(@$values['sessportz_header_set']) {
	        $this->headerWidgetSet();
        }
        //Footer Work
        if(@$values['sessportz_footer_set']) {
	        $this->footerWidgetSet();
        }
        //Landing Page Set Work
        if(@$values['sessportz_landingpage_set']) {
	        $this->landingpageSet();
        }

        foreach ($values as $key => $value) {

          if ($key == 'sessportz_user_photo_round' || $key == 'sessportz_main_width' || $key == 'sessportz_left_columns_width' || $key == 'sessportz_header_fixed_layout' || $key == 'sessportz_right_columns_width' || $key == 'sessportz_responsive_layout' || $key == 'sessportz_body_background_image') {
            if($key == 'sessportz_body_background_image') {
              if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key)){
                Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
              }
              Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
              $value = Engine_Api::_()->sessportz()->getFileUrl($value);
            }
            Engine_Api::_()->sessportz()->readWriteXML($key, $value);
          }
					if($key == 'sessportz_header_loggedin_options' || $key == 'sessportz_header_nonloggedin_options' || $key == 'sessportz_header_nonloggedin_options' || $key == 'sessportz_header_loggedin_options' || $key == 'sessportz_landingpage_backgroundimage' || $key == 'sessportz_landingpage_mainimage'){
						if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key)){
							Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
						}
					}
					if($key != 'sessportz_body_background_image')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }

        //Here we have set the value of theme active.
        if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.themeactive')) {

          Engine_Api::_()->getApi('settings', 'core')->setSetting('sessportz.themeactive', 1);

          $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sessportz', 'Spectromedia', '', 0)");

          $themeName = 'sessportz';
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
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessportz_admin_main', array(), 'sessportz_admin_main_typography');

    $this->view->form = $form = new Sessportz_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sessportz_body']);
      unset($values['sessportz_heading']);
      unset($values['sessportz_mainmenu']);
      unset($values['sessportz_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sessportz_googlefonts']) {
            unset($values['sessportz_body_fontfamily']);
            unset($values['sessportz_heading_fontfamily']);
            unset($values['sessportz_mainmenu_fontfamily']);
            unset($values['sessportz_tab_fontfamily']);

            unset($values['sessportz_body_fontsize']);
            unset($values['sessportz_heading_fontsize']);
            unset($values['sessportz_mainmenu_fontsize']);
            unset($values['sessportz_tab_fontsize']);

            if($values['sessportz_googlebody_fontfamily'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_body_fontfamily', $values['sessportz_googlebody_fontfamily']);

            if($values['sessportz_googlebody_fontsize'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_body_fontsize', $values['sessportz_googlebody_fontsize']);

            if($values['sessportz_googleheading_fontfamily'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_heading_fontfamily', $values['sessportz_googleheading_fontfamily']);

            if($values['sessportz_googleheading_fontsize'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_heading_fontsize', $values['sessportz_googleheading_fontsize']);

            if($values['sessportz_googlemainmenu_fontfamily'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_mainmenu_fontfamily', $values['sessportz_googlemainmenu_fontfamily']);

            if($values['sessportz_googlemainmenu_fontsize'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_mainmenu_fontsize', $values['sessportz_googlemainmenu_fontsize']);

            if($values['sessportz_googletab_fontfamily'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_tab_fontfamily', $values['sessportz_googletab_fontfamily']);

            if($values['sessportz_googletab_fontsize'])
              Engine_Api::_()->sessportz()->readWriteXML('sessportz_tab_fontsize', $values['sessportz_googletab_fontsize']);

            //Engine_Api::_()->sessportz()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sessportz_googlebody_fontfamily']);
            unset($values['sessportz_googleheading_fontfamily']);
            unset($values['sessportz_googleheading_fontfamily']);
            unset($values['sessportz_googletab_fontfamily']);

            unset($values['sessportz_googlebody_fontsize']);
            unset($values['sessportz_googleheading_fontsize']);
            unset($values['sessportz_googlemainmenu_fontsize']);
            unset($values['sessportz_googletab_fontsize']);

            Engine_Api::_()->sessportz()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessportz_admin_main', array(), 'sessportz_admin_main_styling');

    $this->view->form = $form = new Sessportz_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']); unset($values['footer_settings']); unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {
        Engine_Api::_()->sessportz()->readWriteXML($key, $value, '');
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
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessportz_admin_main', array(), 'sessportz_admin_main_menus');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sessportz')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_sessportz_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'sessportz')->getAllSearchOptions();
  }

  public function orderManageSearchAction() {

    if (!$this->getRequest()->isPost())
      return;

    $managesearchoptionsTable = Engine_Api::_()->getDbtable('managesearchoptions', 'sessportz');
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
      $item = Engine_Api::_()->getItem('sessportz_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sessportz/settings/manage-search');
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
        $db->update('engine4_sessportz_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
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
    $managesearchoptions = Engine_Api::_()->getItem('sessportz_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sessportz_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sessportz_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sessportz()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_sessportz_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessportz', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
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
		$content_id = $this->widgetCheck(array('widget_name' => 'sessportz.header', 'page_id' => '1'));

		$minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
		$menulogo = $this->widgetCheck(array('widget_name' => 'core.menu-logo', 'page_id' => '1'));
		$mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
        $search = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));

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
            if($search)
			  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$search.'";');
		  $db->insert('engine4_core_content', array(
		      'type' => 'widget',
		      'name' => 'sessportz.header',
		      'page_id' => 1,
		      'parent_content_id' => $parent_content_id,
		      'order' => 20,
		  ));
		}

  }

  public function footerWidgetSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		//Footer Default Work
		$footerContent_id = $this->widgetCheck(array('widget_name' => 'sessportz.footer', 'page_id' => '2'));
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
		      'name' => 'sessportz.footer',
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
					      ->where('name = ?', 'sessportz_index_sesbackuplandingppage')
					      ->limit(1)
					      ->query()
					      ->fetchColumn();
		if( !$page_id ) {
		   $widgetOrder = 1;
		  //Insert page
		  $db->insert('engine4_core_pages', array(
		    'name' => 'sessportz_index_sesbackuplandingppage',
		    'displayname' => 'Landing Page',
		    'title' => 'Landing Page',
		    'description' => 'This is your site\'s landing page.',
		    'custom' => 0,
		  ));
		  $newpagelastId = $page_id = $db->lastInsertId();

        //CONTAINERS
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'main',
            'parent_content_id' => null,
            'order' => 2,
            'params' => '',
        ));
        $container_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'middle',
            'parent_content_id' => $container_id,
            'order' => 6,
            'params' => '',
        ));
        $middle_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'top',
            'parent_content_id' => null,
            'order' => 1,
            'params' => '',
        ));
        $topcontainer_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'middle',
            'parent_content_id' => $topcontainer_id,
            'order' => 6,
            'params' => '',
        ));
        $topmiddle_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'right',
            'parent_content_id' => $container_id,
            'order' => 5,
            'params' => '',
        ));
        $right_id = $db->lastInsertId('engine4_core_content');

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'seshtmlbackground.slideshow',
		    'page_id' => $page_id,
		    'parent_content_id' => $topmiddle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"gallery_id":"1","templateDesign":"3","inside_ouside":"1","full_width":"1","full_height":"1","mute_video":"1","logo":"1","logo_url":"public\/admin\/logo-2.png","main_navigation":"1","mini_navigation":"1","autoplay":"1","thumbnail":"1","searchEnable":"1","height":"583","limit_data":"0","order":"adminorder","autoplaydelay":"5000","signupformtopmargin":"60","title":"","nomobile":"0","name":"seshtmlbackground.slideshow"}',
		  ));

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesnews.featured-sponsored-verified-random-news',
		    'page_id' => $page_id,
		    'parent_content_id' => $topmiddle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"category":"0","info":"recently_created","criteria":"5","order":"","show_criteria":["title","by","featuredLabel","sponsoredLabel","hotLabel","newLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"sesnews.featured-sponsored-verified-random-news"}',
		  ));

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'seslandingpage.design1-widget4',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"resourcetype":"sesnews_news","popularitycriteria":"creation_date","description":"","showstats":["likecount","viewcount","commentcount","favouritecount","ownername","title","creationdate","description","category"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","descriptiontruncation":"150","title":"Popular News","nomobile":"0","name":"seslandingpage.design1-widget4"}',
		  ));
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'seslandingpage.design1-widget4',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"resourcetype":"sesnews_news","popularitycriteria":"creation_date","description":"","showstats":["likecount","viewcount","commentcount","favouritecount","ownername","title","creationdate","description","category"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","descriptiontruncation":"150","title":"Popular News","nomobile":"0","name":"seslandingpage.design1-widget4"}',
		  ));
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'seslandingpage.design6-widget4',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"resourcetype":"sesvideo_video","popularitycriteria":"creation_date","showstats":["title"],"descriptiontruncation":"100","title":"Hot Videos","nomobile":"0","name":"seslandingpage.design6-widget4"}',
		  ));
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesproduct.browse-products',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"enableTabs":["grid"],"openViewType":"grid","show_criteria":["price","discount","addCart","addWishlist","title","category"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","category":"0","sort":"recentlySPcreated","show_item_count":"0","title_truncation_list":"45","title_truncation_grid":"45","title_truncation_pinboard":"45","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_list":"230","width_list":"260","height_grid":"230","width_grid":"268","width_pinboard":"300","limit_data_pinboard":"10","limit_data_grid":"4","limit_data_list":"3","limit_data_map":"10","show_sale":"0","pagging":"auto_load","title":"Featured Products","nomobile":"0","name":"sesproduct.browse-products"}',
		  ));
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesteam.browse-team',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"sesteam_type":"teammember","sesteam_template":"4","popularity":"","sesteam_contentshow":["displayname","designation"],"viewMoreText":"View Details","height":"178","width":"178","sesteam_social_border":"1","center_block":"1","center_heading":"1","center_description":"1","limit":"4","paginationType":"0","title":"Our team","nomobile":"0","name":"sesteam.browse-team"}',
		  ));

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'seshtmlbackground.parallax-video',
		    'page_id' => $page_id,
		    'parent_content_id' => $middle_id,
		    'order' => $widgetOrder++,
		    'params' => '{"bannervideo":"public\/admin\/video.mp4","paralextitle":"<h2 style=\"font-size: 50px; font-weight: normal; margin-bottom: 20px; text-transform: uppercase;\">LIFE IS ABOUT TIMING<\/h2>\r\n<p style=\"padding: 0 100px; font-size: 17px; margin-bottom: 20px; font-family: Oswald;\">You can help us make Videos even better by uploading your own content. Simply register for an account, select which content you want to contribute and then use our handy upload tool to add them to our library.<\/p>\r\n<p><img src=\"https:\/\/sportz.socialenginesolutions.com\/public\/admin\/play-button.png\"><\/p>","height":"400","title":"","nomobile":"0","name":"seshtmlbackground.parallax-video"}',
		  ));

		  // Insert content
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sessportz.landing-page-table',
		    'page_id' => $page_id,
		    'parent_content_id' => $right_id,
		    'order' => $widgetOrder++,
		    'params' => '{"title":"Points Table","name":"sessportz.landing-page-table"}',
		  ));
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesproduct.browse-products',
		    'page_id' => $page_id,
		    'parent_content_id' => $right_id,
		    'order' => $widgetOrder++,
		    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["price","addCart","title","category"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","category":"0","sort":"recentlySPcreated","show_item_count":"0","title_truncation_list":"45","title_truncation_grid":"45","title_truncation_pinboard":"45","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_list":"120","width_list":"200","height_grid":"270","width_grid":"389","width_pinboard":"300","limit_data_pinboard":"10","limit_data_grid":"2","limit_data_list":"2","limit_data_map":"1","show_sale":"0","pagging":"pagging","title":"hot deals","nomobile":"0","name":"sesproduct.browse-products"}',
		  ));

		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sescommunityads.banner-ads',
		    'page_id' => $page_id,
		    'parent_content_id' => $right_id,
		    'order' => $widgetOrder++,
		    'params' => '{"rented":"0","package_id":"2","defaultbanner":"0","bannerid":"2","category":"1","featured_sponsored":"3","limit":"1","title":"","nomobile":"0","name":"sescommunityads.banner-ads"}',
		  ));
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sescommunityads.banner-ads',
		    'page_id' => $page_id,
		    'parent_content_id' => $right_id,
		    'order' => $widgetOrder++,
		    'params' => '{"rented":"1","package_id":"2","defaultbanner":"0","bannerid":"1","category":"2","featured_sponsored":"3","limit":"1","title":"","nomobile":"0","name":"sescommunityads.banner-ads"}',
		  ));
		  $db->insert('engine4_core_content', array(
		    'type' => 'widget',
		    'name' => 'sesevent.tabbed-events',
		    'page_id' => $page_id,
		    'parent_content_id' => $right_id,
		    'order' => $widgetOrder++,
		    'params' => '{"enableTabs":["list"],"openViewType":"list","tabOption":"advance","show_item_count":"0","show_criteria":["location","title","by"],"limit_data":"2","show_limited_data":"yes","pagging":"button","grid_title_truncation":"30","advgrid_title_truncation":"45","list_title_truncation":"45","pinboard_title_truncation":"45","masonry_title_truncation":"45","list_description_truncation":"45","masonry_description_truncation":"45","grid_description_truncation":"45","pinboard_description_truncation":"45","height":"120","width":"140","photo_height":"120","photo_width":"250","info_height":"120","advgrid_width":"344","advgrid_height":"222","pinboard_width":"250","masonry_height":"250","search_type":"","ongoingSPupcomming_order":"1","ongoingSPupcomming_label":"Upcoming & Ongoing","upcoming_order":"1","upcoming_label":"Upcoming","ongoing_order":"2","ongoing_label":"Ongoing","past_order":"3","past_label":"Past","week_order":"4","week_label":"This Week","weekend_order":"5","weekend_label":"This Weekend","month_order":"6","month_label":"This Month","mostSPjoined_order":"7","mostSPjoined_label":"Most Joined Events","recentlySPcreated_order":"8","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"9","mostSPviewed_label":"Most Viewed","mostSPliked_order":"10","mostSPliked_label":"Most Liked","mostSPcommented_order":"11","mostSPcommented_label":"Most Commented","mostSPrated_order":"12","mostSPrated_label":"Most Rated","mostSPfavourite_order":"13","mostSPfavourite_label":"Most Favourite","featured_order":"14","featured_label":"Featured","sponsored_order":"15","sponsored_label":"Sponsored","verified_order":"16","verified_label":"Verified","title":"Upcoming Matches","nomobile":"0","name":"sesevent.tabbed-events"}',
		  ));

		  $newbakpage_id = $db->select()
					      ->from('engine4_core_pages', 'page_id')
					      ->where('name = ?', 'sessportz_index_sesbackuplandingppage')
					      ->limit(1)
					      ->query()
					      ->fetchColumn();
		  if($newbakpage_id) {

			  $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "'.$newbakpage_id.'";');

			  $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "'.$newbakpage_id.'";');

		    $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "sessportz_index_sesbackuplandingppage";');
			  $db->query('UPDATE `engine4_core_pages` SET `name` = "sessportz_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
			  $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Spectro Media Theme - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sessportz_index_sesbackuplandingppage";');
		  }
		}
  }

  public function makeSpFile($form) {

    //Start Make extra file for sessportz theme custom css
    $themeDirName = APPLICATION_PATH . '/application/themes/sessportz';
    @chmod($themeDirName, 0777);
    if (!is_readable($themeDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
      $form->addError($itemError);
      return;
    }
    $fileName = $themeDirName . '/sessportz-custom.css';
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
    //Start Make extra file for sessportz theme custom css

    //Start Make extra file for sessportz constant
    $moduleDirName = APPLICATION_PATH . '/application/modules/Sessportz/externals/styles/';
    @chmod($moduleDirName, 0777);
    if (!is_readable($moduleDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $moduleDirName);
      $form->addError($itemError);
      return;
    }
    $fileNameXML = $moduleDirName . '/sessportz.xml';
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
    //Start Make extra file for sessportz constant
  }
}
