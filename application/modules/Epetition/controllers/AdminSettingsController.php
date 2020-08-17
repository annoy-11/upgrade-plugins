<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSettingsController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_settings');

    $this->view->form = $form = new Epetition_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {

      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Epetition/controllers/License.php";

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.pluginactivated')) {

        //Start Landing page set
        if (isset($_POST['epetition_changelanding']) && $_POST['epetition_changelanding'] == 1) {
          $this->landingPageSetup();
        }
        //End Landing Page set

        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.text.singular', 'petition');
        $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.text.plural', 'petitions');
        $newSigularWord = @$values['epetition_text_singular'] ? @$values['epetition_text_singular'] : 'petition';
        $newPluralWord = @$values['epetition_text_plural'] ? @$values['epetition_text_plural'] : 'petitions';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if ($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/epetition.csv', 'null', array('delimiter' => ';', 'enclosure' => '"'));
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

          $targetFile = APPLICATION_PATH . '/application/languages/en/epetition.csv';
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
          if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
            Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
          if (!$value && strlen($value) == 0)
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  
  public function enabledAction() {

    $id = $this->_getParam('dashboard_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('epetition_dashboards', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/epetition/settings/manage-dashboards');
  }

  public function editDashboardsSettingsAction() {

    $dashboards = Engine_Api::_()->getItem('epetition_dashboards', $this->_getParam('dashboard_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Epetition_Form_Admin_EditDashboard();
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
      $this->_redirect('admin/epetition/settings/manage-dashboards');
    }
  }
  public function manageDashboardsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_managedashboards');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbTable('dashboards', 'epetition')->getDashboardsItems();
  }
  public function createsettingsAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_petitionsettings');
    $this->view->form = $form = new Epetition_Form_Admin_Petitionsettings();
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }
  public function landingPageSetup() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` = 3");
    $page_id = 3;
    $widgetOrder = 1;

    // Insert top
    $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
    ));
    $top_id = $db->lastInsertId();

    // Insert main
    $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
    ));
    $main_id = $db->lastInsertId();

    // Insert top-middle
    $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
    ));
    $top_middle_id = $db->lastInsertId();

    // Insert main-middle
    $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
    ));
    $main_middle_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesbasic.simple-html-block',
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"bodysimple":"<div class=\"epetition_welcome_text_block_wrapper sesbasic_bxs sesbasic_clearfix\">\r\n\t<div class=\"epetition_welcome_text_block\">\r\n  \t<h2 class=\"epetition_welcome_text_block_maintxt\">SHARE YOUR  IDEAS & STORIES  WITH THE WORLD<\/h2>\r\n    <div class=\"epetition_welcome_text_block_buttons sesbasic_clearfix\">\r\n    \t<a href=\"petitions\/home\" class=\"sesbasic_link_btn sesbasic_animation\">Explore Popular Petitions<\/a>\r\n      <a href=\"petitions\/create\" class=\"sesbasic_link_btn sesbasic_animation\">Create Your Unique Petition<\/a>\r\n      <a href=\"petitions\/categories\" class=\"sesbasic_link_btn\">Explore By Category<\/a>\r\n    <\/div>\r\n<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 6px;width: 1200px; margin-left: 50px;\">\r\n<\/div>\r\n<div style=\"font-size: 24px;margin-bottom: 30px;  margin-top: 25px;text-align: center;\">Read our Sponsored Petitions!<\/div>\r\n  <\/div>\r\n<\/div>","en_US_bodysimple":"<div class=\"epetition_welcome_text_block_wrapper sesbasic_bxs sesbasic_clearfix\">\r\n\t<div class=\"epetition_welcome_text_block\">\r\n  \t<h2 class=\"epetition_welcome_text_block_maintxt\">SHARE YOUR  \u2022  IDEAS & STORIES  \u2022 WITH THE WORLD<\/h2>\r\n    <div class=\"epetition_welcome_text_block_buttons sesbasic_clearfix\">\r\n    \t<a href=\"petitions\/home\" class=\"sesbasic_link_btn sesbasic_animation\">Explore Popular Petitions<\/a>\r\n      <a href=\"petitions\/create\" class=\"sesbasic_link_btn sesbasic_animation\">Create Your Unique Petition<\/a>\r\n      <a href=\"petitions\/categories\" class=\"sesbasic_link_btn sesbasic_animation\">Explore By Category<\/a>\r\n    <\/div>\r\n    <p class=\"epetition_welcome_text_block_subtxt\">Read our Sponsored Petitions!<\/p>\r\n  <\/div>\r\n<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'epetition.featured-sponsored-verified-category-carousel',
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"carousel_type":"1","slidesToShow":"4","category":"0","criteria":"2","order":"","info":"most_liked","isfullwidth":"1","autoplay":"1","speed":"2000","show_criteria":["title","favouriteButton","likeButton","category","socialSharing"],"title_truncation":"35","height":"350","width":"400","limit_data":"10","title":"","nomobile":"0","name":"epetition.featured-sponsored-verified-category-carousel"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesbasic.simple-html-block',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up Petitions!<\/div>","en_US_bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up Petitions!<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'epetition.featured-sponsored-verified-random-petition',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"0","criteria":"1","order":"","show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"title":"","nomobile":"0","name":"epetition.featured-sponsored-verified-random-petition"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesbasic.simple-html-block',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_welcome_btn sesbasic_animation\" href=\"petitions\/browse\">Read all Posts\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Verified Petitions on our Community\r\n<\/span><\/div>","en_US_bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_welcome_btn sesbasic_animation\" href=\"petitions\/browse\">Read all Posts\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Verified Petitions on our Community\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'epetition.tabbed-widget-petition',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["grid"],"openViewType":"grid","show_criteria":["favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptiongrid"],"pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"35","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"280","width_grid":"393","height_list":"230","width_list":"260","width_pinboard":"300","search_type":["verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"epetition.tabbed-widget-petition"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesbasic.simple-html-block',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_welcome_btn sesbasic_animation\" href=\"petitions\/locations\">Explore All Petitions\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">What do you want to read out?\r\n<\/span><\/div>","en_US_bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_welcome_btn sesbasic_animation\" href=\"petitions\/locations\">Explore All Petitions\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">What do you want to read out?\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'epetition.petition-category',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"height":"180","width":"196","limit":"12","petition_required":"1","criteria":"admin_order","show_criteria":["title","countPetitions"],"title":"","nomobile":"0","name":"epetition.petition-category"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesbasic.simple-html-block',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_welcome_btn sesbasic_animation\" href=\"petitions\/categories\">Browse All Categories\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Meet our Top Petitions!\r\n<\/span><\/div>","en_US_bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_welcome_btn sesbasic_animation\" href=\"petitions\/categories\">Browse All Categories\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Meet our Top Petitions!\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'epetition.top-petitions',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","show_criteria":["count","ownername"],"height":"180","width":"234","showLimitData":"0","limit_data":"5","title":"","nomobile":"0","name":"epetition.top-petitions"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesspectromedia.banner',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"is_full":"1","is_pattern":"1","banner_image":"public\/admin\/banner_final.jpg","banner_title":"Start by creating your Unique Petition","title_button_color":"FFFFFF","description":"Publish your personal or professional petitions at your desired date and time!","description_button_color":"FFFFFF","button1":"1","button1_text":"Get Started","button1_text_color":"0295FF","button1_color":"FFFFFF","button1_mouseover_color":"EEEEEE","button1_link":"petitions\/create","button2":"0","button2_text":"Button - 2","button2_text_color":"FFFFFF","button2_color":"0295FF","button2_mouseover_color":"067FDE","button2_link":"","button3":"0","button3_text":"Button - 3","button3_text_color":"FFFFFF","button3_color":"F25B3B","button3_mouseover_color":"EA350F","button3_link":"","height":"400","title":"","nomobile":"0","name":"sesspectromedia.banner"}',
    ));
  }


  //site statis for epetition plugin
  public function statisticAction()
  {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_statistic');

    $petitionTable = Engine_Api::_()->getDbtable('epetitions', 'epetition');
    $petitionTableName = $petitionTable->info('name');

    $petitionPhotoTable = Engine_Api::_()->getDbtable('photos', 'epetition');
    $petitionPhotoTableName = $petitionPhotoTable->info('name');

    $petitionAlbumTable = Engine_Api::_()->getDbtable('albums', 'epetition');
    $petitionAlbumTableName = $petitionAlbumTable->info('name');

    //Total Petitions
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalpetition');
    $this->view->totalpetition = $select->query()->fetchColumn();

    //Total approved petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalapprovedpetition')->where('is_approved =?', 1);
    $this->view->totalapprovedpetition = $select->query()->fetchColumn();

    //Total verified petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalverified')->where('verified =?', 1);
    $this->view->totalpetitionverified = $select->query()->fetchColumn();

    //Total featured petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalfeatured')->where('featured =?', 1);
    $this->view->totalpetitionfeatured = $select->query()->fetchColumn();

    //Total sponsored petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalsponsored')->where('sponsored =?', 1);
    $this->view->totalpetitionsponsored = $select->query()->fetchColumn();

    //Total Close of petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalvictory')->where('victory =?', 2);
    $this->view->totalclose = $select->query()->fetchColumn();

    //Total Victory of petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalvictory')->where('victory =?', 1);
    $this->view->totalvictory = $select->query()->fetchColumn();

    //Total favourite petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalfavourite')->where('favourite_count <>?', 0);
    $this->view->totalpetitionfavourite = $select->query()->fetchColumn();

    //Total comments petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalcomment')->where('comment_count <>?', 0);
    $this->view->totalpetitioncomments = $select->query()->fetchColumn();

    //Total view petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totalview')->where('view_count <>?', 0);
    $this->view->totalpetitionviews = $select->query()->fetchColumn();

    //Total like petition
    $select = $petitionTable->select()->from($petitionTableName, 'count(*) AS totallike')->where('like_count <>?', 0);
    $this->view->totalpetitionlikes = $select->query()->fetchColumn();
  }

  public function manageWidgetizePageAction()
  {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_managepages');

    $this->view->pagesArray = array('epetition_index_welcome', 'epetition_index_home', 'epetition_index_browse', 'epetition_category_browse', 'epetition_index_locations', 'epetition_index_manage', 'epetition_index_create', 'epetition_index_view', 'epetition_index_tags', 'epetition_album_view', 'epetition_photo_view', 'epetition_category_index');
  }

  public function supportAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_support');

  }


}
