<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Plugin_Core extends Zend_Controller_Plugin_Abstract  {

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
      $arrayOfManifestUrl[] = $settings->getSetting('classroom.singular.manifest', 'course').'/';
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
     $settings =  Engine_Api::_()->getApi('settings', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();  //echo "<pre>"; print_r($request);die;
    $moduleName = $request->getModuleName();
    $actionName = $request->getActionName();
    $controllerName = $request->getControllerName();
    $headScript = new Zend_View_Helper_HeadScript();
    $script = '';
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Courses/externals/scripts/core.js');
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('course.icon.open.smoothbox', 1) && $moduleName == 'courses' || ($moduleName == 'eclassroom' && $controllerName == 'dashboard' && $actionName == 'manage-courses') ){ 
       $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')  .'externals/autocompleter/Observer.js'); 
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')  .'externals/autocompleter/Autocompleter.js'); 
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')  .'externals/autocompleter/Autocompleter.Local.js'); 
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')  .'externals/autocompleter/Autocompleter.Request.js'); 
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')  . 'externals/tinymce/tinymce.min.js'); 
    } 
    $checkWelcomeCourse = $settings->getSetting('courses.check.welcome', 2); 
    $checkWelcomeEnable = $settings->getSetting('courses.enable.welcome', 1);
    $checkWelcomeCourse = (($checkWelcomeCourse == 1 && $viewer->getIdentity() == 0) ? true : (($checkWelcomeCourse == 0 && $viewer->getIdentity() != 0) ? true : (($checkWelcomeCourse == 2) ? true : false)));
    if (!$checkWelcomeEnable)
      $checkWelcomeCourse = false;
    if ($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'courses') {
      $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
      if (!$checkWelcomeCourse)
        $redirector->gotoRoute(array('module' => 'courses', 'controller' => 'index', 'action' => 'home'), 'courses_general', false);
      else if ($checkWelcomeEnable == 2)
        $redirector->gotoRoute(array('module' => 'courses', 'controller' => 'index', 'action' => 'browse'), 'courses_general', false);
      else if ($checkWelcomeEnable == 3)
        $redirector->gotoRoute(array('module' => 'courses', 'controller' => 'category', 'action' => 'browse'), 'courses_category', false);
    }
    $cartviewPage = 0;
    if($moduleName =='courses' && $actionName == 'checkout' && $controllerName == 'cart'): 
      $cartviewPage = 1;
    else:
      $cartviewPage = 0;
    endif; 
    $script .= "var cartviewPage = ".$cartviewPage.";";
    if ($moduleName == 'courses' && $actionName == 'index' && $controllerName == 'profile') {
      $bagroundImageId = Engine_Api::_()->core()->getSubject('courses')->photo_id;
      if ($bagroundImageId != 0 && $bagroundImageId != '') {
        $backgroundImage = Engine_Api::_()->storage()->get($bagroundImageId, '')->getPhotoUrl();
      }
      if (isset($backgroundImage)) {
//         $script .= "window.addEvent('domready', function() {document.getElementById('global_wrapper').style.backgroundImage = \"url('" . $backgroundImage . "')\";});";
      }
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Courses/externals/styles/styles.css');
    }
   
    $cartTotal = "0";
		if($settings->getSetting('courses.pluginactivated')) {
		$totalCourse = Engine_Api::_()->courses()->cartTotalPrice();
			if($totalCourse['cartCoursesCount']){
					$cartTotal = ($totalCourse['cartCoursesCount']);
			}
		}
    $singlecart = Engine_Api::_()->getApi('settings', 'core')->getSetting('site.enble.singlecart', 0); // this setting is using from sesbasic plugin
    $html = '<span class="cart_value courses_cart_count">'.$cartTotal.'</span>';
		if($settings->getSetting('courses.cartviewtype',1)== '1') {
			$script .= "sesJqueryObject(document).ready(function(){
				sesJqueryObject('.courses_add_cart_dropdown').append('".$html."');";
		}
		elseif($settings->getSetting('courses.cartviewtype', '2') == 2) {
			$script .= "sesJqueryObject(document).ready(function(){
				sesJqueryObject('.courses_add_cart_dropdown').append('".$html."');";
    }else if($settings->getSetting('courses.cartviewtype', '3') == '3'){
			$script .= "sesJqueryObject(document).ready(function(){
			sesJqueryObject('.courses_add_cart_dropdown').append('".$html."');";
		}
		$script .= "
		var valueCart = sesJqueryObject('.courses_cart_count').html();
		if(parseInt(valueCart) <=0 || !valueCart){
			sesJqueryObject('.courses_cart_count').hide();
		}});";
		if($settings->getSetting('courses.cartdropdown',1) && !$singlecart){
			$script .= "sesJqueryObject(document).on('click','.courses_add_cart_dropdown',function(e){
				e.preventDefault();
				if(sesJqueryObject(this).hasClass('active')){
						sesJqueryObject('.courses_cart_dropdown').hide();
						sesJqueryObject('.courses_add_cart_dropdown').removeClass('active');
						return;
				}
				sesJqueryObject('.courses_add_cart_dropdown').addClass('active');
				if(!sesJqueryObject(this).parent().find('.courses_cart_dropdown').length){
						sesJqueryObject(this).parent().append('<div class=\"courses_cart_dropdown sesbasic_header_pulldown sesbasic_clearfix sesbasic_bxs sesbasic_cart_pulldown\"><div class=\"sesbasic_header_pulldown_inner\"><div class=\"sesbasic_header_pulldown_loading\"><img src=\"application/modules/Core/externals/images/loading.gif\" alt=\"Loading\" /></div></div></div>');
				}
				sesJqueryObject('.courses_cart_dropdown').show();
				sesJqueryObject.post('courses/cart/view',{cart_page:cartviewPage},function(res){
						sesJqueryObject('.courses_cart_dropdown').html(res);
				});
			});";
			$script .= "
				sesJqueryObject(document).click(function(e){
				var elem = sesJqueryObject('.courses_cart_dropdown').parent();
				if(!elem.has(e.target).length){
					 sesJqueryObject('.courses_cart_dropdown').hide();
					 sesJqueryObject('.courses_add_cart_dropdown').removeClass('active');
				}
			});";
		}
    if(!$settings->getSetting('eclassroom.enable.course', 1)) { 
      $openPopup = $settings->getSetting('courses.icon.open.smoothbox', 1);
      $script .= "var isOpenCoursePopup = '" . $openPopup . "';var showAddnewCourseIconShortCut = " . $settings->getSetting('courses.enable.addcourseshortcut', 1) . ";";
      // Check sesalbum plugin is enabled for lightbox
      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
        $script .= "var sesAlbumEnabled = 1;";
      } else {
        $script .= "var sesAlbumEnabled = 0;";
      }
      if(($moduleName == 'courses') && ($controllerName != "index" || $actionName != "create") && ($controllerName != "dashboard" || $actionName != "edit") && $viewer->getIdentity() != 0 && Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'create')) {
        $script .= 'sesJqueryObject(document).ready(function() {
          if(sesJqueryObject("body").attr("id").search("courses") > -1 && typeof showAddnewCourseIconShortCut != "undefined" && showAddnewCourseIconShortCut && typeof isOpenCoursePopup != "undefined" && isOpenCoursePopup == 1){
            sesJqueryObject("<a class=\'sesbasic_create_button courses_quick_create_button sessmoothbox sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'courses_general') . '\' title=\'Add New Courses\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
          }
          else if(sesJqueryObject("body").attr("id").search("courses") > -1 && typeof showAddnewCourseIconShortCut != "undefined" && showAddnewCourseIconShortCut){
            sesJqueryObject("<a class=\'sesbasic_create_button courses_quick_create_button sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'courses_general') . '\' title=\'Add New Courses\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
          }
        });';
      }
      $script .= "var coursesURL = '" . $settings->getSetting('courses.plural.manifest', 'courses') . "';";
      $script .= "var courseURL = '" . $settings->getSetting('courses.singular.manifest', 'course') . "';";
    }
    $view->headScript()->appendScript($script);
  }
  protected function insertCourseLikeCommentDetails($payload, $type) {
    if(!empty($payload->resource_type) && $payload->resource_type == 'courses' && $type == "core_like") {
      $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $item = $table->createRow();
        $item->resource_type = 'courses';
        $item->resource_id = $payload->resource_id;
        $item->poster_type = "user";
        $item->poster_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->creation_date = date('Y-m-d H:i:s');
        $item->save();
        $db->commit();
      } catch (Exception $e) {}
    }
    if (!empty($payload->poster_type) && $payload->poster_type == "courses"){ 
      $table = Engine_Api::_()->getDbTable('activitycomments', 'courses');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $itemTable = Engine_Api::_()->getDbTable('activitycomments', 'courses');
        $item = $itemTable->createRow();
        $item->type = $type;
        $item->item_id = !empty($payload->like_id) ? $payload->like_id : $payload->getIdentity();
        $item->course_id = $payload->poster_id;
        $item->course_type = "courses";
        $item->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->user_type = 'user';
        $item->save();
        $db->commit();
      } catch (Exception $e){throw $e;}
    }
  }

  public function onActivityCommentCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertCourseLikeCommentDetails($payload, 'activity_comment');
  }

  public function onActivityLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertCourseLikeCommentDetails($payload, 'activity_like');
  }

  public function onCoreLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertCourseLikeCommentDetails($payload, 'core_like');
  }
  protected function deleteLikeComment($payload, $type){
    if ($payload) {
      if (!empty($payload->poster_type) && @$payload->poster_type == "courses") {
        $table = Engine_Api::_()->getDbTable('activitycomments', 'courses');
        $select = $table->select()->where('item_id =?', $payload->getIdentity())->where('type =?', $type);
        $result = $table->fetchRow($select);
        if ($result)
          $result->delete();
      }
    }
  }
  public function onCoreCommentDeleteAfter($event) {
    $payload = $event->getPayload();
    $this->deleteLikeComment($payload, 'core_comment');
  }

  public function onActivityCommentDeleteAfter($event) {
    $payload = $event->getPayload();
    $this->deleteLikeComment($payload, 'activity_comment');
  }

  public function onActivityLikeDeleteAfter($event) {
    $payload = $event->getPayload();
    $this->deleteLikeComment($payload, 'activity_like');
  }

  public function onCoreLikeDeleteAfter($event) {
    $payload = $event->getPayload();
    if ($payload)
      $this->deleteLikeComment($payload, 'core_comment');
  }

  public function onCoreLikeDeleteBefore($event) {
    $payload = $event->getPayload();
    if ($payload) {
      if (!empty($payload->resource_type ) && @$payload->resource_type == 'courses') {
        $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
        $select = $table->select()->where('resource_id =?', $payload->resource_id)->where('resource_type =?', 'courses')->where('poster_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
        $result = $table->fetchRow($select);
        if ($result)
          $result->delete();
      }
    }
  }

  public function onCommentCreateAfter($event) {
    $payload = $event->getPayload();
    $this->insertCourseLikeCommentDetails($payload, $payload->getType());
  }

  public function multiPost($payload, $viewer) {
    $res_type = $payload->object_type;
    $res_id = $payload->object_id;
    $main_action_id = $payload->getIdentity();
    //check course enable scroll posting
    $viewer_id = $viewer->getIdentity();
    $course = Engine_Api::_()->getItem('courses', $res_id);

    $db = Engine_Db_Table::getDefaultAdapter();
    $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
    foreach ($_POST['multicourse'] as $courseGuid) {
      $course = Engine_Api::_()->getItemByGuid($courseGuid);
      $course_id = $course->getIdentity();
      if (!$course)
        continue;
      $courseOwner = $course->getOwner();
      if (!$courseOwner)
        continue;
      $courseOwnerId = $courseOwner->getIdentity();

      $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
      $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
      if (!$action_id)
        continue;

      $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
      $action->subject_id = $viewer->getIdentity();
      $action->object_id = $course_id;
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
    if (!empty($_POST['multicourse'])) {
      $this->multiPost($payload, $viewer);
    }

//     //this is only for status post.
//     if($payload->type == 'post') {
//       $course = Engine_Api::_()->getItem('courses', $payload->object_id);
//       $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $course, 'courses_course_postedpost', null);
//     }
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
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.pluginactivated'))
      return;
    $courseTable = Engine_Api::_()->getItemTable('courses');
    $select = new Zend_Db_Select($courseTable->getAdapter());
    $select->from($courseTable->info('name'), 'COUNT(course_id) as count')->where('is_approved = ?', 0);
    $data = $select->query()->fetch();
    if (empty($data['count'])) {
    return;
    }
    $translate = Zend_Registry::get('Zend_Translate');
    $message = vsprintf($translate->translate(array(
                'There is <a href="%s">%d new course</a> awaiting your approval.',
                'There are <a href="%s">%d new courses</a> awaiting your approval.',
                $data['count']
            )), array(
        Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'courses', 'controller' => 'manage'), 'admin_default', true) . '?is_approved=0',
        $data['count'],
    ));
    $event->addResponse($message);
  }
  function onUserDeleteBefore($event){
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
      $coursetable = Engine_Api::_()->getDbTable('courses','courses');
      $classroomtable = Engine_Api::_()->getDbTable('classrooms','eclassroom');
      $select = $classroomtable->select()->where('owner_id =?',$user_id);
      $classrooms = $classroomtable->fetchAll($select);
      foreach($classrooms as $item){
        $classroom = Engine_Api::_()->getItem('classroom', $item->classroom_id);
        if(!empty($classroom))
            Engine_Api::_()->courses()->deleteClassroom($classroom);
      }
      $select = $coursetable->select()->where('owner_id =?',$user_id);
      $items = $coursetable->fetchAll($select);
      foreach($items as $item){
        $course = Engine_Api::_()->getItem('courses', $item->course_id);
        if(!empty($course))
            Engine_Api::_()->courses()->deleteCourse($course);
      }
    }
  }
  public function onUserLoginAfter($event)
  { 
    $payload = $event->getPayload(); 
    if( !($payload instanceof User_Model_User) ) {
      return;
    }
    $phpSessionId = session_id();
    $table = Engine_Api::_()->getDbTable('carts', 'courses');
    $select = $table->select();
    $select->where('phpsessionid =?', $phpSessionId);
    $cart =  $table->fetchRow($select);
    $select = $table->select();
    $select->where('owner_id =?', $payload->getIdentity());
    $loggedInUsercart =  $table->fetchRow($select);
    if($cart){
       if($loggedInUsercart){
           $cartcoursesTable = Engine_Api::_()->getDbTable('cartcourses','courses');
           $cartcoursesTable->update(array('cart_id' => $loggedInUsercart->cart_id), array('cart_id' => $cart->cart_id));
        } else {
          $table->update(array('owner_id' => $payload->getIdentity()), array('phpsessionid =?' => $phpSessionId));
        }
    }
  }
}
