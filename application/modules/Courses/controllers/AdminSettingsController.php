<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSettingsController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_AdminSettingsController extends Core_Controller_Action_Admin {
  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_setting');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_setting', array(), 'courses_admin_main_course');
    $this->view->form = $form = new Courses_Form_Admin_Course_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        include_once APPLICATION_PATH . "/application/modules/Courses/controllers/License.php";
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $values = $form->getValues();
        if ($settings->getSetting('courses.pluginactivated')) {
              //START TEXT CHNAGE WORK IN CSV FILE
              $oldSigularWord = $settings->getSetting('courses.text.singular', 'course');
              $oldPluralWord = $settings->getSetting('courses.text.plural', 'courses');
              $newSigularWord = $values['courses_text_singular'] ? $values['courses_text_singular'] : 'course';
              $newPluralWord = $values['courses_text_plural'] ? $values['courses_text_plural'] : 'courses';
              $newSigularWordUpper = ucfirst($newSigularWord);
              $newPluralWordUpper = ucfirst($newPluralWord); 
              if (($newSigularWord != $oldSigularWord) || ($newPluralWord != $oldPluralWord)) {
              $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/courses.csv', 'null', array('delimiter' => ';', 'enclosure' => '"'));
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

              $targetFile = APPLICATION_PATH . '/application/languages/en/courses.csv';
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
              if(is_null($value)) {
                $value = 0;
              }
              $settings->setSetting($key, $value);
          }
          $form->addNotice('Your changes have been saved.');
          if (@$error)
          $this->_helper->redirector->gotoRoute(array());
        }
    }
  }
  public function createAction() {
   $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_create');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_create', array(), 'courses_admin_main_coursecreate');
    $this->view->form = $form = new Courses_Form_Admin_Course_Create();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
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
  public function manageWidgetizeAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_wgtzpage');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_wgtzpage', array(), 'courses_admin_main_crswgtzpg');
    $coursesArray = array('courses_index_welcome','courses_index_home','courses_index_browse','courses_lecture_view','courses_index_create','courses_lecture_create','courses_test_create','courses_index_browse-review','courses_wishlist_browse','courses_review_view','courses_wishlist_view','courses_cart_checkout','courses_profile_index','courses_test_view','courses_test_result','courses_category_browse','courses_category_index','courses_index_tags','courses_index_manage','courses_index_verified','courses_index_featured','courses_index_sponsored','courses_index_hot','courses_index_compare','courses_manage_my-order','courses_manage_my-wishlists','courses_manage_billing','courses_manage_course-reviews');
    $this->view->coursesArray = $coursesArray;
  }
  public function manageDashboardsAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_dshbrd');
     $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_dshbrd', array(), 'courses_admin_main_crsdshbrd');
    $this->view->paginator = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems();
  }
  public function enabledAction() {

    $id = $this->_getParam('dashboard_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('courses_dashboard', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/courses/settings/manage-dashboards');
  }
 public function editDashboardsSettingsAction() {
    $dashboards = Engine_Api::_()->getItem('courses_dashboard', $this->_getParam('dashboard_id'));
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
    $this->_redirect('admin/courses/settings/manage-dashboards');
    }
  }
  public function statisticAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_sts');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_sts', array(), 'courses_admin_main_crssts');

    $courseTable = Engine_Api::_()->getDbTable('courses', 'courses');
    $ourseTableName = $courseTable->info('name');
    //Total Course
    $this->view->totalCourse = $courseTable->select()->from($ourseTableName, 'count(*) AS totalCourse')->query()->fetchColumn();
    //Total approved Course
    $this->view->totalApprovedCourse = $courseTable->select()->from($ourseTableName, 'count(*) AS totalApprovedCourse')->where('is_approved =?', 1)->query()->fetchColumn();
    //Total verified Course
    $this->view->totalVerifiedCourse = $courseTable->select()->from($ourseTableName, 'count(*) AS totalVerifiedCourse')->where('verified =?', 1)->query()->fetchColumn();
    //Total featured Course
    $this->view->totalFeaturedCourse = $courseTable->select()->from($ourseTableName, 'count(*) AS totalFeaturedCourse')->where('featured =?', 1)->query()->fetchColumn();
    //Total sponsored Course
    $this->view->totalSponsoredCourse = $courseTable->select()->from($ourseTableName, 'count(*) AS totalSponsoredCourse')->where('sponsored =?', 1)->query()->fetchColumn();
    //Total hot Course
    //$this->view->totalHotCourse = $courseTable->select()->from($ourseTableName, 'count(*) AS totalHotCourse')->where('hot =?', 1)->query()->fetchColumn();
    //Total favourite Course
    $this->view->totalFavouriteCourse = $courseTable->select()->from($ourseTableName, 'count(*) AS totalFavouriteCourse')->where('favourite_count <>?', 0)->query()->fetchColumn();
    //Total comments Course
    $this->view->totalCourseComment = $courseTable->select()->from($ourseTableName, 'count(*) AS totalCourseComment')->where('comment_count <>?', 0)->query()->fetchColumn();
    //Total view Course
    $this->view->totalCourseView = $courseTable->select()->from($ourseTableName, 'count(*) AS totalCourseView')->where('view_count <>?', 0)->query()->fetchColumn();
    //Total like Course
    $this->view->totalCourseLike = $courseTable->select()->from($ourseTableName, 'count(*) AS totalCourseLike')->where('like_count <>?', 0)->query()->fetchColumn();
    //Total follow Course
    $this->view->totalCourseFollewers = $courseTable->select()->from($ourseTableName, 'count(*) AS totalCourseFollewers')->where('follow_count <>?', 0)->query()->fetchColumn();
  }
  public function utilityAction() {
    if (defined('_ENGINE_ADMIN_NEUTER') && _ENGINE_ADMIN_NEUTER) {
      return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('courses_admin_main', array(), 'courses_admin_main_utility');
    $ffmpeg_path = Engine_Api::_()->getApi('settings', 'core')->video_ffmpeg_path;
    if (function_exists('shell_exec')) {
      // Get version
      $this->view->version = $version = shell_exec(escapeshellcmd($ffmpeg_path) . ' -version 2>&1');
      $command = "$ffmpeg_path -formats 2>&1";
      $this->view->format = $format = shell_exec(escapeshellcmd($ffmpeg_path) . ' -formats 2>&1')
              . shell_exec(escapeshellcmd($ffmpeg_path) . ' -codecs 2>&1');
    }
  }
  public function supportAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_support');
  }
}
