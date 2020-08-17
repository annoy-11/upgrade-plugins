<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Plugin_Core extends Zend_Controller_Plugin_Abstract  {
  
  
  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
  
    if (substr($request->getPathInfo(), 1, 6) == "admin/") {
      return;
    }    
    $moduleName = $request->getModuleName();
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if((SESPAGEURLENABLED == 1 && $settings->getSetting('sespage.enable.shorturl', 0)) && (($moduleName == 'core' && $controllerName != 'comment' && $controllerName != 'widget') || ($moduleName == 'sespage' && $controllerName == 'profile' && $actionName == 'index'))) {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $arrayOfManifestUrl[] = $settings->getSetting('sespage.page.manifest', 'page-directory').'/';
      $replacedPath = trim(str_replace($arrayOfManifestUrl,'',$request->getPathInfo()),'/');
      $exploded = (explode('/',$replacedPath));
      $isShortURL = true;
      if($settings->getSetting('sespage.shorturl.onlike', 0)) {
        $likeCount = Engine_Api::_()->sespage()->getPageLikeCount($exploded[0]);
        if($likeCount < $settings->getSetting('sespage.countlike', 10))
          $isShortURL = false;
      }
      $urlData = Engine_Api::_()->sesbasic()->checkBannedWord($exploded[0],"",$routeType = 1);
      if($urlData && $urlData->resource_type == 'sespage_page' && $isShortURL) {
        $request->setModuleName('sespage');
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
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $actionName = $request->getActionName();
    $controllerName = $request->getControllerName();
    $headScript = new Zend_View_Helper_HeadScript();
    $script = '';
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sespage/externals/scripts/core.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sespage/externals/scripts/activitySwitchPage.js');
    $checkWelcomePage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.check.welcome', 2);
    $checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.enable.welcome', 1);
    $checkWelcomePage = (($checkWelcomePage == 1 && $viewer->getIdentity() == 0) ? true : (($checkWelcomePage == 0 && $viewer->getIdentity() != 0) ? true : (($checkWelcomePage == 2) ? true : false)));
    if (!$checkWelcomeEnable)
      $checkWelcomePage = false;
    if ($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sespage') {
      $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
      if (!$checkWelcomePage)
        $redirector->gotoRoute(array('module' => 'sespage', 'controller' => 'index', 'action' => 'home'), 'sespage_general', false);
      else if ($checkWelcomeEnable == 2)
        $redirector->gotoRoute(array('module' => 'sespage', 'controller' => 'index', 'action' => 'browse'), 'sespage_general', false);
    }

    if ($moduleName == 'sespage' && $actionName == 'index' && $controllerName == 'profile') {
      $bagroundImageId = Engine_Api::_()->core()->getSubject('sespage_page')->background_photo_id;
      if ($bagroundImageId != 0 && $bagroundImageId != '') {
        $backgroundImage = Engine_Api::_()->storage()->get($bagroundImageId, '')->getPhotoUrl();
      }
      if (isset($backgroundImage)) {
        $script .= "window.addEvent('domready', function() {document.getElementById('global_wrapper').style.backgroundImage = \"url('" . $backgroundImage . "')\";});";
      }
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Sespage/externals/styles/styles.css');
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Sespage/externals/styles/style_profile.css');
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 0)) {
      $openPopup = 0;
    } else {
      $openPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.icon.open.smoothbox', 1);
    }
    $script .= "var isOpenPagePopup = '" . $openPopup . "';var showAddnewPageIconShortCut = " . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.enable.addpageshortcut', 1) . ";
  ";

    // Check sesalbum plugin is enabled for lightbox
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
      $script .= "var sesAlbumEnabled = 1;";
    } else {
      $script .= "var sesAlbumEnabled = 0;";
    }

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.follow', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.follow', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.integration', 0)) {
      $script .= "var sespageFollowIntegrate = 1;";
    } else {
      $script .= "var sespageFollowIntegrate = 0;";
    }

    if ($viewer->getIdentity() != 0 && $view->subject() && $view->subject()->getType() == "sespage_page" && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $isAdmin = Engine_Api::_()->getDbTable('pageroles', 'sespage')->isAdmin(array('page_id' => $view->subject()->getIdentity(), 'user_id' => $view->viewer()->getIdentity()));
      if (Engine_Api::_()->authorization()->isAllowed('sespage_page', Engine_Api::_()->user()->getViewer(), 'auth_crosspost') && count(Engine_Api::_()->getDbTable('crossposts', 'sespage')->getCrossposts(array('page_id' => $view->subject()->getIdentity(), 'receiver_approved' => true))) && $isAdmin) {
        //composer_crosspost_toggle_active
        $script .= '
         sesJqueryObject(document).ready(function() {
           sesJqueryObject(".composer_crosspost_toggle").show();
         })
         ';
      }
      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')){
        $table = $view->subject()->membership()->getTable();
        $membershipSelect = $table->select()->where('user_id =?', $viewer->getIdentity())->where('resource_approved =?', 1)->where('resource_id !=?', $view->subject()->getIdentity());
        $res = Engine_Api::_()->getItemTable('sespage_page')->fetchAll($membershipSelect);
        if (count($res)) {
          //multi post sespage feed
          $script .= '
           sesJqueryObject(document).ready(function() {
             sesJqueryObject(".sesact_content_pulldown_wrapper").show();
             sesJqueryObject(".sesact_content_pulldown").hide();
             sesJqueryObject.post("sespage/index/get-membership-page/page_id/' . $view->subject()->getIdentity() . '",function(res){
               if(res != 0){
                  sesJqueryObject(".sesact_content_pulldown_list").html(res);
               }else{
                  sesJqueryObject(".sesact_content_pulldown_wrapper").hide();
               }
             });
           })';
        }
      }

      $script .= '
       sesJqueryObject(document).ready(function() {
        sesJqueryObject(".sesact_privacy_chooser").hide();
        sesJqueryObject("#privacy").val("everyone");
       });
      ';
    }
    if (($actionName != 'create' && $moduleName == 'sespage') && $viewer->getIdentity() != 0 && Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'create')) {
      $script .= 'sesJqueryObject(document).ready(function() {
			if(sesJqueryObject("body").attr("id").search("sespage") > -1 && typeof showAddnewPageIconShortCut != "undefined" && showAddnewPageIconShortCut && typeof isOpenPagePopup != "undefined" && isOpenPagePopup == 1){
				sesJqueryObject("<a class=\'sesbasic_create_button sespage_quick_create_button sessmoothbox sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'sespage_general') . '\' title=\'Add New Page\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
            else if(sesJqueryObject("body").attr("id").search("sespage") > -1 && typeof showAddnewPageIconShortCut != "undefined" && showAddnewPageIconShortCut){
				sesJqueryObject("<a class=\'sesbasic_create_button sespage_quick_create_button sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'sespage_general') . '\' title=\'Add New Page\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
		});';
    }
    $script .= "var pageURLsespage = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.pages.manifest', 'page-directories') . "';";
    $view->headScript()->appendScript($script);
  }

  protected function insertPageLikeCommentDetails($payload, $type) {

    if(!empty($payload->resource_type) && $payload->resource_type == 'sespage_page' && $type == "core_like") {
      $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $item = $table->createRow();
        $item->resource_type = 'sespage_page';
        $item->resource_id = $payload->resource_id;
        $item->poster_type = "user";
        $item->poster_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->creation_date = date('Y-m-d H:i:s');
        $item->save();
        $db->commit();
      } catch (Exception $e) {}
    }
    if (!empty($payload->poster_type) && $payload->poster_type == "sespage_page"){
      $table = Engine_Api::_()->getDbTable('activitycomments', 'sespage');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $itemTable = Engine_Api::_()->getDbTable('activitycomments', 'sespage');
        $item = $itemTable->createRow();
        $item->type = $type;
        $item->item_id = !empty($payload->like_id) ? $payload->like_id : $payload->getIdentity();
        $item->page_id = $payload->poster_id;
        $item->page_type = "sespage_page";
        $item->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->user_type = 'user';
        $item->save();
        $db->commit();
      } catch (Exception $e){throw $e;}
    }
  }

  /*public function onActivityCommentCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertPageLikeCommentDetails($payload, 'activity_comment');
  }*/

  public function onActivityLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertPageLikeCommentDetails($payload, 'activity_like');
  }

  public function onCoreLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertPageLikeCommentDetails($payload, 'core_like');
  }

  protected function delteLikeComment($payload, $type){
    if ($payload) {
      if (!empty($payload->poster_type) && @$payload->poster_type == "sespage_page") {
        $table = Engine_Api::_()->getDbTable('activitycomments', 'sespage');
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
      if (!empty($payload->resource_type ) && @$payload->resource_type == 'sespage_page') {
        $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
        $select = $table->select()->where('resource_id =?', $payload->resource_id)->where('resource_type =?', 'sespage_page')->where('poster_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
        $result = $table->fetchRow($select);
        if ($result)
          $result->delete();
      }
    }
  }

  public function onCommentCreateAfter($event) {
    $payload = $event->getPayload();
    $this->insertPageLikeCommentDetails($payload, $payload->getType());
  }

  public function multiPost($payload, $viewer) {
    $res_type = $payload->object_type;
    $res_id = $payload->object_id;
    $main_action_id = $payload->getIdentity();
    //check page enable scroll posting
    $viewer_id = $viewer->getIdentity();
    $page = Engine_Api::_()->getItem('sespage_page', $res_id);

    $db = Engine_Db_Table::getDefaultAdapter();
    $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
    foreach ($_POST['multipage'] as $pageGuid) {
      $page = Engine_Api::_()->getItemByGuid($pageGuid);
      $page_id = $page->getIdentity();
      if (!$page)
        continue;
      $pageOwner = $page->getOwner();
      if (!$pageOwner)
        continue;
      $pageOwnerId = $pageOwner->getIdentity();

      $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
      $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
      if (!$action_id)
        continue;

      $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
      $action->subject_id = $viewer->getIdentity();
      $action->object_id = $page_id;
      $action->save();
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if(empty($detail_id)) {
        $details_table = Engine_Api::_()->getDbtable('details', 'sesadvancedactivity');
        $details = $details_table->createRow();
        $details->setFromArray(array("action_id"=>$action->getIdentity(),"sesresource_type"=>$action->object_type,"sesresource_id"=>$action->object_id));
        $details->save();
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
    if (!empty($_POST['multipage'])) {
      $this->multiPost($payload, $viewer);
    }

    //this is only for status post.
    if($payload->type == 'post') {
//       $page = Engine_Api::_()->getItem('sespage_page', $payload->object_id);
//       $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $page, 'sespage_page_postedpost', null);
    }

    //cross posting work
    if (!empty($_POST['crosspostVal']) && Engine_Api::_()->authorization()->isAllowed('sespage_page', Engine_Api::_()->user()->getViewer(), 'auth_crosspost') && !empty($payload->object_type) && $payload->object_type == "sespage_page" && Engine_Api::_()->getItem('sespage_page', $payload->object_id)->getOwner()->getIdentity() == $viewer->getIdentity()) {
      $res_type = $payload->object_type;
      $res_id = $payload->object_id;
      $main_action_id = $payload->getIdentity();
      //check page enable scroll posting
      $crossPosts = Engine_Api::_()->getDbTable('crossposts', 'sespage')->getCrossposts(array('page_id' => $res_id, 'receiver_approved' => true));

      if (!count($crossPosts))
        return true;


      $attributionType = 1;
      $pageAttributionType = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'page_attribution');
      $allowUserChoosePageAttribution = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'auth_defattribut');
      if (!$pageAttributionType || $attributionType == 0) {
        $isPageSubject = 'user';
      }
      if ($pageAttributionType && !$allowUserChoosePageAttribution) {
        $isPageSubject = 'page';
      }
      if ($pageAttributionType && $allowUserChoosePageAttribution && $attributionType == 1) {
        $isPageSubject = 'page';
      }


      $db = Engine_Db_Table::getDefaultAdapter();
      $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
      foreach ($crossPosts as $crossPost) {
        $page_id = $crossPost['sender_page_id'] != $res_id ? $crossPost['sender_page_id'] : $crossPost['receiver_page_id'];
        $page = Engine_Api::_()->getItem('sespage_page', $page_id);
        if (!$page)
          continue;
        $pageOwner = $page->getOwner();

        if (!$pageOwner)
          continue;
        $pageOwnerId = $pageOwner->getIdentity();

        $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
        $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
        if (!$action_id)
          continue;
        $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
        $action->subject_id = $pageOwnerId;
        $action->object_id = $page_id;
        if ($isPageSubject == "page") {
          $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
          if($detail_id) {
            $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
            $detailAction->sesresource_type = 'sespage_page';
            $detailAction->sesresource_id = $page_id;
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
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.pluginactivated'))
      return;
    $pageTable = Engine_Api::_()->getItemTable('sespage_page');
    $select = new Zend_Db_Select($pageTable->getAdapter());
    $select->from($pageTable->info('name'), 'COUNT(page_id) as count')->where('is_approved = ?', 0);
    $data = $select->query()->fetch();
    if (empty($data['count'])) {
    return;
    }
    $translate = Zend_Registry::get('Zend_Translate');
    $message = vsprintf($translate->translate(array(
                'There is <a href="%s">%d new page</a> awaiting your approval.',
                'There are <a href="%s">%d new pages</a> awaiting your approval.',
                $data['count']
            )), array(
        Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespage', 'controller' => 'manage'), 'admin_default', true) . '?is_approved=0',
        $data['count'],
    ));
    $event->addResponse($message);
  }
  function onUserDeleteBefore($event){
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
      $table = Engine_Api::_()->getDbTable('pages','sespage');
      $select = $table->select()->where('owner_id =?',$user_id);
      $items = $table->fetchAll($select);
      foreach($items as $item){
        $item->delete();  
      }
    }
  }
}
