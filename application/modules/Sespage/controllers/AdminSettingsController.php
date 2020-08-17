<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_setting');
    $this->view->form = $form = new Sespage_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      if (@$values['sespage_changelanding']) {
        $this->landingpageSet();
      }
      include_once APPLICATION_PATH . "/application/modules/Sespage/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.pluginactivated')) {
        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.text.singular', 'page');
        $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.text.plural', 'pages');
        $newSigularWord = @$values['sespage_text_singular'] ? @$values['sespage_text_singular'] : 'page';
        $newPluralWord = @$values['sespage_text_plural'] ? @$values['sespage_text_plural'] : 'pages';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if ($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sespage.csv', 'null', array('delimiter' => ';', 'enclosure' => '"'));
          if (!empty($tmp['null']) && is_array($tmp['null']))
            $inputData = $tmp['null'];
          else
            $inputData = array();

          $OutputData = array();
          $chnagedData = array();
          foreach ($inputData as $key => $input) {
            $chnagedData = str_replace(array($oldPluralWord, $oldSigularWord, ucfirst($oldPluralWord), ucfirst($oldSigularWord), strtoupper($oldPluralWord), strtoupper($oldSigularWord)), array($newPluralWord, $newSigularWord, ucfirst($newPluralWord), ucfirst($newSigularWord), strtoupper($newPluralWord), strtoupper($newSigularWord)), $input);
            $OutputData[$key] = $chnagedData;
          }

          $targetFile = APPLICATION_PATH . '/application/languages/en/sespage.csv';
          if (file_exists($targetFile))
            @unlink($targetFile);

          touch($targetFile);
          chmod($targetFile, 0777);

          $writer = new Engine_Translate_Writer_Csv($targetFile);
          $writer->setTranslations($OutputData);
          $writer->write();
          //END CSV FILE WORK
        }
        foreach ($values as $key => $value) {
          if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
          Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
          if(!$value && strlen($value) == 0)
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if (@$error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function pagecreateAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_pagecreate');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sespage_Form_Admin_CreatePageSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function levelAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_level');

    // Get level id
    if (null !== ($id = $this->_getParam('id'))) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }
    if (!$level instanceof Authorization_Model_Level) {
      throw new Engine_Exception('missing level');
    }
    $level_id = $id = $level->level_id;
    // Make form
    $this->view->form = $form = new Sespage_Form_Admin_Settings_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($level_id);
    $permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
    $valuesForm = $permissionsTable->getAllowed('sespage_page', $level_id, array_keys($form->getValues()));

    $form->populate($valuesForm);
    if ($form->defattribut)
      $form->defattribut->setValue(0);
    if (!$this->getRequest()->isPost()) {
      return;
    }
    // Check validitiy
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    // Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      if ($level->type != 'public') {
        // Set permissions
        $values['auth_comment'] = (array) $values['auth_comment'];
        $values['auth_view'] = (array) $values['auth_view'];
      }
      $nonBooleanSettings = $form->nonBooleanFields();
      $permissionsTable->setAllowed('sespage_page', $level_id, $values, '', $nonBooleanSettings);
      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }

  public function manageDashboardsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_managedashboards');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems();
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('dashboard_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sespage_dashboards', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sespage/settings/manage-dashboards');
  }

  public function editDashboardsSettingsAction() {

    $dashboards = Engine_Api::_()->getItem('sespage_dashboards', $this->_getParam('dashboard_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sespage_Form_Admin_EditDashboard();
    $form->setTitle('Edit This Item');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('dashboard_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($dashboards->toArray());

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $dashboards->title = $values["title"];
        $dashboards->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully edit entry.')
      ));
      $this->_redirect('admin/sespage/settings/manage-dashboards');
    }
  }

    public function extensionsAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_extension');
    }

  public function statisticAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_statistics');

    $pageTable = Engine_Api::_()->getDbTable('pages', 'sespage');
    $pageTableName = $pageTable->info('name');

    //Total pages
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalpage');
    $this->view->totalpage = $select->query()->fetchColumn();

    //Total approved page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalapprovedpage')->where('is_approved =?', 1);
    $this->view->totalapprovedpage = $select->query()->fetchColumn();

    //Total verified page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalverified')->where('verified =?', 1);
    $this->view->totalpageverified = $select->query()->fetchColumn();

    //Total featured page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalfeatured')->where('featured =?', 1);
    $this->view->totalpagefeatured = $select->query()->fetchColumn();

    //Total sponsored page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalsponsored')->where('sponsored =?', 1);
    $this->view->totalpagesponsored = $select->query()->fetchColumn();

    //Total hot page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalhot')->where('hot =?', 1);
    $this->view->totalpagehot = $select->query()->fetchColumn();

    //Total favourite page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalfavourite')->where('favourite_count <>?', 0);
    $this->view->totalpagefavourite = $select->query()->fetchColumn();

    //Total comments page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalcomment')->where('comment_count <>?', 0);
    $this->view->totalpagecomments = $select->query()->fetchColumn();

    //Total view page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalview')->where('view_count <>?', 0);
    $this->view->totalpageviews = $select->query()->fetchColumn();

    //Total like page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totallike')->where('like_count <>?', 0);
    $this->view->totalpagelikes = $select->query()->fetchColumn();

    //Total follow page
    $select = $pageTable->select()->from($pageTableName, 'count(*) AS totalfollow')->where('follow_count <>?', 0);
    $this->view->totalpagefollowers = $select->query()->fetchColumn();
  }

  public function manageWidgetizePageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_managewidgetizepage');

    $pagesArray = array(
        'sespage_index_welcome',
        'sespage_index_home',
        'sespage_index_browse',
        'sespage_index_browse-locations',
        'sespage_index_tags',
        'sespage_index_manage',
        'sespage_category_browse',
        'sespage_category_index',
        'sespage_index_create',
        'sespage_profile_index_1',
        'sespage_profile_index_2',
        'sespage_profile_index_3',
        'sespage_profile_index_4',
        'sespage_album_home',
        'sespage_album_browse',
        'sespage_album_view',
        'sespage_photo_view',
        'sespage_index_claim-requests',
        'sespage_index_claim'
    );
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagereview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.pluginactivated')) {
      $pagesArray = array_merge($pagesArray,array('sespagereview_review_home','sespagereview_review_browse'));
    }
    $this->view->pagesArray = $pagesArray;
  }

  // for default installation
  function setCategoryPhoto($file, $cat_id, $resize = false, $media = false) {
    $fileName = $file;
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    if ($media) {
      $resourceType = 'sespage_category';
      $width = $height = 1600;
    } else {
      $resourceType = 'sespage_media';
      $width = $height = 800;
    }
    $params = array(
        'parent_type' => $resourceType,
        'parent_id' => $cat_id,
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => $name,
    );

    // Save
    $filesTable = Engine_Api::_()->getDbTable('files', 'storage');
    if ($resize) {
      // Resize image (main)
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize($height, $width)
              ->write($mainPath)
              ->destroy();

      // Resize image (normal) make same image for activity feed so it open in pop up with out jump effect.
      $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_thumb.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(500, 500)
              ->write($normalPath)
              ->destroy();
    } else {
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      copy($file, $mainPath);
    }
    if ($resize) {
      // normal main  image resize
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(100, 100)
              ->write($normalMainPath)
              ->destroy();
    } else {
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      copy($file, $normalMainPath);
    }
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
      if ($resize) {
        $iIconNormal = $filesTable->createFile($normalPath, $params);
        $iMain->bridge($iIconNormal, 'thumb.thumb');
      }
      $iNormalMain = $filesTable->createFile($normalMainPath, $params);
      $iMain->bridge($iNormalMain, 'thumb.icon');
    } catch (Exception $e) {
      die;
      // Remove temp files
      @unlink($mainPath);
      if ($resize) {
        @unlink($normalPath);
      }
      @unlink($normalMainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Sesevent_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    if ($resize) {
      @unlink($normalPath);
    }
    @unlink($normalMainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }

  public function pageRolesAction() {
    $level_id = $this->_getParam('member_roles', 0);
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_pageroles');
    $this->view->form = $form = new Sespage_Form_Admin_Memberroles();

    $roles = Engine_Api::_()->getDbTable('memberroles', 'sespage')->getLevels();
    if (count($roles) > 0) {
      if (!$level_id) {
        $level_id = $roles[0]->memberrole_id;
      }
      $permissions = Engine_Api::_()->getDbTable('memberrolepermissions', 'sespage')->getLevels(array('memberrole_id' => $level_id));
      $permissionArray = array();
      if (count($permissions)) {
        foreach ($permissions as $per)
          $permissionArray[] = $per->type;
      }
      if ($form->pageroles)
        $form->pageroles->setValue($permissionArray);
    } else {
      $form->removeElement('submit');
    }

    $pageRole = Engine_Api::_()->getItem('sespage_memberrole', $level_id);
    if ($pageRole) {
      $form->memberrole_id->setValue($pageRole->getIdentity());
      $form->description->setValue($pageRole->description);
      $form->active->setValue($pageRole->active);
    }
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("DELETE FROM engine4_sespage_memberrolepermissions WHERE memberrole_id =" . $level_id);
      $values = $form->getValues();
      $pageRole->description = $values['description'];
      $pageRole->active = $values['active'];
      $pageRole->save();
      foreach ($values['pageroles'] as $value) {
        $table = Engine_Api::_()->getDbTable('memberrolepermissions', 'sespage');
        $role = $table->createRow();
        $valuesRole['memberrole_id'] = $level_id;
        $valuesRole['type'] = $value;
        $valuesRole['value'] = 1;
        $role->setFromArray($valuesRole);
        $role->save();
      }
      $form->addNotice('Your changes have been saved.');
    }
  }

  public function pageRolesCreateAction() {
    $id = $this->_getParam('id', 0);
    if ($id) {
      $role = Engine_Api()->getItem('sespage_memberrole', $id);
    }
    $this->view->form = $form = new Sespage_Form_Admin_Creatememberrole();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $table = Engine_Api::_()->getDbTable('memberroles', 'sespage');
      $role = $table->createRow();
      $values = $form->getValues();
      $values['user_id'] = $this->view->viewer()->getIdentity();
      $values['creation_date'] = date('Y-m-d H:i:s');
      $role->setFromArray($values);
      $role->save();

      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespage', 'controller' => 'settings', 'action' => 'page-roles', 'member_roles' => $role->getIdentity()), 'admin_default', true),
                  'messages' => array('Page Role created successfully.')
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

}
