<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_settings');

    $this->view->form = $form = new Sespagethm_Form_Admin_Global();

    //Start Make extra file for sespagethm theme custom css and sespagethm constant
    $this->makeSpFile($form);
    //Start Make extra file for sespagethm constant

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['popupstyle']);
      unset($values['layout_settings']);
      include_once APPLICATION_PATH . "/application/modules/Sespagethm/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagethm.pluginactivated')) {

        //Header Work
        if(@$values['sespagethm_header_set']) {
	        $this->headerWidgetSet();
        }
        //Footer Work
        if(@$values['sespagethm_footer_set']) {
	        $this->footerWidgetSet();
        }
        //Landing Page Set Work
        if(@$values['sespagethm_landingpage_set']) {
	        $this->landingpageSet();
        }

        foreach ($values as $key => $value) {

          if ($key == 'sespagethm_popup_design' || $key == 'sespagethm_user_photo_round' || $key == 'sespagethm_main_width' || $key == 'sespagethm_left_columns_width' || $key == 'sespagethm_header_fixed_layout' || $key == 'sespagethm_right_columns_width' || $key == 'sespagethm_responsive_layout' || $key == 'sespagethm_body_background_image') {
            Engine_Api::_()->sespagethm()->readWriteXML($key, $value);
          }
					if($key == 'sespagethm_header_loggedin_options' || $key == 'sespagethm_header_nonloggedin_options' || $key == 'sespagethm_header_nonloggedin_options' || $key == 'sespagethm_header_loggedin_options' || $key == 'sespagethm_landingpage_backgroundimage' || $key == 'sespagethm_landingpage_mainimage'){
						if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key)){
							Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
						}
					}
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }

        //Here we have set the value of theme active.
        if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagethm.themeactive')) {

          Engine_Api::_()->getApi('settings', 'core')->setSetting('sespagethm.themeactive', 1);

          $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sespagethm', 'Spectromedia', '', 0)");

          $themeName = 'sespagethm';
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
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_typography');

    $this->view->form = $form = new Sespagethm_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sespagethm_body']);
      unset($values['sespagethm_heading']);
      unset($values['sespagethm_mainmenu']);
      unset($values['sespagethm_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagethm.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sespagethm_googlefonts']) {
            unset($values['sespagethm_body_fontfamily']);
            unset($values['sespagethm_heading_fontfamily']);
            unset($values['sespagethm_mainmenu_fontfamily']);
            unset($values['sespagethm_tab_fontfamily']);

            unset($values['sespagethm_body_fontsize']);
            unset($values['sespagethm_heading_fontsize']);
            unset($values['sespagethm_mainmenu_fontsize']);
            unset($values['sespagethm_tab_fontsize']);

            if($values['sespagethm_googlebody_fontfamily'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_body_fontfamily', $values['sespagethm_googlebody_fontfamily']);

            if($values['sespagethm_googlebody_fontsize'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_body_fontsize', $values['sespagethm_googlebody_fontsize']);

            if($values['sespagethm_googleheading_fontfamily'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_heading_fontfamily', $values['sespagethm_googleheading_fontfamily']);

            if($values['sespagethm_googleheading_fontsize'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_heading_fontsize', $values['sespagethm_googleheading_fontsize']);

            if($values['sespagethm_googlemainmenu_fontfamily'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_mainmenu_fontfamily', $values['sespagethm_googlemainmenu_fontfamily']);

            if($values['sespagethm_googlemainmenu_fontsize'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_mainmenu_fontsize', $values['sespagethm_googlemainmenu_fontsize']);

            if($values['sespagethm_googletab_fontfamily'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_tab_fontfamily', $values['sespagethm_googletab_fontfamily']);

            if($values['sespagethm_googletab_fontsize'])
              Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_tab_fontsize', $values['sespagethm_googletab_fontsize']);

            //Engine_Api::_()->sespagethm()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sespagethm_googlebody_fontfamily']);
            unset($values['sespagethm_googleheading_fontfamily']);
            unset($values['sespagethm_googleheading_fontfamily']);
            unset($values['sespagethm_googletab_fontfamily']);

            unset($values['sespagethm_googlebody_fontsize']);
            unset($values['sespagethm_googleheading_fontsize']);
            unset($values['sespagethm_googlemainmenu_fontsize']);
            unset($values['sespagethm_googletab_fontsize']);

            Engine_Api::_()->sespagethm()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_styling');

    $this->view->form = $form = new Sespagethm_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']); unset($values['footer_settings']); unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {
        Engine_Api::_()->sespagethm()->readWriteXML($key, $value, '');
        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($stringReplace == 'sespagethm.mainmenu.background.color') {
          $stringReplace = 'sespagethm.mainmenu.backgroundcolor';
          } elseif($stringReplace == 'sespagethm.mainmenu.link.color') {
          $stringReplace = 'sespagethm.mainmenu.linkcolor';
          } elseif($stringReplace == 'sespagethm.minimenu.link.color') {
	            $stringReplace = 'sespagethm.minimenu.linkcolor';
           } elseif($stringReplace == 'sespagethm.font.color') {
	            $stringReplace = 'sespagethm.fontcolor';
           } elseif($stringReplace == 'sespagethm.link.color') {
	            $stringReplace = 'sespagethm.linkcolor';
           } elseif($stringReplace == 'sespagethm.content.border.color') {
	            $stringReplace = 'sespagethm.content.bordercolor';
           } elseif($stringReplace == 'sespagethm.button.background.color') {
	            $stringReplace = 'sespagethm.button.backgroundcolor';
           } else {
          $stringReplace = str_replace('_', '.', $key);
          }
          $columnVal = $settingsTable->select()
									   ->from($settingsTableName, array('value'))
                    ->where('name = ?', $stringReplace)
                    ->query()
                    ->fetchColumn();
          if($columnVal) {
            if($stringReplace == 'sespagethm.mainmenu.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sespagethm.mainmenu.backgroundcolor";');

            } elseif($stringReplace == 'sespagethm.mainmenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sespagethm.mainmenu.linkcolor";');
           } elseif($stringReplace == 'sespagethm.minimenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sespagethm.minimenu.linkcolor";');
           } elseif($stringReplace == 'sespagethm.font.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sespagethm.fontcolor";');
           } elseif($stringReplace == 'sespagethm.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sespagethm.linkcolor";');
           } elseif($stringReplace == 'sespagethm.content.border.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sespagethm.content.bordercolor";');
           } elseif($stringReplace == 'sespagethm.button.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sespagethm.button.backgroundcolor";');
           }
           else {
		          $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "'.$stringReplace.'";');
	          }
          } else {
            if($stringReplace == 'sespagethm.mainmenu.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sespagethm.mainmenu.backgroundcolor", "'.$value.'");');
            } elseif($stringReplace == 'sespagethm.mainmenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sespagethm.mainmenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sespagethm.minimenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sespagethm.minimenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sespagethm.font.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sespagethm.fontcolor", "'.$value.'");');
           } elseif($stringReplace == 'sespagethm.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sespagethm.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sespagethm.content.border.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sespagethm.content.bordercolor", "'.$value.'");');
           } elseif($stringReplace == 'sespagethm.button.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sespagethm.button.backgroundcolor", "'.$value.'");');
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
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_menus');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sespagethm')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_sespagethm_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'sespagethm')->getAllSearchOptions();
  }

  public function orderManageSearchAction() {

    if (!$this->getRequest()->isPost())
      return;

    $managesearchoptionsTable = Engine_Api::_()->getDbtable('managesearchoptions', 'sespagethm');
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
      $item = Engine_Api::_()->getItem('sespagethm_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sespagethm/settings/manage-search');
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
        $db->update('engine4_sespagethm_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
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
    $managesearchoptions = Engine_Api::_()->getItem('sespagethm_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sespagethm_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sespagethm_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sespagethm()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_sespagethm_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagethm', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
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
		$content_id = $this->widgetCheck(array('widget_name' => 'sespagethm.header', 'page_id' => '1'));

		$minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
		$menulogo = $this->widgetCheck(array('widget_name' => 'core.menu-logo', 'page_id' => '1'));
		$mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
		$minisearch = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));

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
			if($minisearch)
			  $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$minisearch.'";');
		  $db->insert('engine4_core_content', array(
		      'type' => 'widget',
		      'name' => 'sespagethm.header',
		      'page_id' => 1,
		      'parent_content_id' => $parent_content_id,
		      'order' => 20,
		  ));
		}

  }

  public function footerWidgetSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		//Footer Default Work
		$footerContent_id = $this->widgetCheck(array('widget_name' => 'sespagethm.footer', 'page_id' => '2'));
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
		      'name' => 'sespagethm.footer',
		      'page_id' => 2,
		      'parent_content_id' => $parent_content_id,
		      'order' => 10,
		  ));
		}
  }


  public function landingpageSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    //Set Welcomw page as Landing Page and backup of Old Landing Page
    $orlanpage_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'core_index_index')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($orlanpage_id) {
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "990000" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "990000" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index_1" WHERE `engine4_core_pages`.`name` = "core_index_index";');
    }
    //New Landing Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sespage_index_sesbackuplandingppage')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {
      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'sespage_index_sesbackuplandingppage',
          'displayname' => 'Landing Page',
          'title' => 'Landing Page',
          'description' => 'This is your site\'s landing page.',
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
          'name' => 'sespage.banner-search',
          'page_id' => $pageId,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"banner_title":"Explore World\u2019s Largest Page Directory","description":"Search Pages from 11,99,389 Awesome Verified Directories!","height_image":"520","show_criteria":["title","location","category"],"show_carousel":"1","category_carousel_title":"Boost your search with Trending Categories","show_full_width":"yes","title":"","nomobile":"0","name":"sespage.banner-search"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sespage.browse-menu',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sespage.featured-sponsored-hot',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"grid","order":"","category_id":"","criteria":"6","info":"most_liked","show_criteria":["title","by","ownerPhoto","category","status","location","contactDetail","likeButton","favouriteButton","followButton","like","comment","favourite","view","follow","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"160","width":"300","limit_data":"8","title":"Verified Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"Explore All Verified Pages Button","data":"<a href=\"\/page-directories\/verified\" class=\"sesbasic_link_btn\">Explore All Verified Pages<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sespage.featured-sponsored-hot',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"horrizontallist","order":"","category_id":"","criteria":"1","info":"favourite_count","show_criteria":["title","by","ownerPhoto","creationDate","category","status","description","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","like","favourite","follow"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"200","width":"250","limit_data":"6","title":"Explore Featured Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"View All Featured Pages Button","data":"<a href=\"\/page-directories\/featured\" class=\"sesbasic_link_btn\">View All Featured Pages<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sespage.featured-sponsored-carousel',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"horizontal","order":"","category_id":"","criteria":"5","info":"creation_date","show_criteria":["title","by","ownerPhoto","creationDate","category","status","location","socialSharing","likeButton","favouriteButton","followButton","joinButton","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","imageheight":"235","width":"397","limit_data":"10","title":"Latest Posted Pages","nomobile":"0","name":"sespage.featured-sponsored-carousel"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"Recent Pages Button","data":"<a href=\"\/page-directories\/browse\" class=\"sesbasic_link_btn\">Find Recent Pages<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesbasic.body-class',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"bodyclass":"sespage_welcome_page","title":"","nomobile":"0","name":"sesbasic.body-class"}',
      ));
      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sespage_index_sesbackuplandingppage')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "sespage_index_sesbackuplandingppage";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sespage_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Advanced Page - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sespage_index_sesbackuplandingppage";');
      }
    }
  }

  public function makeSpFile($form) {

    //Start Make extra file for sespagethm theme custom css
    $themeDirName = APPLICATION_PATH . '/application/themes/sespagethm';
    @chmod($themeDirName, 0777);
    if (!is_readable($themeDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
      $form->addError($itemError);
      return;
    }
    $fileName = $themeDirName . '/sespagethm-custom.css';
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
    //Start Make extra file for sespagethm theme custom css

    //Start Make extra file for sespagethm constant
    $moduleDirName = APPLICATION_PATH . '/application/modules/Sespagethm/externals/styles/';
    @chmod($moduleDirName, 0777);
    if (!is_readable($moduleDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $moduleDirName);
      $form->addError($itemError);
      return;
    }
    $fileNameXML = $moduleDirName . '/sespagethm.xml';
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
    //Start Make extra file for sespagethm constant
  }
}
