<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Plugin_Core extends Zend_Controller_Plugin_Abstract  {

  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $moduleName = $request->getModuleName();
    if (substr($request->getPathInfo(), 1, 6) == "admin/") {
        $headScript = new Zend_View_Helper_HeadScript();
        if($moduleName == "courses")
            $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
      return;
    }
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();
    if((COURSESENABLED == 1) && (($moduleName == 'core' && $controllerName != 'comment' && $controllerName != 'widget') || ($moduleName == 'courses'))) {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $arrayOfManifestUrl[] = $settings->getSetting('classroom.singular.manifest', 'classroom').'/';
      $replacedPath = trim(str_replace($arrayOfManifestUrl,'',$request->getPathInfo()),'/');
      $exploded = (explode('/',$replacedPath));
      $urlData = Engine_Api::_()->sesbasic()->checkBannedWord($exploded[0],"",$routeType = 1);
      if($urlData && $urlData->resource_type == 'courses') {
        $request->setModuleName('courses');
        $request->setControllerName('profile');
        $request->setActionName('index');
        $request->setParams(array('id' => $exploded[0]));
      }
    }
  }

  public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event, 'simple');
  }
  public function onRenderLayoutDefault($event) {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();//echo "<pre>";print_r($request);die;
    $moduleName = $request->getModuleName();
    $actionName = $request->getActionName();
    $controllerName = $request->getControllerName();
    $headScript = new Zend_View_Helper_HeadScript();
    $script = '';
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Eclassroom/externals/scripts/core.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Eclassroom/externals/scripts/activitySwitchClassroom.js');
    $checkWelcomeCourse = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.check.welcome', 2);
    $checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.page.redirect', 1);
    $checkWelcomeCourse = (($checkWelcomeCourse == 1 && $viewer->getIdentity() == 0) ? true : (($checkWelcomeCourse == 0 && $viewer->getIdentity() != 0) ? true : (($checkWelcomeCourse == 2) ? true : false)));
    if (!$checkWelcomeEnable)
      $checkWelcomeCourse = false;
    if ($actionName == 'home' && $controllerName == 'index' && $moduleName == 'eclassroom') {
      $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
      if ($checkWelcomeEnable == 2)
        $redirector->gotoRoute(array('module' => 'eclassroom', 'controller' => 'index', 'action' => 'browse'), 'eclassroom_general', false);
      else if ($checkWelcomeEnable == 3)
        $redirector->gotoRoute(array('action' => 'browse'), 'eclassroom_category', false);
    }
    if ($moduleName == 'eclassroom' && $actionName == 'index' && $controllerName == 'profile') {
      $bagroundImageId = Engine_Api::_()->core()->getSubject('classroom')->background_photo_id;
      if ($bagroundImageId != 0 && $bagroundImageId != '') {
        if(Engine_Api::_()->storage()->get($bagroundImageId, ''))
          $backgroundImage = Engine_Api::_()->storage()->get($bagroundImageId, '')->getPhotoUrl();
      }
      if (isset($backgroundImage)) {
        $script .= "window.addEvent('domready', function() {document.getElementById('global_wrapper').style.backgroundImage = \"url('" . $backgroundImage . "')\";});";
      }
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Courses/externals/styles/styles.css');
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Courses/externals/styles/style_profile.css');
    }
    $openPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.icon.open.smoothbox', 1);
    $script .= "var isOpenClassroomPopup = '" . $openPopup . "';var showAddnewClassroomIconShortCut = ". Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.addclassshortcut', 1). ";";
    // Check sesalbum plugin is enabled for lightbox
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
      $script .= "var sesAlbumEnabled = 1;";
    } else {
      $script .= "var sesAlbumEnabled = 0;";
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.follow', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.integration', 0)) {
      $script .= "var classroomFollowIntegrate = 1;";
    } else {
      $script .= "var classroomFollowIntegrate = 0;";
    }
    if (($moduleName == 'eclassroom') && $viewer->getIdentity() != 0 && Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'create')) {
      $script .= 'sesJqueryObject(document).ready(function() {
			if(sesJqueryObject("body").attr("id").search("eclassroom") > -1 && typeof showAddnewClassroomIconShortCut != "undefined" && showAddnewClassroomIconShortCut && typeof isOpenClassroomPopup != "undefined" && isOpenClassroomPopup == 1){
				sesJqueryObject("<a class=\'sesbasic_create_button classroom_quick_create_button sessmoothbox sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'eclassroom_general') . '\' title=\'Add New Classroom\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
            else if(sesJqueryObject("body").attr("id").search("eclassroom") > -1 && typeof showAddnewClassroomIconShortCut != "undefined" && showAddnewClassroomIconShortCut){
				sesJqueryObject("<a class=\'sesbasic_create_button classroom_quick_create_button sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'eclassroom_general') . '\' title=\'Add New Classroom\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
		});';
    }
    $script .= "var courseURL = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('classroom.plural.manifest', 'classrooms') . "';";
    $view->headScript()->appendScript($script);
  }
  protected function insertClassroomLikeCommentDetails($payload, $type) {

    if(!empty($payload->resource_type) && $payload->resource_type == 'classroom' && $type == "core_like") {
      $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $item = $table->createRow();
        $item->resource_type = 'classroom';
        $item->resource_id = $payload->resource_id;
        $item->poster_type = "user";
        $item->poster_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->creation_date = date('Y-m-d H:i:s');
        $item->save();
        $db->commit();
      } catch (Exception $e) {}
    }
    if (!empty($payload->poster_type) && $payload->poster_type == "classroom"){
      $table = Engine_Api::_()->getDbTable('activitycomments', 'eclassroom');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $itemTable = Engine_Api::_()->getDbTable('activitycomments', 'eclassroom');
        $item = $itemTable->createRow();
        $item->type = $type;
        $item->item_id = !empty($payload->like_id) ? $payload->like_id : $payload->getIdentity();
        $item->classroom_id = $payload->poster_id;
        $item->classroom_type = "classroom";
        $item->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->user_type = 'user';
        $item->save();
        $db->commit();
      } catch (Exception $e){throw $e;}
    }
  }

  public function onActivityCommentCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertClassroomLikeCommentDetails($payload, 'activity_comment');
  }
  public function onActivityLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertClassroomLikeCommentDetails($payload, 'activity_like');
  }

  public function onCoreLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertClassroomLikeCommentDetails($payload, 'core_like');
  }

  protected function delteLikeComment($payload, $type){
    if ($payload) {
      if (!empty($payload->poster_type) && @$payload->poster_type == "classroom") {
        $table = Engine_Api::_()->getDbTable('activitycomments', 'eclassroom');
        $select = $table->select()->where('item_id =?', $payload->getIdentity())->where('type =?', $type);
        $result = $table->fetchRow($select);
        if ($result)
          $result->delete();
      }
    }
  }
  public function onCoreCommentDeleteAfter($event) {
    $payload = $event->getPayload();
    $this->delteLikeComment($payload, 'core_comment');
  }
  public function onActivityCommentDeleteAfter($event) {
    $payload = $event->getPayload();
    $this->delteLikeComment($payload, 'activity_comment');
  }

  public function onActivityLikeDeleteAfter($event) {
    $payload = $event->getPayload();
    $this->delteLikeComment($payload, 'activity_like');
  }

  public function onCoreLikeDeleteAfter($event) {
    $payload = $event->getPayload();
    if ($payload)
      $this->delteLikeComment($payload, 'core_comment');
  }

  public function onCoreLikeDeleteBefore($event) {
    $payload = $event->getPayload();
    if ($payload) {
      if (!empty($payload->resource_type ) && @$payload->resource_type == 'classroom') {
        $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
        $select = $table->select()->where('resource_id =?', $payload->resource_id)->where('resource_type =?', 'classroom')->where('poster_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
        $result = $table->fetchRow($select);
        if ($result)
          $result->delete();
      }
    }
  }

  public function onCommentCreateAfter($event) {
    $payload = $event->getPayload();
    $this->insertClassroomLikeCommentDetails($payload, $payload->getType());
  }

  public function multiPost($payload, $viewer) {
    $res_type = $payload->object_type;
    $res_id = $payload->object_id;
    $main_action_id = $payload->getIdentity();
    //check classroom enable scroll posting
    $viewer_id = $viewer->getIdentity();
    $classroom = Engine_Api::_()->getItem('classroom', $res_id);

    $db = Engine_Db_Table::getDefaultAdapter();
    $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
    foreach ($_POST['multiclassroom'] as $classroomGuid) {
      $classroom = Engine_Api::_()->getItemByGuid($classroomGuid);
      $classroom_id = $classroom->getIdentity();
      if (!$classroom)
        continue;
      $classroomOwner = $classroom->getOwner();
      if (!$classroomOwner)
        continue;
      $classroomOwnerId = $classroomOwner->getIdentity();

      $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
      $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
      if (!$action_id)
        continue;
      $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
      $action->subject_id = $viewer->getIdentity();
      $action->object_id = $classroom_id;
      $action->save();
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_type = '';
        $detailAction->sesresource_id = '';
        $detailAction->save();
      }
      $select = "SELECT * FROM `engine4_sesbasic_locations` WHERE resource_type = 'activity_action' AND resource_id = " . $main_action_id;
      $this->createRowCustom($db, $main_action_id, $select, 'engine4_sesbasic_locations', 'location_id');
      $table->resetActivityBindings($action);
      $select = "INSERT INTO engine4_activity_attachments (action_id,type,id,mode) SELECT '" . $action_id . "',type,id,mode FROM `engine4_activity_attachments` WHERE action_id = " . $main_action_id;
      $db->query($select);
      $select = "SELECT * FROM `engine4_sesadvancedactivity_buysells` WHERE action_id = " . $main_action_id;
      $buysell_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_sesadvancedactivity_buysells', 'buysell_id');
      $buysell = Engine_Api::_()->getItem('sesadvancedactivity_buysell', $buysell_id);
      if ($buysell) {
        $buysell->action_id = $action_id;
        $buysell->save();
      }
      $select = "INSERT INTO engine4_sesadvancedactivity_hashtags (action_id,title) SELECT '" . $action_id . "',title FROM `engine4_sesadvancedactivity_hashtags` WHERE action_id = " . $main_action_id;
      $db->query($select);
      $select = "INSERT INTO engine4_sesadvancedactivity_tagusers (action_id,user_id) SELECT '" . $action_id . "',user_id FROM `engine4_sesadvancedactivity_tagusers` WHERE action_id = " . $main_action_id;
      $db->query($select);
      $select = "INSERT INTO engine4_sesadvancedactivity_tagitems (action_id,resource_id,resource_type,user_id) SELECT '" . $action_id . "','resource_id','resource_type','user_id' FROM `engine4_sesadvancedactivity_tagusers` WHERE action_id = " . $main_action_id;
      $db->query($select);
      $select = "SELECT * FROM `engine4_sesadvancedactivity_targetpost` WHERE action_id = " . $main_action_id;
      $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_sesadvancedactivity_targetpost', 'targetpost_id');
      $action->save();
    }
  }

  public function onActivitySubmittedAfter($event) {
    if (!Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity'))
      return true;
    $payload = $event->getPayload();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!empty($_POST['multiclassroom'])) {
      $this->multiPost($payload, $viewer);
    }

    //this is only for status post.
    if($payload->type == 'post') {
//       $classroom = Engine_Api::_()->getItem('classroom', $payload->object_id);
//       $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $classroom, 'eclassroom_classroom_postedpost', null);
    }

    //cross posting work
    if (!empty($_POST['crosspostVal']) && Engine_Api::_()->authorization()->isAllowed('classroom', Engine_Api::_()->user()->getViewer(), 'auth_crosspost') && !empty($payload->object_type) && $payload->object_type == "classroom" && Engine_Api::_()->getItem('classroom', $payload->object_id)->getOwner()->getIdentity() == $viewer->getIdentity()) {
      $res_type = $payload->object_type;
      $res_id = $payload->object_id;
      $main_action_id = $payload->getIdentity();
      //check classroom enable scroll posting
      $crossPosts = null;//Engine_Api::_()->getDbTable('crossposts', 'eclassroom')->getCrossposts(array('classroom_id' => $res_id, 'receiver_approved' => true));

      if (!count($crossPosts))
        return true;
      $attributionType = 1;
      $classroomAttributionType = Engine_Api::_()->authorization()->isAllowed('classroom', $viewer, 'seb_attribution');
      $allowUserChooseClassroomAttribution = Engine_Api::_()->authorization()->isAllowed('classroom', $viewer, 'auth_defattribut');
      if (!$classroomAttributionType || $attributionType == 0) {
        $isClassroomSubject = 'user';
      }
      if ($classroomAttributionType && !$allowUserChooseClassroomAttribution) {
        $isClassroomSubject = 'classroom';
      }
      if ($classroomAttributionType && $allowUserChooseClassroomAttribution && $attributionType == 1) {
        $isClassroomSubject = 'classroom';
      }
      $db = Engine_Db_Table::getDefaultAdapter();
      $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
      foreach ($crossPosts as $crossPost) {
        $classroom_id = $crossPost['sender_classroom_id'] != $res_id ? $crossPost['sender_classroom_id'] : $crossPost['receiver_classroom_id'];
        $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
        if (!$classroom)
          continue;
        $classroomOwner = $classroom->getOwner();

        if (!$classroomOwner)
          continue;
        $classroomOwnerId = $classroomOwner->getIdentity();

        $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
        $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
        if (!$action_id)
          continue;
        $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
        $action->subject_id = $classroomOwnerId;
        $action->object_id = $classroom_id;
        if ($isClassroomSubject == "classroom") {
          $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
          if($detail_id) {
            $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
            $detailAction->sesresource_type = 'classroom';
            $detailAction->sesresource_id = $classroom_id;
            $detailAction->save();
          }
        }
        $action->save();
        $select = "SELECT * FROM `engine4_sesbasic_locations` WHERE resource_type = 'activity_action' AND resource_id = " . $main_action_id;
        $this->createRowCustom($db, $main_action_id, $select, 'engine4_sesbasic_locations', 'location_id');

        $table->resetActivityBindings($action);

        $select = "SELECT * FROM `engine4_sesadvancedactivity_details` WHERE action_id = " . $main_action_id;
        $this->createRowCustom($db, $main_action_id, $select, 'engine4_sesadvancedactivity_details', 'detail_id',$action->getIdentity());

        $select = "INSERT INTO engine4_activity_attachments (action_id,type,id,mode) SELECT '" . $action_id . "',type,id,mode FROM `engine4_activity_attachments` WHERE action_id = " . $main_action_id;
        $db->query($select);

        $select = "SELECT * FROM `engine4_sesadvancedactivity_buysells` WHERE action_id = " . $main_action_id;
        $buysell_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_sesadvancedactivity_buysells', 'buysell_id');
        $buysell = Engine_Api::_()->getItem('sesadvancedactivity_buysell', $buysell_id);
        if ($buysell) {
          $buysell->action_id = $action_id;
          $buysell->save();
        }
        $select = "INSERT INTO engine4_sesadvancedactivity_hashtags (action_id,title) SELECT '" . $action_id . "',title FROM `engine4_sesadvancedactivity_hashtags` WHERE action_id = " . $main_action_id;
        $db->query($select);

        $select = "INSERT INTO engine4_sesadvancedactivity_tagusers (action_id,user_id) SELECT '" . $action_id . "',user_id FROM `engine4_sesadvancedactivity_tagusers` WHERE action_id = " . $main_action_id;
        $db->query($select);

        $select = "INSERT INTO engine4_sesadvancedactivity_tagitems (action_id,resource_id,resource_type,user_id) SELECT '" . $action_id . "','resource_id','resource_type','user_id' FROM `engine4_sesadvancedactivity_tagusers` WHERE action_id = " . $main_action_id;
        $db->query($select);
        $select = "SELECT * FROM `engine4_sesadvancedactivity_targetpost` WHERE action_id = " . $main_action_id;
        $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_sesadvancedactivity_targetpost', 'targetpost_id');
        $action->save();
      }
    }
  }
  protected function createRowCustom($db, $main_action_id, $select, $tablename, $columnName,$action_id = 0) {
    $db->query("CREATE TEMPORARY TABLE tmptable_" . $main_action_id . " " . $select);
    $db->query("UPDATE tmptable_" . $main_action_id . " SET " . $columnName . " = NULL;");
    if($action_id && $columnName == "detail_id"){
      $db->query("UPDATE tmptable_" . $main_action_id . " SET action_id = ".$action_id.";");
    }
    $db->query("INSERT INTO " . $tablename . " SELECT * FROM tmptable_" . $main_action_id . ";");
    $insertId = $db->lastInsertId();
    $db->query("DROP TEMPORARY TABLE IF EXISTS tmptable_" . $main_action_id . ";");
    return $insertId;
  }

  public function getAdminNotifications($event) {
    // Awaiting approval
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.pluginactivated'))
      return;
    $classroomTable = Engine_Api::_()->getItemTable('classroom');
    $select = new Zend_Db_Select($classroomTable->getAdapter());
    $select->from($classroomTable->info('name'), 'COUNT(classroom_id) as count')->where('is_approved = ?', 0);
    $data = $select->query()->fetch();
    if (empty($data['count'])) {
      return;
    }
    $translate = Zend_Registry::get('Zend_Translate');
    $message = vsprintf($translate->translate(array(
                'There is <a href="%s">%d new classroom</a> awaiting your approval.',
                'There are <a href="%s">%d new classroom</a> awaiting your approval.',
                $data['count']
            )), array(
        Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'eclassroom', 'controller' => 'manage'), 'admin_default', true) . '?is_approved=0',
        $data['count'],
    ));
    $event->addResponse($message);
  }
  function onUserDeleteBefore($event){
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
      $table = Engine_Api::_()->getDbTable('classrooms','eclassroom');
      $select = $table->select()->where('owner_id =?',$user_id);
      $items = $table->fetchAll($select);
      foreach($items as $item){
        $classroom = Engine_Api::_()->getItem('classrooms', $item->classroom_id);
        if(!empty($classroom))
            Engine_Api::_()->eclassroom()->deleteClassroom($classroom);
      }
    }
  }
}
