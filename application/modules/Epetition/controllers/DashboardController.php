<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: DashboardController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_DashboardController extends Core_Controller_Action_Standard
{

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('epetition', null, 'view')->isValid())
      return;

    if (!$this->_helper->requireUser->isValid())
      return;

    $id = $this->_getParam('epetition_id', null);

    if (!isset($_POST['locationphoto_id'])) {
      $viewer = $this->view->viewer();

      if(!(int) $id)
      $epetition_id = Engine_Api::_()->getDbTable('epetitions', 'epetition')->getPetitionId($id);
      else 
      $epetition_id = $id;

      if ($epetition_id) {
        $petition = Engine_Api::_()->getItem('epetition', $epetition_id);
        if ($petition && (($petition->is_approved || $viewer->level_id == 1 || $viewer->level_id == 2 || $viewer->getIdentity() == $petition->owner_id) ))
        {

          Engine_Api::_()->core()->setSubject($petition);
        }
        else
          {

          return $this->_forward('requireauth', 'error', 'core');
        }
      } else {
        return $this->_forward('requireauth', 'error', 'core');
      }
    }

  }

  public function reportsAction()
  {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->page = $page = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $id = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($id);
    $this->view->petition = Engine_Api::_()->getItem('epetition', $epetition_id);
    $this->view->form = $form = new Epetition_Form_Dashboard_Searchreport();
    $value = array();
    if (isset($_GET['startdate']))
      $value['startdate'] = $value['start'] = date('Y-m-d', strtotime($_GET['startdate']));
    if (isset($_GET['enddate']))
      $value['enddate'] = $value['end'] = date('Y-m-d', strtotime($_GET['enddate']));
    if (isset($_GET['type']))
      $value['type'] = $_GET['type'];
    if (!count($value)) {
      $value['enddate'] = date('Y-m-d', strtotime(date('Y-m-d')));
      $value['startdate'] = date('Y-m-d', strtotime('-30 days'));
      $value['type'] = $form->type->getValue();
    }
    if (isset($_GET['excel']) && $_GET['excel'] != '')
      $value['download'] = 'excel';
    if (isset($_GET['csv']) && $_GET['csv'] != '')
      $value['download'] = 'csv';

    $form->populate($value);
    $value['epetition_id'] = $page->getIdentity();
    $this->view->pageReportData = $data = Engine_Api::_()->getDbTable('epetitions', 'epetition')->getReportData($value);


    if (isset($value['download'])) {
      $name = str_replace(' ', '_', $page->getTitle()) . '_' . time();
      switch ($value["download"]) {
        case "excel" :
          // Submission from
          $filename = $name . ".xls";
          header("Content-Type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=\"$filename\"");
          $this->exportFile($data);
          exit();
        case "csv" :
          // Submission from
          $filename = $name . ".csv";
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Content-type: text/csv");
          header("Content-Disposition: attachment; filename=\"$filename\"");
          header("Expires: 0");
          $this->exportCSVFile($data);
          exit();
        default :
          //silence
          break;
      }
    }
  }


  public function victoryAction()
  {

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      $epetition = Engine_Api::_()->getItem('epetition', $_POST['id']);
      $epetition->victory = 1;
      $epetition->vicotry_time = date("Y-m-d H:i:s");
      $epetition->vicotry_addby = $viewer_id;
      $epetition->save();
      $array = array();
      $array['status'] = 1;
      $array['msg'] = "You successfully change petition status";


      $title = $epetition['title'];
      $sender = Engine_Api::_()->getItem('user', $viewer_id);
      $viewer = Engine_Api::_()->getItem('user', $epetition['owner_id']);

      // All user id
      $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
      $signuser = Engine_Api::_()->getDbtable('signatures', 'epetition')->signAllUser($epetition['epetition_id']);
      $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($epetition['epetition_id']);

      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $epetition, 'epetition_victory', null,array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      if ($action) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
      }

      foreach ($super_admin as $admin) {
        $admin_obj = Engine_Api::_()->getItem('user', $admin['user_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin_obj->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner have marked his petition as Victory",
          'message' => "<a href='" . $viewer->getHref() . "'>" . $viewer->getTitle() . "</a> have marked the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a> as victory.",
        ));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_victory', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $epetition, 'epetition_victory',null, array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        // make sure action exists before attaching the petition to the activity
        if ($action) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
        }

      }

      // send email and notification for user
      foreach ($signuser as $signuse) {
        $viewer_user = Engine_Api::_()->getItem('user', $signuse['owner_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_user->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner have marked his petition as Victory",
          'message' => "<a href='" . $viewer->getHref() . "'>" . $viewer->getTitle() . "</a> have marked the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a> as victory. which you have signed",
        ));

        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_user, $sender, $epetition, 'epetition_victory', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }

      // send email and notification for decision maker
      foreach ($decisionMaker as $dem) {
        $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner have marked his petition as Victory",
          'message' => "<a href='" . $viewer_dec->getHref() . "'>" . $viewer_dec->getTitle() . "</a> have marked the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a> as victory. which you have decision maker",
        ));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_victory', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }
      echo json_encode($array);
      exit();
    }
    $this->view->slug = $slug = $this->_getParam('epetition_id', null);
    $this->view->epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
  }

  public function decisionmakerAction()
  {
    $this->view->form = $form = new Epetition_Form_Dashboard_Decisionmakergoaledit();
    $slug = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
    $petition = Engine_Api::_()->getItem('epetition', $epetition_id);
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $petition->signature_goal = $values['signature_goal'];
      $petition->save();
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Signature goal updated.'))
      ));
    }
    $form->populate(array(
      'signature_goal' => $petition->signature_goal,
    ));
  }

  public function fieldsAction()
  {
    if (!$this->_helper->requireUser()->isValid()) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $package_id = $epetition->package_id;
    $package = Engine_Api::_()->getItem('epetitionpackage_package', $package_id);
    $module = json_decode($package->params, true);
    if (empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
      return $this->_forward('notfound', 'error', 'core');

    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'epetition')->profileFieldId();
    $this->view->form = $form = new Epetition_Form_Custom_Dashboardfields(array('item' => $epetition, 'topLevelValue' => 0, 'topLevelId' => 0));
    // Check post/form
    if (!$this->getRequest()->isPost()) return;
    if (!$form->isValid($this->getRequest()->getPost())) return;
    $form->saveValues();

  }

  public function editAction()
  {

    if (!$this->_helper->requireUser()->isValid()) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $old_body = $epetition['body'];
    if (isset($epetition->category_id) && $epetition->category_id != 0)
      $this->view->category_id = $epetition->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($epetition->subsubcat_id) && $epetition->subsubcat_id != 0)
      $this->view->subsubcat_id = $epetition->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($epetition->subcat_id) && $epetition->subcat_id != 0)
      $this->view->subcat_id = $epetition->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'epetition')->profileFieldId();


    if (!$this->_helper->requireSubject()->isValid()) return;

    if (!$this->_helper->requireAuth()->setAuthParams('epetition', $viewer, 'edit')->isValid()) {return;}


    // Get navigation
    $this->view->navigation = $t = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('epetition_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'epetition')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Epetition_Form_Edit(array('defaultProfileId' => $defaultProfileId));


    // Populate form
    $form->populate($epetition->toArray());
    $form->populate(array(
      'networks' => explode(",", $epetition->networks),
      'levels' => explode(",", $epetition->levels)
    ));
    //$form->getElement('petitionstyle')->setValue($epetition->style);
    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('epetition', $epetition->epetition_id);
    if ($latLng) {
      if ($form->getElement('lat'))
        $form->getElement('lat')->setValue($latLng->lat);
      if ($form->getElement('lng'))
        $form->getElement('lng')->setValue($latLng->lng);
    }
    if ($form->getElement('location'))
      $form->getElement('location')->setValue($epetition->location);
    if ($form->getElement('category_id'))
      $form->getElement('category_id')->setValue($epetition->category_id);
    if ($form->getElement('petition_overview'))
      $form->getElement('petition_overview')->setValue($epetition->petition_overview);
    if ($form->getElement('signature_goal'))
      $form->getElement('signature_goal')->setValue($epetition->signature_goal);


    $tagStr = '';
    foreach ($epetition->tags()->getTagMaps() as $tagMap) {
      $tag = $tagMap->getTag();
      if (!isset($tag->text)) continue;
      if ('' !== $tagStr) $tagStr .= ', ';
      $tagStr .= $tag->text;
    }
    $form->populate(array(
      'tags' => $tagStr,
    ));
    $this->view->tagNamePrepared = $tagStr;

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    foreach ($roles as $role) {
      if ($form->auth_view) {
        if ($auth->isAllowed($epetition, $role, 'view')) {
          $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment) {
        if ($auth->isAllowed($epetition, $role, 'comment')) {
          $form->auth_comment->setValue($role);
        }
      }

      if ($form->auth_video) {
        if ($auth->isAllowed($epetition, $role, 'video')) {
          $form->auth_video->setValue($role);
        }
      }

      if ($form->auth_music) {
        if ($auth->isAllowed($epetition, $role, 'music')) {
          $form->auth_music->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if ($epetition->draft == "0")
      $form->removeElement('draft');


    // Check post/form
    if (!$this->getRequest()->isPost()) return;
    if (!$form->isValid($this->getRequest()->getPost())) return;

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {
      $values = $form->getValues();
      $epetition = Engine_Api::_()->getItem('epetition', $epetition['epetition_id']);
      $oldUrl = $epetition->custom_url;
      if (isset($_POST['custom_url']) && $_POST['custom_url'] != $oldUrl) {
       $epetition->custom_url=$_POST['custom_url'];
       $epetition->save();
      }
      $new_body = $values['body'];
      if (strcmp(trim(strip_tags($new_body)), trim(strip_tags($old_body)))) {
        $subject = $epetition['title'] . " update";
        $message = "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a> has been updated.";
        // Engine_Api::_()->epetition()->SendEmailallSignatureUser($epetition['epetition_id'],$subject,$message);
        $sender = Engine_Api::_()->getItem('user', $epetition['owner_id']);

        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($sender, $epetition, 'epetition_update',null, array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        if ($action) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
        }


        // All user id
        $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
        $signuser = Engine_Api::_()->getDbtable('signatures', 'epetition')->signAllUser($epetition['epetition_id']);
        $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($epetition['epetition_id']);
        foreach ($super_admin as $admin) {
          $admin_obj = Engine_Api::_()->getItem('user', $admin['user_id']);
/*          Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin_obj->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $subject,
            'message' => $message,
          ));*/
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_update', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }

        // send email and notification for user
        foreach ($signuser as $signuse) {
          $viewer_user = Engine_Api::_()->getItem('user', $signuse['owner_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_user->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $subject,
            'message' => $message,
          ));

          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_user, $sender, $epetition, 'epetition_update', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }

        // send email and notification for decision maker
        foreach ($decisionMaker as $dem) {
          $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $subject,
            'message' => $message,
          ));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_update', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }

      }
      if ($_POST['petitionstyle'])
        $values['style'] = $_POST['petitionstyle'];
      $epetition->setFromArray($values);
      $epetition->modified_date = date('Y-m-d H:i:s');
      if (isset($_POST['start_date']) && $_POST['start_date'] != '') {
        $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s', strtotime($_POST['start_date'] . ' ' . $_POST['start_time'])) : '';
        $epetition->publish_date = $starttime;
      }
      //else{
      //	$epetition->publish_date = '';
      //}
      if (isset($values['levels'])) {
        $epetition->levels = implode(',', $values['levels']);
      }

      if (isset($values['networks'])) {
        $epetition->networks = implode(',', $values['networks']);
      }

      $epetition->save();
      unset($_POST['title']);
      unset($_POST['tags']);
      unset($_POST['category_id']);
      unset($_POST['subcat_id']);
      unset($_POST['MAX_FILE_SIZE']);
      unset($_POST['body']);
      unset($_POST['search']);
      unset($_POST['execute']);
      unset($_POST['token']);
      unset($_POST['submit']);
      $values['fields'] = $_POST;
      $values['fields']['0_0_1'] = '2';

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && $_POST['location']) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $epetition->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","epetition") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else {
        $epetition->location = '';
        $epetition->save();
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "epetition" AND `engine4_sesbasic_locations`.`resource_id` = "' . $epetition->getIdentity() . '";');
      }

      if (isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if ($epetition->publish_date < $currentDate) {
          $epetition->publish_date = $currentDate;
          $epetition->save();
        }
      }

      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($epetition);
        $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($epetition);
      $profile_field_value = $view->FieldValueLoop($epetition, $fieldStructure);

      // Auth
      if (empty($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }

      if (empty($values['auth_comment'])) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search($values['auth_video'], $roles);
      $musicMax = array_search($values['auth_music'], $roles);
      foreach ($roles as $i => $role) {
        $auth->setAllowed($epetition, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($epetition, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($epetition, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($epetition, $role, 'music', ($i <= $musicMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $epetition->tags()->setTagMaps($viewer, $tags);

      //upload main image
      if (isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != '') {
        $photo_id = $epetition->setPhoto($form->photo_file, 'direct');
      }

      // insert new activity if epetition is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($epetition);
      if (count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$epetition->publish_date || strtotime($epetition->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $epetition, 'epetition_new');
        // make sure action exists before attaching the epetition to the activity
        if ($action != null) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
        }
        $epetition->is_publish = 1;
        $epetition->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach ($actionTable->getActionsByObject($epetition) as $action) {
        $actionTable->resetActivityBindings($action);
      }

      // Send notifications for subscribers


      Engine_Api::_()->getDbtable('subscriptions', 'epetition')->sendNotifications($epetition);


      $db->commit();

    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_redirectCustom(array('route' => 'epetition_dashboard', 'action' => 'edit', 'epetition_id' => $epetition->custom_url));
  }

  public function upgradeAction()
  {
    if (!$this->_helper->requireUser()->isValid()) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    //current package
    if (!empty($epetition->orderspackage_id)) {
      $this->view->currentPackage = Engine_Api::_()->getItem('epetitionpackage_orderspackage', $epetition->orderspackage_id);
      if (!$this->view->currentPackage) {
        $this->view->currentPackage = Engine_Api::_()->getItem('epetitionpackage_package', $epetition->package_id);
      }
    } else
      $this->view->currentPackage = Engine_Api::_()->getItem('epetitionpackage_package', $epetition->package_id);
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    //get upgrade packages
    $this->view->upgradepackage = Engine_Api::_()->getDbTable('packages', 'epetitionpackage')->getPackage(array('show_upgrade' => 1, 'member_level' => $viewer->level_id, 'not_in_id' => $epetition->package_id));

  }

  public function removeMainphotoAction()
  {
    //GET Petition ID AND ITEM
    $petition = Engine_Api::_()->core()->getSubject();
    $db = Engine_Api::_()->getDbTable('epetitions', 'epetition')->getAdapter();
    $db->beginTransaction();
    try {
      $petition->photo_id = '';
      $petition->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'epetition_id' => $petition->custom_url), "epetition_dashboard", true);
  }

  public function mainphotoAction()
  {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->petition = $petition = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $petition->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Epetition_Form_Dashboard_Mainphoto();
    $form->populate($petition->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getAdapter();
    $db->beginTransaction();
    try {
      $petition->setPhoto($_FILES['background']);
      $petition->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'epetition_id' => $petition->custom_url), "epetition_dashboard", true);
  }

  //get style detail
  public function styleAction()
  {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->petition = $petition = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $petition->isOwner($viewer) || $this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid()))
      return;
    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', 'epetition')
      ->where('id = ?', $petition->getIdentity())
      ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Epetition_Form_Dashboard_Style();
    // Check post
    if (!$this->getRequest()->isPost()) {
      $form->populate(array(
        'style' => (null === $row ? '' : $row->style)
      ));
    }
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    // Cool! Process
    $style = $form->getValue('style');
    // Save
    if (null == $row) {
      $row = $table->createRow();
      $row->type = 'epetition';
      $row->id = $petition->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

  //get seo detail
  public function seoAction()
  {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->petition = $petition = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $petition->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Epetition_Form_Dashboard_Seo();

    $form->populate($petition->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getAdapter();
    $db->beginTransaction();
    try {
      $petition->setFromArray($_POST);
      $petition->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editPhotoAction()
  {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->petition = $petition = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Epetition_Form_Edit_Photo();

    if (empty($petition->photo_id)) {
      $form->removeElement('remove');
    }

    if (!$this->getRequest()->isPost()) {
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Uploading a new photo
    if ($form->Filedata->getValue() !== null) {
      $db = $petition->getTable()->getAdapter();
      $db->beginTransaction();

      try {

        $fileElement = $form->Filedata;

        // $petition->setPhoto($fileElement);
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false, false, 'epetition', 'epetition', '', $petition, true);
        $petition->photo_id = $photo_id;
        $petition->save();
        $db->commit();
      } // If an exception occurred within the image adapter, it's probably an invalid image
      catch (Engine_Image_Adapter_Exception $e) {
        $db->rollBack();
        $form->addError(Zend_Registry::get('Zend_Translate')->_('The uploaded file is not supported or is corrupt.'));
      } // Otherwise it's probably a problem with the database or the storage system (just throw it)
      catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function removePhotoAction()
  {
    //Get form
    $this->view->form = $form = new Epetition_Form_Edit_RemovePhoto();

    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $petition = Engine_Api::_()->core()->getSubject();
    $petition->photo_id = 0;
    $petition->save();

    $this->view->status = true;

    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }

  public function contactInformationAction()
  {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->petition = $petition = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $petition->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Epetition_Form_Dashboard_Contactinformation();

    $form->populate($petition->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    $db = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getAdapter();
    $db->beginTransaction();
    try {
      $petition->petition_contact_name = isset($_POST['petition_contact_name']) ? $_POST['petition_contact_name'] : '';
      $petition->petition_contact_email = isset($_POST['petition_contact_email']) ? $_POST['petition_contact_email'] : '';
      $petition->petition_contact_phone = isset($_POST['petition_contact_phone']) ? $_POST['petition_contact_phone'] : '';
      $petition->petition_contact_website = isset($_POST['petition_contact_website']) ? $_POST['petition_contact_website'] : '';
      $petition->petition_contact_facebook = isset($_POST['petition_contact_facebook']) ? $_POST['petition_contact_facebook'] : '';
      $petition->petition_contact_linkedin = isset($_POST['petition_contact_linkedin']) ? $_POST['petition_contact_linkedin'] : '';
      $petition->petition_contact_twitter = isset($_POST['petition_contact_twitter']) ? $_POST['petition_contact_twitter'] : '';
      $petition->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false;
      die;
    }
  }


  public function petitionRoleAction()
  {

    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('roles', 'epetition')->getPetitionAdmins(array('epetition_id' => $epetition->epetition_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function getMembersAction()
  {
    $sesdata = array();
    $roleIDArray = array();
    $ownerId = Engine_Api::_()->getItem('epetition', $this->_getParam('epetition_id', null))->owner_id;
    $viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = $viewer->membership()->getMembershipsOfIds();
    $users = array_merge($users, array('0' => $ownerId));
    $petitionRoleTable = Engine_Api::_()->getDbTable('roles', 'epetition');
    $roleIds = $petitionRoleTable->select()->from($petitionRoleTable->info('name'), 'user_id')->where('epetition_id =?', $this->_getParam('epetition_id', null))->query()->fetchAll();
    foreach ($roleIds as $roleID) {
      $roleIDArray[] = $roleID['user_id'];
    }
    $diffIds = array_diff($users, $roleIDArray);
    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $usersTableName = $users_table->info('name');
    $select = $users_table->select()->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%');
    if ($diffIds)
      $select->where($usersTableName . '.user_id IN (?)', $diffIds);
// 		else
// 		$select->where($usersTableName . '.user_id IN (?)', 0);
    $select->order('displayname ASC')->limit('40');
    $users = $users_table->fetchAll($select);
    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
        'id' => $user->user_id,
        'label' => $user->displayname,
        'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function savePetitionAdminAction()
  {
    $data = explode(',', $_POST['data']);
    $epetition_id = $this->_getParam('epetition_id', null);
    $this->view->owner_id = $owner_id = Engine_Api::_()->getItem('epetition', $epetition_id)->owner_id;
    foreach ($data as $petitionAdminId) {
      $checkUser = Engine_Api::_()->getDbTable('roles', 'epetition')->isPetitionAdmin($epetition_id, $petitionAdminId);
      if ($checkUser)
        continue;
      $roleTable = Engine_Api::_()->getDbtable('roles', 'epetition');
      $row = $roleTable->createRow();
      $row->epetition_id = $epetition_id;
      $row->user_id = $petitionAdminId;
      $row->resource_approved = '0';
      $row->save();
      //Notification Work for admin
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('roles', 'epetition')->getPetitionAdmins(array('epetition_id' => $epetition_id));
  }

  public function deletePetitionAdminAction()
  {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $db->delete('engine4_epetition_roles', array(
      'epetition_id = ?' => $_POST['epetition_id'],
      'role_id =?' => $_POST['role_id'],
    ));
  }

  public function editLocationAction()
  {
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $userLocation = $epetition->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($epetition->getType(), $epetition->getIdentity());
    if (!$locationLatLng) {
      return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Epetition_Form_Locationedit();
    $form->populate(array(
      'ses_edit_location' => $userLocation,
      'ses_lat' => $locationLatLng['lat'],
      'ses_lng' => $locationLatLng['lng'],
      'ses_zip' => $locationLatLng['zip'],
      'ses_city' => $locationLatLng['city'],
      'ses_state' => $locationLatLng['state'],
      'ses_country' => $locationLatLng['country'],
    ));
    if ($this->getRequest()->getPost()) {
      Engine_Api::_()->getItemTable('epetition')->update(array(
        'location' => $_POST['ses_edit_location'],
      ), array(
        'epetition_id = ?' => $epetition->getIdentity(),
      ));
      if (isset($_POST['ses_lat']) && isset($_POST['ses_lng']) && $_POST['ses_lat'] != '' && $_POST['ses_lng'] != '' && !empty($_POST['ses_edit_location'])) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $epetition->epetition_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "epetition")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }
      $this->_redirectCustom(array('route' => 'epetition_dashboard', 'action' => 'edit-location', 'epetition_id' => $epetition->custom_url));
    }
    //Render
  }

  public function petitionVictoryAction()
  {

    $this->view->petition = Engine_Api::_()->core()->getSubject();
    $slug = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
    $rec_epetiton = Engine_Api::_()->getItemTable('epetition', 'epetition')->getDetailsForAjaxUpdate($epetition_id);
    $epetition = Engine_Api::_()->getItem('epetition', $rec_epetiton);
    $type1 = Engine_Api::_()->getDbTable('decisionmakers', 'epetition')->checkLetterApprove($epetition_id, null);
    $type2 = Engine_Api::_()->getDbTable('decisionmakers', 'epetition')->checkLetterApprove($epetition_id, 1);
    $message = '';
    if ($rec_epetiton['signpet'] != $rec_epetiton['goal']) {
      $message = "The Signature Goal for your Petition has not reached. This petition goal is ".$rec_epetiton['goal']."  and reached is ".$rec_epetiton['signpet']."";
    } else if ($epetition['victory']) {
      $message = "This Petition already victory";
    } else {
      if (!$type2) {
        $message = "This Petition is not send petition letter";
      } else if ($type2 == 1) {
        $message = "This Petition is waiting for decision maker approve";
      } else if ($type2 == 4) {
        $message = "This Petition is cancel by decision maker";
      } else {
        $this->view->status = 1;
      }
    }
    $this->view->message = $message;
  }

  public function petitionLetterAction()
  {
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();

    $this->view->form = $form = new Epetition_Form_Petitionletter();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $epetition->letter = $values['letter'];
      $epetition->save();


      $title = $epetition['title'];
      $sender = Engine_Api::_()->getItem('user', $epetition['owner_id']);

      // All user id
      $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
      $signuser = Engine_Api::_()->getDbtable('signatures', 'epetition')->signAllUser($epetition['epetition_id']);
      $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($epetition['epetition_id']);
      foreach ($super_admin as $admin) {
        $admin_obj = Engine_Api::_()->getItem('user', $admin['user_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin_obj->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner have add petition letter",
          'message' => "<a href='" . $sender->getHref() . "'>" . $sender->getTitle() . "</a> have add letter of the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
        ));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_letteradd', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }

      // send email and notification for user
      foreach ($signuser as $signuse) {
        $viewer_user = Engine_Api::_()->getItem('user', $signuse['owner_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_user->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner have add petition letter",
          'message' => "<a href='" . $sender->getHref() . "'>" . $sender->getTitle() . "</a>  have add letter of the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
        ));

        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_user, $sender, $epetition, 'epetition_letteradd', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }

      // send email and notification for decision maker
      foreach ($decisionMaker as $dem) {
        $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner have add petition letter",
          'message' => "<a href='" . $sender->getHref() . "'>" . $sender->getTitle() . "</a>  have add letter of the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a> .",
        ));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_letteradd', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }
    }

    if (isset($epetition->letter)) {
      $form->populate(array(
        'letter' => $epetition->letter,
      ));
    }
  }


  public function petitionAnnouncementAction()
  {
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $this->view->slug = $slug = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $epetitionAlbumTable = Engine_Api::_()->getDbtable('announcements', 'epetition');
          $epetitionAlbumTable->delete(array(
            'announcement_id = ?' => $value,
          ));
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $this->view->paginator = $data = Engine_Api::_()->getDbtable('announcements', 'epetition')->getAnnouncementPaginator(array(
      'orderby' => 'announcement_id',
      'epetition_id' => $epetition_id,
    ));
    $this->view->paginator->setItemCountPerPage(10);
    $this->view->paginator->setCurrentPageNumber($page);

  }

  public function createAnnouncementAction()
  {
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $slug = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
    $owner_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionOwnerId($slug);
    $this->view->form = $form = new Epetition_Form_Petitionannouncement();
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $roleTable = Engine_Api::_()->getDbtable('announcements', 'epetition');
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      $row = $roleTable->createRow();
      $row->epetition_id = $epetition_id;
      $row->petition_owner_id = $owner_id;
      $row->title = $values['announcement_title'];
      $row->description = $values['announcement_description'];
      $row->created_by = $viewer_id;
      $row->created_date = date("Y-m-d H:i:s");
      $row->save();

      $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);
      $sender = Engine_Api::_()->getItem('user', $viewer_id);
      $viewer = Engine_Api::_()->getItem('user', $epetition['owner_id']);

      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $epetition, 'epetition_aupdate',null, array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      if ($action) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
      }


      // All user id
      $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
      $signuser = Engine_Api::_()->getDbtable('signatures', 'epetition')->signAllUser($epetition['epetition_id']);
      $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($epetition['epetition_id']);
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($sender, $epetition, 'epetition_update',null, array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      if ($action) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
      }

      foreach ($super_admin as $admin) {
        $admin_obj = Engine_Api::_()->getItem('user', $admin['user_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin_obj->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner has add update",
          'message' => "<a href='" . $viewer->getHref() . "'>" . $viewer->getTitle() . "</a> have update the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
        ));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_aupdate', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }

      // send email and notification for user
      foreach ($signuser as $signuse) {
        $viewer_user = Engine_Api::_()->getItem('user', $signuse['owner_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_user->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner has add update",
          'message' => "<a href='" . $viewer->getHref() . "'>" . $viewer->getTitle() . "</a> have update the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
        ));

        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_user, $sender, $epetition, 'epetition_aupdate', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }

      // send email and notification for decision maker
      foreach ($decisionMaker as $dem) {
        $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition Owner has add update",
          'message' => "<a href='" . $viewer->getHref() . "'>" . $viewer->getTitle() . "</a> have update the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
        ));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_aupdate', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }

      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have submitted successfully.'))
      ));
    }
  }

  public function viewAnnouncementAction()
  {
    $id = $this->_getParam('id', null);
    $this->view->data = $data = Engine_Api::_()->getDbtable('announcements', 'epetition')->select()
      ->where('announcement_id =?', $id)
      ->query()
      ->fetch();
  }

  public function deleteAnnouncementAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $array = array();
      $epetitionAlbumTable = Engine_Api::_()->getDbtable('announcements', 'epetition');
      if ($epetitionAlbumTable->delete(array('announcement_id = ?' => $_POST['id']))) {
        $array['status'] = 1;
        $array['msg'] = "This Announcement deleted successfully";
      } else {
        $array['status'] = 0;
        $array['msg'] = "This Announcement can not be deleted";
      }
      echo json_encode($array);
      exit();
    }
  }

  public function editAnnouncementAction()
  {
    $this->view->form = $form = new Epetition_Form_Editpetitionannouncement();
    $id = $this->_getParam('id', null);
    $data = Engine_Api::_()->getItem('epetition_announcement', $id);
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $data->title = $values['announcement_title'];
      $data->description = $values['announcement_description'];
      $data->save();
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have updated successfully.'))
      ));
    }
    $form->populate(array(
      'announcement_title' => $data['title'],
      'announcement_description' => $data['description'],
    ));
  }

  public function petitionSignatureAction()
  {
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $slug = $this->_getParam('epetition_id', null);
    $this->view->form = $form = new Epetition_Form_Searchdashboardsignature();
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      $form->populate($values);
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $signature = Engine_Api::_()->getItem('epetition_signature', $value);
          $signature->delete();
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $this->view->paginator = $data = Engine_Api::_()->getDbtable('signatures', 'epetition')->getSignaturesPaginator(array(
      'name' => isset($_POST['name']) && !empty($_POST['name']) ? trim($_POST['name']) : null,
      'user_type' => isset($_POST['user_type']) && !empty($_POST['user_type']) ? trim($_POST['user_type']) : null,
      'from_date' => isset($_POST['from_date']) && !empty($_POST['from_date']) ? date("Y-m-d", strtotime(trim($_POST['from_date']))) : null,
      'to_date' => isset($_POST['to_date']) && !empty($_POST['to_date']) ? date("Y-m-d", strtotime(trim($_POST['to_date']))) : null,
      'orderby' => 'signature_id',
      'epetition_id' => $epetition_id
    ));
    $this->view->paginator->setItemCountPerPage(10);
    $this->view->paginator->setCurrentPageNumber($page);
  }

  public function deleteDashboardSignatureAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $array = array();
      $epetitionSignatureTable = Engine_Api::_()->getDbtable('signatures', 'epetition');
      if ($epetitionSignatureTable->delete(array('signature_id = ?' => $_POST['id']))) {
        $array['status'] = 1;
        $array['msg'] = "This Signature deleted successfully";
      } else {
        $array['status'] = 0;
        $array['msg'] = "This Signature can not be deleted";
      }
      echo json_encode($array);
      exit();
    }
  }

  public function viewDashboardSignatureAction()
  {
    $id = $this->_getParam('id', null);
    $this->view->data = $data = Engine_Api::_()->getDbtable('signatures', 'epetition')->select()
      ->where('signature_id =?', $id)
      ->query()
      ->fetch();
  }

  public function editDashboardSignatureAction()
  {
    $this->view->form = $form = new Epetition_Form_Editdashboardsignature();
    $id = $this->_getParam('id', null);
    $data = Engine_Api::_()->getItem('epetition_signature', $id);
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $data->location = $values['location'];
      $data->support_statement = $values['support_statement'];
      $data->support_reason = $values['support_reason'];
      $data->save();
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have updated successfully.'))
      ));
    }
    $form->populate(array(
      'location' => $data['location'],
      'support_statement' => $data['support_statement'],
      'support_reason' => $data['support_reason'],
    ));
  }

  public function petitionDecisionmakerAction()
  {
    $this->view->petition = $epetition = Engine_Api::_()->core()->getSubject();
    $this->view->slug = $slug = $this->_getParam('epetition_id', null);
    $this->view->form = $form = new Epetition_Form_Searchdashboardsignature();
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $admindecisionmaker = Engine_Api::_()->getItem('epetition_decisionmaker', $value);
          if(isset($admindecisionmaker) && !empty($admindecisionmaker)) {
            $admindecisionmaker->delete();
          }
        }
      }
    }
    if (isset($_GET)) {
      // $formFilter->populate($_GET);
    }
    $page = $this->_getParam('page', 1);
    $this->view->paginator = $data = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getDecisionmakerPaginator(array(
      'epetition_id' => $epetition_id,
      'orderby' => 'decisionmaker_id',
    ));
    $this->view->paginator->setItemCountPerPage(10);
    $this->view->paginator->setCurrentPageNumber($page);
  }

  public function changeEnableDeisionMakerAction()  //for decisionmaker
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id']) && isset($_POST['type'])) {
      $data = Engine_Api::_()->getItem('epetition_decisionmaker', $_POST['id']);
      if (count($data) > 0) {
        $data->enabled = $_POST['type'];
        if ($data->save()) {
          echo 1;
          exit();
        }
      }
    }
  }

  public function getusersAction()
  {
    $sesdata = array();
    $id = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($id);
    $allUserId = Engine_Api::_()->getDbTable('decisionmakers', 'epetition')->getAllUserId($epetition_id);
    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $users_table->select()
      ->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%');
    if (isset($allUserId) && count($allUserId) > 0) {
      $select = $select->where("user_id NOT IN (?)", $allUserId);
    }
    $select = $select->order('displayname ASC')->limit('40');
    $users = $users_table->fetchAll($select);


    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
        'id' => $user->user_id,
        'label' => $user->displayname,
        'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function petitionCloseAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $epetition = Engine_Api::_()->getItem('epetition', $_POST['id']);;
      $epetition->victory = 2;
      $epetition->save();
      $sender = Engine_Api::_()->getItem('user', $epetition['owner_id']);
      // All user id
      $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
      $signuser = Engine_Api::_()->getDbtable('signatures', 'epetition')->signAllUser($epetition->epetition_id);
      $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($epetition->epetition_id);
      $title = $epetition['title'];
      foreach ($super_admin as $admin) {
        if ($epetition['owner_id'] != $admin['user_id']) {
          $admin_obj = Engine_Api::_()->getItem('user', $admin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin_obj->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $title . " petition closed",
            'message' => " Petition <a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>  has been closed.",
          ));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_close', array('title' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }
      }

      // send email and notification for user
      foreach ($signuser as $signuse) {
        if ($epetition['owner_id'] != $admin['user_id']) {
          $viewer_user = Engine_Api::_()->getItem('user', $signuse['owner_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_user->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $title . " petition closed",
            'message' => " Petition <a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>  has been closed.",
          ));

          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_close', array('title' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }
      }

      // send email and notification for decision maker
      foreach ($decisionMaker as $dem) {
        if ($epetition['owner_id'] != $admin['user_id']) {
          $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $title . " petition closed",
            'message' => " Petition <a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>  has been closed.",
          ));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_close', array('title' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }
      }
      $arr = array();
      $arr['status'] = 1;
      $arr['msg'] = "This petition close successfully";
      echo json_encode($arr);
      exit();
    }
    $slug = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
    $this->view->petition = $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);

  }

  public function addDecisionMakerAction()
  {
    $this->view->form = $form = new Epetition_Form_Dashboard_Decisionmaker();

    $table = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->createRow();
    $slug = $this->_getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getItemTable('epetition', 'epetition')->getPetitionId($slug);
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {

      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      $values = $form->getValues();
      $table->user_id = $values['user_id'];
      $table->epetition_id = $epetition_id;
      $table->created_date = date("Y-m-d H:i:s");
      $table->created_by = $viewer_id;
      $table->save();
      $receiver = Engine_Api::_()->getItem('user', $values['user_id']);
      $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);
      $sender = Engine_Api::_()->getItem('user', $epetition['owner_id']);

      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($sender, $epetition, 'adddecisionac',null, array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'dec' => "<a href=" . $receiver->getHref() . ">" . $receiver->getTitle() . "</a>", 'title' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      if ($action) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
      }

      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($receiver, $sender, $epetition, 'epetition_adddecision', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));


      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have added successfully.'))
      ));
    }
  }

}
