<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_settings');

    $this->view->form = $form = new Seslinkedin_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Seslinkedin/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.pluginactivated')) {

        if (@$values['seslinkedin_changelanding']) {
          $this->landingpageSet();
        }
        if($values['seslinkedin_header_fixed_layout'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_header_fixed_layout', $values['seslinkedin_header_fixed_layout']);

        //Here we have set the value of theme active.
        $themeactive = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.themeactive');
        if (empty($themeactive)) {

            $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('seslinkedin', 'Professional Linkedin Clone', '', 0)");
            $themeName = 'seslinkedin';
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
            Engine_Api::_()->getApi('settings', 'core')->setSetting('seslinkedin.themeactive', 1);
        }

		//Start Make extra file for ariana theme custom css
        $themeDirName = APPLICATION_PATH . '/application/themes/seslinkedin';
        @chmod($themeDirName, 0777);
        if (!is_readable($themeDirName)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
          $form->addError($itemError);
          return;
        }
        $fileName = $themeDirName . '/seslinkedin-custom.css';
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

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_styling');

    $this->view->customtheme_id = $this->_getParam('customtheme_id', null);

    $this->view->form = $form = new Seslinkedin_Form_Admin_Styling();

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
          Engine_Api::_()->seslinkedin()->readWriteXML($key, $value, '');
        }

        if ((isset($_POST['submit']) || isset($_POST['save'])) && $values['custom_theme_color'] > '3') {
          if ($values['custom_theme_color'] > '3') {
            $description = serialize($values);
            $db->query("UPDATE `engine4_seslinkedin_customthemes` SET `description` = '".$description."' WHERE `engine4_seslinkedin_customthemes`.`customtheme_id` = '".$values['custom_theme_color']."'");
          }
        }

        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($key == 'seslinkedin_button_background_color') {
            $stringReplace = 'seslinkedin.button.backgroundcolor';
          }
          if($key == 'seslinkedin_font_color') {
            $stringReplace = 'seslinkedin.fontcolor';
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
        $this->_helper->redirector->gotoRoute(array('module' => 'seslinkedin', 'controller' => 'settings', 'action' => 'styling'),'admin_default',true);
      } else if($values['theme_color'] == 5 && $values['custom_theme_color'] > 3) {
        $this->_helper->redirector->gotoRoute(array('module' => 'seslinkedin', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $values['custom_theme_color']),'admin_default',true);
      }
    }
    $this->view->activatedTheme = Engine_Api::_()->seslinkedin()->getContantValueXML('custom_theme_color');
  }

  //Get Custom theme color values
  public function getcustomthemecolorsAction() {

    $customtheme_id = $this->_getParam('customtheme_id', 22);
    if(empty($customtheme_id))
      return;
    $customthemeItem = Engine_Api::_()->getItem('seslinkedin_customthemes', $customtheme_id);
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
    $this->view->form = $form = new Seslinkedin_Form_Admin_CustomTheme();
    if ($customtheme_id) {
      $form->setTitle("Edit Custom Theme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme = Engine_Api::_()->getItem('seslinkedin_customthemes', $customtheme_id);
      $form->populate($customtheme->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('customthemes', 'seslinkedin')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('customthemes', 'seslinkedin');
        $values = $form->getValues();

        if(!$customtheme_id)
          $customtheme = $table->createRow();
        $customtheme->setFromArray($values);
        $customtheme->save();

        if(!empty($values['customthemeid'])) {
          $customthemeItem = Engine_Api::_()->getItem('seslinkedin_customthemes', $values['customthemeid']);
          $description = unserialize($customthemeItem->description);
          $finalDescription = serialize(array_merge($description, array('custom_theme_color' => $customtheme->customtheme_id)));
          $customtheme->description = $finalDescription;
          $customtheme->save();
        }
        $db->commit();
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seslinkedin', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $customtheme->customtheme_id),'admin_default',true),
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
        $slideImage = Engine_Api::_()->getItem('seslinkedin_customthemes', $customtheme_id);
        $slideImage->delete();
        $db->commit();
        $activatedTheme = Engine_Api::_()->seslinkedin()->getContantValueXML('custom_theme_color');
        $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seslinkedin', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $activatedTheme),'admin_default',true),
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
            ->where('name = ?', 'seslinkedin_index_sesbackuplandingppage')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {

      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'seslinkedin_index_sesbackuplandingppage',
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
          'name' => 'seslinkedin.landing-page',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"leftsideimage":"application\/modules\/Seslinkedin\/externals\/images\/intro-bg.png","heading":"Welcome to the largest network for professionals","search":"1","title":"","nomobile":"0","name":"seslinkedin.landing-page"}',
      ));

     $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'seslinkedin.landing-page-features',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"heading":"How it works","fe1img":"application\/modules\/Seslinkedin\/externals\/images\/step-1.png","fe1heading":"Create An Account","fe1description":"Get started by adding your academic details, experiences & skills you have.","fe2img":"application\/modules\/Seslinkedin\/externals\/images\/step-2.png","fe2heading":"Search Jobs","fe2description":"Search millions of jobs online to find the next step in your career.","fe3img":"application\/modules\/Seslinkedin\/externals\/images\/step-3.png","fe3heading":"Save & Apply","fe3description":" Apply for the posted Jobs that best matches your skills & accomplishments.","title":"","nomobile":"0","name":"seslinkedin.landing-page-features"}',
      ));

      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesjob.browse-jobs',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["likeButton","socialSharing","title","companyname","industry","expiredLabel","readmore","creationDate","location","descriptionlist"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","category":"0","sort":"recentlySPcreated","show_item_count":"0","title_truncation_list":"45","title_truncation_grid":"45","description_truncation_list":"45","description_truncation_grid":"45","height_list":"100","width_list":"130","height_grid":"270","width_grid":"389","width_grid_photo":"260","limit_data_grid":"20","limit_data_list":"3","pagging":"button","title":"Recent Jobs","nomobile":"0","name":"sesjob.browse-jobs"}',
      ));

      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'seslinkedin.landing-page-categories',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"heading":"Find jobs that best suits your skills.","title":"","nomobile":"0","name":"seslinkedin.landing-page-categories"}',
      ));

       $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'seslinkedin.landing-page-post-job',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"heading":"Post your job & connect with the best candidates","buttonText":"Post a job","buttonUrl":"http:\/\/linkedinclone.socialenginesolutions.com\/jobs\/create","image":"application\/modules\/Seslinkedin\/externals\/images\/lp_job.png","title":"","nomobile":"0","name":"seslinkedin.landing-page-post-job"}',
      ));

        $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'seslinkedin.landing-page-members-jobs',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"fe1img":"application\/modules\/Seslinkedin\/externals\/images\/people-talking.png","fe1heading":"Build your network with professionals    ","fe1buttonText":"Find People You Know","fe1buttonUrl":"http:\/\/linkedinclone.socialenginesolutions.com\/members","fe2img":"application\/modules\/Seslinkedin\/externals\/images\/working-men.png","fe2heading":"Find the Jobs you love to work","fe2buttonText":"Find Jobs You Love","fe2buttonUrl":"http:\/\/localhost\/mydirectory\/jobs","title":"","nomobile":"0","name":"seslinkedin.landing-page-members-jobs"}',
      ));

        $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'seslinkedin.landing-page-video',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"Common Interview Questions","description":"Every interviewer is different and each one\u2019s questions may vary. So be ready!","video_type":"embed","video":"0","embedCode":"<iframe width=\"560\" height=\"315\" src=\"https:\/\/www.youtube.com\/embed\/1mHjMNZZvFo\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen><\/iframe>","nomobile":"0","name":"seslinkedin.landing-page-video"}',
      ));

     $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'seslinkedin.landing-page-bottom-banner',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"image":"application\/modules\/Seslinkedin\/externals\/images\/footer-banner.png","heading":"2,231,489+ networks have been built among professionals here!","buttonText":"Get Started","buttonUrl":"\/signup","title":"","nomobile":"0","name":"seslinkedin.landing-page-bottom-banner"}',
      ));

      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'seslinkedin_index_sesbackuplandingppage')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "seslinkedin_index_sesbackuplandingppage";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "seslinkedin_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Professional Linkedin Clone - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "seslinkedin_index_sesbackuplandingppage";');
      }
    }
  }

  public function uploadDashboardIcons() {

    $paginator = Engine_Api::_()->getDbTable('dashboardlinks', 'seslinkedin')->getInfo(array('sublink' => 1, 'enabled' => 1));
    foreach($paginator as $dashboardlinks) {

      $dashIcons = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Seslinkedin' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "icons" . DIRECTORY_SEPARATOR . $dashboardlinks->name.'.png';

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

   public function manageSearchAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_search');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'seslinkedin')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_seslinkedin_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'seslinkedin')->getAllSearchOptions();
  }
   public function enabledAction() {

    $id = $this->_getParam('managesearchoption_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seslinkedin_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/seslinkedin/settings/manage-search');
  }

    public function editSearchAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id', null);

    $type = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $managesearchoptions = Engine_Api::_()->getItem('seslinkedin_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_seslinkedin_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Seslinkedin_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->seslinkedin()->setPhotoIcons($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_seslinkedin_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seslinkedin', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
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
        $db->update('engine4_seslinkedin_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
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
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_typography');

    $this->view->form = $form = new Seslinkedin_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['seslinkedin_body']);
      unset($values['seslinkedin_heading']);
      unset($values['seslinkedin_mainmenu']);
      unset($values['seslinkedin_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['seslinkedin_googlefonts']) {
            unset($values['seslinkedin_body_fontfamily']);
            unset($values['seslinkedin_heading_fontfamily']);
            unset($values['seslinkedin_mainmenu_fontfamily']);
            unset($values['seslinkedin_tab_fontfamily']);

            unset($values['seslinkedin_body_fontsize']);
            unset($values['seslinkedin_heading_fontsize']);
            unset($values['seslinkedin_mainmenu_fontsize']);
            unset($values['seslinkedin_tab_fontsize']);

            if($values['seslinkedin_googlebody_fontfamily'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_body_fontfamily', $values['seslinkedin_googlebody_fontfamily']);

            if($values['seslinkedin_googlebody_fontsize'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_body_fontsize', $values['seslinkedin_googlebody_fontsize']);

            if($values['seslinkedin_googleheading_fontfamily'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_heading_fontfamily', $values['seslinkedin_googleheading_fontfamily']);

            if($values['seslinkedin_googleheading_fontsize'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_heading_fontsize', $values['seslinkedin_googleheading_fontsize']);

            if($values['seslinkedin_googlemainmenu_fontfamily'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_mainmenu_fontfamily', $values['seslinkedin_googlemainmenu_fontfamily']);

            if($values['seslinkedin_googlemainmenu_fontsize'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_mainmenu_fontsize', $values['seslinkedin_googlemainmenu_fontsize']);

            if($values['seslinkedin_googletab_fontfamily'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_tab_fontfamily', $values['seslinkedin_googletab_fontfamily']);

            if($values['seslinkedin_googletab_fontsize'])
              Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_tab_fontsize', $values['seslinkedin_googletab_fontsize']);

            //Engine_Api::_()->seslinkedin()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['seslinkedin_googlebody_fontfamily']);
            unset($values['seslinkedin_googleheading_fontfamily']);
            unset($values['seslinkedin_googleheading_fontfamily']);
            unset($values['seslinkedin_googletab_fontfamily']);

            unset($values['seslinkedin_googlebody_fontsize']);
            unset($values['seslinkedin_googleheading_fontsize']);
            unset($values['seslinkedin_googlemainmenu_fontsize']);
            unset($values['seslinkedin_googletab_fontsize']);

            Engine_Api::_()->seslinkedin()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

}
