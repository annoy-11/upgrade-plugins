<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmaterial_admin_main', array(), 'sesmaterial_admin_main_settings');

    $this->view->form = $form = new Sesmaterial_Form_Admin_Global();

    //Start Make extra file for sesmaterial theme custom css and sesmaterial constant
    $this->makeSpFile($form);
    //Start Make extra file for sesmaterial constant

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['popupstyle']);
      unset($values['layout_settings']);
      include_once APPLICATION_PATH . "/application/modules/Sesmaterial/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.pluginactivated')) {

        //Header Work
        if(@$values['sesmaterial_header_set']) {
	        $this->headerWidgetSet();
        }
        //Footer Work
        if(@$values['sesmaterial_footer_set']) {
	        $this->footerWidgetSet();
        }
        //Landing Page Set Work
        if(@$values['sesmaterial_landingpage_set']) {
	        $this->landingpageSet();
        }

        foreach ($values as $key => $value) {

          if ($key == 'sesmaterial_popup_design' || $key == 'sesmaterial_user_photo_round' || $key == 'sesmaterial_main_width' || $key == 'sesmaterial_left_columns_width' || $key == 'sesmaterial_header_fixed_layout' || $key == 'sesmaterial_right_columns_width' || $key == 'sesmaterial_responsive_layout' || $key == 'sesmaterial_body_background_image') {
            Engine_Api::_()->sesmaterial()->readWriteXML($key, $value);
          }
					if($key == 'sesmaterial_header_loggedin_options' || $key == 'sesmaterial_header_nonloggedin_options' || $key == 'sesmaterial_header_nonloggedin_options' || $key == 'sesmaterial_header_loggedin_options' || $key == 'sesmaterial_landingpage_backgroundimage' || $key == 'sesmaterial_landingpage_mainimage'){
						if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key)){
							Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
						}
					}
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }

        //Here we have set the value of theme active.
        if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.themeactive')) {

          Engine_Api::_()->getApi('settings', 'core')->setSetting('sesmaterial.themeactive', 1);

          $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesmaterial', 'Spectromedia', '', 0)");

          $themeName = 'sesmaterial';
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
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmaterial_admin_main', array(), 'sesmaterial_admin_main_typography');

    $this->view->form = $form = new Sesmaterial_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sesmaterial_body']);
      unset($values['sesmaterial_heading']);
      unset($values['sesmaterial_mainmenu']);
      unset($values['sesmaterial_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sesmaterial_googlefonts']) {
            unset($values['sesmaterial_body_fontfamily']);
            unset($values['sesmaterial_heading_fontfamily']);
            unset($values['sesmaterial_mainmenu_fontfamily']);
            unset($values['sesmaterial_tab_fontfamily']);

            unset($values['sesmaterial_body_fontsize']);
            unset($values['sesmaterial_heading_fontsize']);
            unset($values['sesmaterial_mainmenu_fontsize']);
            unset($values['sesmaterial_tab_fontsize']);

            if($values['sesmaterial_googlebody_fontfamily'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_body_fontfamily', $values['sesmaterial_googlebody_fontfamily']);

            if($values['sesmaterial_googlebody_fontsize'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_body_fontsize', $values['sesmaterial_googlebody_fontsize']);

            if($values['sesmaterial_googleheading_fontfamily'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_heading_fontfamily', $values['sesmaterial_googleheading_fontfamily']);

            if($values['sesmaterial_googleheading_fontsize'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_heading_fontsize', $values['sesmaterial_googleheading_fontsize']);

            if($values['sesmaterial_googlemainmenu_fontfamily'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_mainmenu_fontfamily', $values['sesmaterial_googlemainmenu_fontfamily']);

            if($values['sesmaterial_googlemainmenu_fontsize'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_mainmenu_fontsize', $values['sesmaterial_googlemainmenu_fontsize']);

            if($values['sesmaterial_googletab_fontfamily'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_tab_fontfamily', $values['sesmaterial_googletab_fontfamily']);

            if($values['sesmaterial_googletab_fontsize'])
              Engine_Api::_()->sesmaterial()->readWriteXML('sesmaterial_tab_fontsize', $values['sesmaterial_googletab_fontsize']);

            //Engine_Api::_()->sesmaterial()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sesmaterial_googlebody_fontfamily']);
            unset($values['sesmaterial_googleheading_fontfamily']);
            unset($values['sesmaterial_googleheading_fontfamily']);
            unset($values['sesmaterial_googletab_fontfamily']);

            unset($values['sesmaterial_googlebody_fontsize']);
            unset($values['sesmaterial_googleheading_fontsize']);
            unset($values['sesmaterial_googlemainmenu_fontsize']);
            unset($values['sesmaterial_googletab_fontsize']);

            Engine_Api::_()->sesmaterial()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmaterial_admin_main', array(), 'sesmaterial_admin_main_styling');

    $this->view->form = $form = new Sesmaterial_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']); unset($values['footer_settings']); unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {
        Engine_Api::_()->sesmaterial()->readWriteXML($key, $value, '');
        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($stringReplace == 'sesmaterial.mainmenu.background.color') {
          $stringReplace = 'sesmaterial.mainmenu.backgroundcolor';
          } elseif($stringReplace == 'sesmaterial.mainmenu.link.color') {
          $stringReplace = 'sesmaterial.mainmenu.linkcolor';
          } elseif($stringReplace == 'sesmaterial.minimenu.link.color') {
	            $stringReplace = 'sesmaterial.minimenu.linkcolor';
           } elseif($stringReplace == 'sesmaterial.font.color') {
	            $stringReplace = 'sesmaterial.fontcolor';
           } elseif($stringReplace == 'sesmaterial.link.color') {
	            $stringReplace = 'sesmaterial.linkcolor';
           } elseif($stringReplace == 'sesmaterial.content.border.color') {
	            $stringReplace = 'sesmaterial.content.bordercolor';
           } elseif($stringReplace == 'sesmaterial.button.background.color') {
	            $stringReplace = 'sesmaterial.button.backgroundcolor';
           } else {
          $stringReplace = str_replace('_', '.', $key);
          }
          $columnVal = $settingsTable->select()
									   ->from($settingsTableName, array('value'))
                    ->where('name = ?', $stringReplace)
                    ->query()
                    ->fetchColumn();
          if($columnVal) {
            if($stringReplace == 'sesmaterial.mainmenu.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesmaterial.mainmenu.backgroundcolor";');

            } elseif($stringReplace == 'sesmaterial.mainmenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesmaterial.mainmenu.linkcolor";');
           } elseif($stringReplace == 'sesmaterial.minimenu.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesmaterial.minimenu.linkcolor";');
           } elseif($stringReplace == 'sesmaterial.font.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesmaterial.fontcolor";');
           } elseif($stringReplace == 'sesmaterial.link.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesmaterial.linkcolor";');
           } elseif($stringReplace == 'sesmaterial.content.border.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesmaterial.content.bordercolor";');
           } elseif($stringReplace == 'sesmaterial.button.background.color') {
	            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "sesmaterial.button.backgroundcolor";');
           }
           else {
		          $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "'.$stringReplace.'";');
	          }
          } else {
            if($stringReplace == 'sesmaterial.mainmenu.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesmaterial.mainmenu.backgroundcolor", "'.$value.'");');
            } elseif($stringReplace == 'sesmaterial.mainmenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesmaterial.mainmenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesmaterial.minimenu.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesmaterial.minimenu.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesmaterial.font.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesmaterial.fontcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesmaterial.link.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesmaterial.linkcolor", "'.$value.'");');
           } elseif($stringReplace == 'sesmaterial.content.border.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesmaterial.content.bordercolor", "'.$value.'");');
           } elseif($stringReplace == 'sesmaterial.button.background.color') {
	            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("sesmaterial.button.backgroundcolor", "'.$value.'");');
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
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmaterial_admin_main', array(), 'sesmaterial_admin_main_menus');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sesmaterial')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_sesmaterial_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'sesmaterial')->getAllSearchOptions();
  }

  public function orderManageSearchAction() {

    if (!$this->getRequest()->isPost())
      return;

    $managesearchoptionsTable = Engine_Api::_()->getDbtable('managesearchoptions', 'sesmaterial');
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
      $item = Engine_Api::_()->getItem('sesmaterial_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesmaterial/settings/manage-search');
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
        $db->update('engine4_sesmaterial_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
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
    $managesearchoptions = Engine_Api::_()->getItem('sesmaterial_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sesmaterial_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sesmaterial_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sesmaterial()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_sesmaterial_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesmaterial', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
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
    $content_id = $this->widgetCheck(array('widget_name' => 'sesmaterial.header', 'page_id' => '1'));

    $minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
    $menulogo = $this->widgetCheck(array('widget_name' => 'core.menu-logo', 'page_id' => '1'));
    $mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
    $mainsearch = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));

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
        if($mainsearch)
            $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$mainsearch.'";');
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesmaterial.header',
            'page_id' => 1,
            'parent_content_id' => $parent_content_id,
            'order' => 20,
        ));
    }
  }

  public function footerWidgetSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    //Footer Default Work
    $footerContent_id = $this->widgetCheck(array('widget_name' => 'sesmaterial.footer', 'page_id' => '2'));
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
            'name' => 'sesmaterial.footer',
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
                        ->where('name = ?', 'sesmaterial_index_sesbackuplandingppage')
                        ->limit(1)
                        ->query()
                        ->fetchColumn();
    if( !$page_id ) {
        $widgetOrder = 1;
        //Insert page
        $db->insert('engine4_core_pages', array(
        'name' => 'sesmaterial_index_sesbackuplandingppage',
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
            'name' => 'sesmaterial.landing-page',
            'page_id' => $page_id,
            'parent_content_id' => $middle_id,
            'order' => $widgetOrder++,
        ));

        $newbakpage_id = $db->select()
                        ->from('engine4_core_pages', 'page_id')
                        ->where('name = ?', 'sesmaterial_index_sesbackuplandingppage')
                        ->limit(1)
                        ->query()
                        ->fetchColumn();
        if($newbakpage_id) {

            $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "'.$newbakpage_id.'";');
            $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "'.$newbakpage_id.'";');

            $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "sesmaterial_index_sesbackuplandingppage";');
            $db->query('UPDATE `engine4_core_pages` SET `name` = "sesmaterial_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
            $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Spectro Media Theme - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sesmaterial_index_sesbackuplandingppage";');
        }
    }
  }

  public function makeSpFile($form) {

    //Start Make extra file for sesmaterial theme custom css
    $themeDirName = APPLICATION_PATH . '/application/themes/sesmaterial';
    @chmod($themeDirName, 0777);
    if (!is_readable($themeDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
      $form->addError($itemError);
      return;
    }
    $fileName = $themeDirName . '/sesmaterial-custom.css';
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
    //Start Make extra file for sesmaterial theme custom css

    //Start Make extra file for sesmaterial constant
    $moduleDirName = APPLICATION_PATH . '/application/modules/Sesmaterial/externals/styles/';
    @chmod($moduleDirName, 0777);
    if (!is_readable($moduleDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $moduleDirName);
      $form->addError($itemError);
      return;
    }
    $fileNameXML = $moduleDirName . '/sesmaterial.xml';
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
    //Start Make extra file for sesmaterial constant
  }
}
