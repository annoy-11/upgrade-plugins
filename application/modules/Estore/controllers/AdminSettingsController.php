<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_setting');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_setting', array(), 'estore_admin_main_storesetting');

    $this->view->form = $form = new Estore_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      if (@$values['estore_changelanding']) {
        $this->landingstoreSet();
      }
      include_once APPLICATION_PATH . "/application/modules/Estore/controllers/License.php";
      $settings = Engine_Api::_()->getApi('settings', 'core');
      if ($settings->getSetting('estore.pluginactivated')) {
        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = $settings->getSetting('estore.text.singular', 'stores');
        $oldPluralWord = $settings->getSetting('estore.text.plural', 'stores');
        $newSigularWord = $values['estore_text_singular'] ? $values['estore_text_singular'] : 'stores';
        $newPluralWord = $values['estore_text_plural'] ? $values['estore_text_plural'] : 'stores';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if ($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/estore.csv', 'null', array('delimiter' => ';', 'enclosure' => '"'));
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

          $targetFile = APPLICATION_PATH . '/application/languages/en/estore.csv';
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
          if($settings->hasSetting($key, $value))
          $settings->removeSetting($key);
          if(!$value && strlen($value) == 0)
          continue;
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if (@$error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function storecreateAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_create');
     $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_create', array(), 'estore_admin_main_storecreate');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Estore_Form_Admin_CreateStoreSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      foreach ($values as $key => $value) {
        $settings->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function levelAction() {
     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_level');
     $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_level', array(), 'estore_admin_main_storelevel');
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
    $this->view->form = $form = new Estore_Form_Admin_Settings_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($level_id);
    $permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
    $valuesForm = $permissionsTable->getAllowed('stores', $level_id, array_keys($form->getValues()));

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
      $permissionsTable->setAllowed('stores', $level_id, $values, '', $nonBooleanSettings);
      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }

  public function manageDashboardsAction() {

     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_dashboards');
     $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_dashboards', array(), 'estore_admin_main_storedashboards');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems();
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('dashboard_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('estore_dashboards', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/estore/settings/manage-dashboards');
  }

  public function editDashboardsSettingsAction() {

    $dashboards = Engine_Api::_()->getItem('estore_dashboards', $this->_getParam('dashboard_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Estore_Form_Admin_EditDashboard();
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
      $this->_redirect('admin/estore/settings/manage-dashboards');
    }
  }

  public function statisticAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_statistics');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_statistics', array(), 'estore_admin_main_storestatistics');

    $storeTable = Engine_Api::_()->getDbTable('stores', 'estore');
    $storeTableName = $storeTable->info('name');

    //Total stores
    $this->view->totalstore = $storeTable->select()->from($storeTableName, 'count(*) AS totalstore')->query()->fetchColumn();

    //Total approved store
    $this->view->totalapprovedstore = $storeTable->select()->from($storeTableName, 'count(*) AS totalapprovedstore')->where('is_approved =?', 1)->query()->fetchColumn();

    //Total verified store
    $this->view->totalstoreverified = $storeTable->select()->from($storeTableName, 'count(*) AS totalverified')->where('verified =?', 1)->query()->fetchColumn();

    //Total featured store
    $this->view->totalstorefeatured = $storeTable->select()->from($storeTableName, 'count(*) AS totalfeatured')->where('featured =?', 1)->query()->fetchColumn();

    //Total sponsored store
    $this->view->totalstoresponsored = $storeTable->select()->from($storeTableName, 'count(*) AS totalsponsored')->where('sponsored =?', 1)->query()->fetchColumn();

    //Total hot store
    $this->view->totalstorehot = $storeTable->select()->from($storeTableName, 'count(*) AS totalhot')->where('hot =?', 1)->query()->fetchColumn();

    //Total favourite store
    $this->view->totalstorefavourite = $storeTable->select()->from($storeTableName, 'count(*) AS totalfavourite')->where('favourite_count <>?', 0)->query()->fetchColumn();

    //Total comments store
    $this->view->totalstorecomments = $storeTable->select()->from($storeTableName, 'count(*) AS totalcomment')->where('comment_count <>?', 0)->query()->fetchColumn();

    //Total view store
    $this->view->totalstoreviews = $storeTable->select()->from($storeTableName, 'count(*) AS totalview')->where('view_count <>?', 0)->query()->fetchColumn();

    //Total like store
    $this->view->totalstorelikes = $storeTable->select()->from($storeTableName, 'count(*) AS totallike')->where('like_count <>?', 0)->query()->fetchColumn();

    //Total follow store
    $this->view->totalstorefollowers = $storeTable->select()->from($storeTableName, 'count(*) AS totalfollow')->where('follow_count <>?', 0)->query()->fetchColumn();
  }

  public function manageWidgetizePageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_widgetizepage');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_widgetizepage', array(), 'estore_admin_main_storewidgetizepage');

    $storesArray = array(
        'estore_index_welcome',
        'estore_index_home',
        'estore_index_browse',
        'estore_index_browse-locations',
        'estore_index_tags',
        'estore_index_manage',
        'estore_category_browse',
        'estore_category_index',
        'estore_index_create',
        'estore_profile_index_1',
        'estore_profile_index_2',
        'estore_profile_index_3',
        'estore_profile_index_4',
        'estore_album_home',
        'estore_album_browse',
        'estore_album_view',
        'estore_photo_view',
        'estore_index_claim-requests',
        'estore_index_claim'
    );
    $this->view->storesArray = $storesArray;
  }

  public function storeRolesAction() {
    $level_id = $this->_getParam('member_roles', 0);
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_storeroles');
    $this->view->form = $form = new Estore_Form_Admin_Memberroles();

    $roles = Engine_Api::_()->getDbTable('memberroles', 'estore')->getLevels();
    if (count($roles) > 0) {
      if (!$level_id) {
        $level_id = $roles[0]->memberrole_id;
      }
      $permissions = Engine_Api::_()->getDbTable('memberrolepermissions', 'estore')->getLevels(array('memberrole_id' => $level_id));
      $permissionArray = array();
      if (count($permissions)) {
        foreach ($permissions as $per)
          $permissionArray[] = $per->type;
      }
      if ($form->storeroles)
        $form->storeroles->setValue($permissionArray);
    } else {
      $form->removeElement('submit');
    }
    $storeRole = Engine_Api::_()->getItem('estore_memberrole', $level_id);
    if ($storeRole) {
      $form->memberrole_id->setValue($storeRole->getIdentity());
      $form->description->setValue($storeRole->description);
      $form->active->setValue($storeRole->active);
    }
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("DELETE FROM engine4_estore_memberrolepermissions WHERE memberrole_id =" . $level_id);
      $values = $form->getValues();
      $storeRole->description = $values['description'];
      $storeRole->active = $values['active'];
      $storeRole->save();
      foreach ($values['storeroles'] as $value) {
        $table = Engine_Api::_()->getDbTable('memberrolepermissions', 'estore');
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

  public function storeRolesCreateAction() {
    $id = $this->_getParam('id', 0);
    if ($id) {
      $role = Engine_Api()->getItem('estore_memberrole', $id);
    }
    $this->view->form = $form = new Estore_Form_Admin_Creatememberrole();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $table = Engine_Api::_()->getDbTable('memberroles', 'estore');
      $role = $table->createRow();
      $values = $form->getValues();
      $values['user_id'] = $this->view->viewer()->getIdentity();
      $values['creation_date'] = date('Y-m-d H:i:s');
      $role->setFromArray($values);
      $role->save();

      return $this->_forward('success', 'utility', 'core', array(
        'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'estore', 'controller' => 'settings', 'action' => 'store-roles', 'member_roles' => $role->getIdentity()), 'admin_default', true),
        'messages' => array('Store Role created successfully.')
      ));
    }
  }
  public function supportAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main');
  }

  public function landingstoreSet() {

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
            ->where('name = ?', 'estore_index_sesbackuplandingpstore')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {
      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'estore_index_sesbackuplandingpstore',
          'displayname' => 'Landing Page',
          'title' => 'Landing Page',
          'description' => 'This is your site\'s landing page.',
          'custom' => 0,
      ));
      $newstorelastId = $pageId = $db->lastInsertId();
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
          'name' => 'estore.banner-search',
          'page_id' => $pageId,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"banner_title":"Explore World\u2019s Largest Store Directory","description":"Search Stores from 11,99,389 Awesome Verified Stores!","height_image":"520","show_criteria":["title","location","category"],"show_carousel":"1","category_carousel_title":"Boost your search with Trending Categories","show_full_width":"yes","title":"","nomobile":"0","name":"estore.banner-search"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'estore.browse-menu',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'estore.featured-sponsored-hot',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"grid","order":"","category_id":"","criteria":"6","info":"most_liked","show_criteria":["title","by","ownerPhoto","category","status","location","contactDetail","likeButton","favouriteButton","followButton","like","comment","favourite","view","follow","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"160","width":"300","limit_data":"8","title":"Verified Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"Explore All Verified Stores Button","data":"<a href=\"\/store-directories\/verified\" class=\"estore_link_btn\">Explore All Verified Stores<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'estore.featured-sponsored-hot',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"horrizontallist","order":"","category_id":"","criteria":"1","info":"favourite_count","show_criteria":["title","by","ownerPhoto","creationDate","category","status","description","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","like","favourite","follow"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"200","width":"250","limit_data":"6","title":"Explore Featured Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"View All Featured Stores Button","data":"<a href=\"\/store-directories\/featured\" class=\"estore_link_btn\">View All Featured Stores<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'estore.featured-sponsored-carousel',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"horizontal","order":"","category_id":"","criteria":"5","info":"creation_date","show_criteria":["title","by","ownerPhoto","creationDate","category","status","location","socialSharing","likeButton","favouriteButton","followButton","joinButton","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","imageheight":"235","width":"397","limit_data":"10","title":"Latest Posted Stores","nomobile":"0","name":"estore.featured-sponsored-carousel"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"Recent Stores Button","data":"<a href=\"\/store-directories\/browse\" class=\"estore_link_btn\">Find Recent Stores<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesbasic.body-class',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"bodyclass":"estore_welcome_store","title":"","nomobile":"0","name":"sesbasic.body-class"}',
      ));
      $newbakstore_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'estore_index_sesbackuplandingpstore')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakstore_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "' . $newbakstore_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "' . $newbakstore_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "estore_index_sesbackuplandingpstore";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "estore_index_sesbackuplandingpage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Advanced Store - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "estore_index_sesbackuplandingpage";');
      }
    }
  }
}
