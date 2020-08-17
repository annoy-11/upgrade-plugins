<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSettingsController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_setting');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_setting', array(), 'courses_admin_main_classroom');
    $this->view->form = $form = new Courses_Form_Admin_Classroom_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $values = $form->getValues();
       if (@$values['eclassroom_changelanding']) {
           $this->landingclassroomSet();
        }
         //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = $settings->getSetting('eclassroom.text.singular', 'classroom');
        $oldPluralWord = $settings->getSetting('eclassroom.text.plural', 'classrooms');
        $newSigularWord = $values['eclassroom_text_singular'] ? $values['eclassroom_text_singular'] : 'classroom';
        $newPluralWord = $values['eclassroom_text_plural'] ? $values['eclassroom_text_plural'] : 'classrooms';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if ($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {
            $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/eclassroom.csv', 'null', array('delimiter' => ';', 'enclosure' => '"'));
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
            $targetFile = APPLICATION_PATH . '/application/languages/en/eclassroom.csv';
            if (file_exists($targetFile))
                @unlink($targetFile);

            touch($targetFile);
            chmod($targetFile, 0777);
            $writer = new Engine_Translate_Writer_Csv($targetFile);
            $writer->setTranslations($OutputData);
            $writer->write();
            //END CSV FILE WORK
        }
        $values = $form->getValues();
        $settings = Engine_Api::_()->getApi('settings', 'core');
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
   public function landingclassroomSet() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    //Set Welcomw page as Landing Page and backup of Old Landing Page
    $orlanpage_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'core_index_index')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($orlanpage_id) {
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "9900000" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "9900000" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index_1" WHERE `engine4_core_pages`.`name` = "core_index_index";');
    }
    //New Landing Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'eclassroom_index_sesbackuplandingpclassroom')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {
      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'eclassroom_index_sesbackuplandingpclassroom',
          'displayname' => 'Landing Page',
          'title' => 'Landing Page',
          'description' => 'This is your site\'s landing page.',
          'custom' => 0,
      ));
      $newclassroomlastId = $pageId = $db->lastInsertId();
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
          'name' => 'eclassroom.banner-search',
          'page_id' => $pageId,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"banner_title":"Explore World\u2019s Largest Classroom Directory","description":"Search Classroom from 11,99,389 Awesome Verified Classroom!","height_image":"520","show_criteria":["title","location","category"],"show_carousel":"1","category_carousel_title":"Boost your search with Trending Categories","show_full_width":"yes","title":"","nomobile":"0","name":"eclassroom.banner-search"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'eclassroom.browse-menu',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'eclassroom.featured-sponsored-hot',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"grid","order":"","category_id":"","criteria":"6","info":"most_liked","show_criteria":["title","by","ownerPhoto","category","status","location","contactDetail","likeButton","favouriteButton","followButton","like","comment","favourite","view","follow","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"160","width":"300","limit_data":"8","title":"Verified Classroom","nomobile":"0","name":"eclassroom.featured-sponsored-hot"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"Explore All Verified Classroom Button","data":"<a href=\"\/classroom-directories\/verified\" class=\"eclassroom_link_btn\">Explore All Verified Classroom<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'eclassroom.featured-sponsored-hot',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"horrizontallist","order":"","category_id":"","criteria":"1","info":"favourite_count","show_criteria":["title","by","ownerPhoto","creationDate","category","status","description","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","like","favourite","follow"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"200","width":"250","limit_data":"6","title":"Explore Featured Classroom","nomobile":"0","name":"eclassroom.featured-sponsored-hot"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"View All Featured Classroom Button","data":"<a href=\"\/classroom-directories\/featured\" class=\"eclassroom_link_btn\">View All Featured Classroom<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'eclassroom.featured-sponsored-carousel',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"viewType":"horizontal","order":"","category_id":"","criteria":"5","info":"creation_date","show_criteria":["title","by","ownerPhoto","creationDate","category","status","location","socialSharing","likeButton","favouriteButton","followButton","joinButton","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","imageheight":"235","width":"397","limit_data":"10","title":"Latest Posted Classroom","nomobile":"0","name":"eclassroom.featured-sponsored-carousel"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.html-block',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","adminTitle":"Recent Classroom Button","data":"<a href=\"\/classroom-directories\/browse\" class=\"eclassroom_link_btn\">Find Recent Classroom<\/a>","nomobile":"0","name":"core.html-block"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesbasic.body-class',
          'page_id' => $pageId,
          'parent_content_id' => $mainMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"bodyclass":"eclassroom_welcome_classroom","title":"","nomobile":"0","name":"sesbasic.body-class"}',
      ));
      $newbakclassroom_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'eclassroom_index_sesbackuplandingpclassroom')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakclassroom_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "' . $newbakclassroom_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "' . $newbakclassroom_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "eclassroom_index_sesbackuplandingpclassroom";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "eclassroom_index_sesbackuplandingpage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Advanced Classroom - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "eclassroom_index_sesbackuplandingpage";');
        Engine_Api::_()->getApi('settings', 'core')->setSetting('classroom.changelanding', 1);
      }

    }
  }
  public function createAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_create');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_create', array(), 'courses_admin_main_classcreate');
    $this->view->form = $form = new Courses_Form_Admin_Classroom_classCreation();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $settings = Engine_Api::_()->getApi('settings', 'core');
    //  if ($settings->getSetting('courses.pluginactivated')) {
        //START TEXT CHNAGE WORK IN CSV FILE
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
      //}
    }
  }
 public function rolesAction() {
    $level_id = $this->_getParam('member_roles', 0);
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_clsroles');
    $this->view->form = $form = new Eclassroom_Form_Admin_Classroom_Memberroles();

    $roles = Engine_Api::_()->getDbTable('memberroles', 'eclassroom')->getLevels();
    if (count($roles) > 0) {
      if (!$level_id) {
        $level_id = $roles[0]->memberrole_id;
      }
      $permissions = Engine_Api::_()->getDbTable('memberrolepermissions', 'eclassroom')->getLevels(array('memberrole_id' => $level_id));
      $permissionArray = array();
      if (count($permissions)) {
        foreach ($permissions as $per)
          $permissionArray[] = $per->type;
      }
      if ($form->classroomroles)
        $form->classroomroles->setValue($permissionArray);
    } else {
      $form->removeElement('submit');
    }
    $classroomRole = Engine_Api::_()->getItem('eclassroom_memberrole', $level_id);
    if ($classroomRole) {
      $form->memberrole_id->setValue($classroomRole->getIdentity());
      $form->description->setValue($classroomRole->description);
      $form->active->setValue($classroomRole->active);
    }
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("DELETE FROM engine4_eclassroom_memberrolepermissions WHERE memberrole_id =" . $level_id);
      $values = $form->getValues();
      $classroomRole->description = $values['description'];
      $classroomRole->active = $values['active'];
      $classroomRole->save();
      foreach ($values['classroomroles'] as $value) {
        $table = Engine_Api::_()->getDbTable('memberrolepermissions', 'eclassroom');
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
  public function rolesCreateAction() {
    $id = $this->_getParam('id', 0);
    if ($id) {
      $role = Engine_Api()->getItem('eclassroom_memberrole', $id);
    }
    $this->view->form = $form = new Eclassroom_Form_Admin_Classroom_Creatememberrole();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $table = Engine_Api::_()->getDbTable('memberroles', 'eclassroom');
      $role = $table->createRow();
      $values = $form->getValues();
      $values['user_id'] = $this->view->viewer()->getIdentity();
      $values['creation_date'] = date('Y-m-d H:i:s');
      $role->setFromArray($values);
      $role->save();

      return $this->_forward('success', 'utility', 'core', array(
        'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'eclassroom', 'controller' => 'settings', 'action' => 'roles', 'member_roles' => $role->getIdentity()), 'admin_default', true),
        'messages' => array('Classroom Role created successfully.')
      ));
    }
  }
  public function manageWidgetizeAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_wgtzpage');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_wgtzpage', array(), 'courses_admin_main_clspages');
    $classroomArray = array('eclassroom_index_browse','eclassroom_index_home','eclassroom_index_create','eclassroom_profile_index_1','eclassroom_profile_index_2','eclassroom_profile_index_3','eclassroom_profile_index_4','eclassroom_album_home','eclassroom_album_browse','eclassroom_album_view','eclassroom_photo_view','eclassroom_category_browse','eclassroom_category_index','eclassroom_index_claim','eclassroom_index_claim-requests','eclassroom_review_view','eclassroom_index_tags','eclassroom_index_browse-locations','eclassroom_index_verified','eclassroom_index_featured','eclassroom_index_sponsored','eclassroom_index_hot','courses_manage_classroom-reviews','eclassroom_index_manage');
    $this->view->classroomArray = $classroomArray;
  }
  public function manageDashboardsAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_dshbrd');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_dshbrd', array(), 'courses_admin_main_clsdshbrd');
    $this->view->paginator = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems();
  }
  public function enabledAction() {

    $id = $this->_getParam('dashboard_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('eclasroom_dashboard', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/eclassroom/settings/manage-dashboards');
  }
 public function editDashboardsSettingsAction() {
    $dashboards = Engine_Api::_()->getItem('eclassroom_dashboard', $this->_getParam('dashboard_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Courses_Form_Admin_EditDashboard();
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
      $this->_redirect('admin/eclassroom/settings/manage-dashboards');
    }
  }
  public function statisticAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_sts');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_sts', array(), 'courses_admin_main_clssts');

    $classroomTable = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
    $classroomTableName = $classroomTable->info('name');

    //Total classrooms
    $this->view->totalclass = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalclass')->query()->fetchColumn();

    //Total approved class
    $this->view->totalapprovedclass = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalapprovedclassroom')->where('is_approved =?', 1)->query()->fetchColumn();

    //Total verified classroom
    $this->view->totalclassroomverified = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalverified')->where('verified =?', 1)->query()->fetchColumn();

    //Total featured classroom
    $this->view->totalclassroomfeatured = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalfeatured')->where('featured =?', 1)->query()->fetchColumn();

    //Total sponsored classroom
    $this->view->totalclassroomsponsored = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalsponsored')->where('sponsored =?', 1)->query()->fetchColumn();

    //Total hot classroom
    $this->view->totalclassroomhot = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalhot')->where('hot =?', 1)->query()->fetchColumn();

    //Total favourite classroom
    $this->view->totalclassroomfavourite = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalfavourite')->where('favourite_count <>?', 0)->query()->fetchColumn();

    //Total comments classroom
    $this->view->totalclassroomcomments = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalcomment')->where('comment_count <>?', 0)->query()->fetchColumn();

    //Total view classroom
    $this->view->totalclassroomviews = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalview')->where('view_count <>?', 0)->query()->fetchColumn();

    //Total like classroom
    $this->view->totalclassroomlikes = $classroomTable->select()->from($classroomTableName, 'count(*) AS totallike')->where('like_count <>?', 0)->query()->fetchColumn();

    //Total follow classroom
    $this->view->totalclassroomfollowers = $classroomTable->select()->from($classroomTableName, 'count(*) AS totalfollow')->where('follow_count <>?', 0)->query()->fetchColumn();
  }
}
