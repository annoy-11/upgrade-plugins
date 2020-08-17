<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Plugin_Core extends Zend_Controller_Plugin_Abstract  {


  public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    if (substr($request->getPathInfo(), 1, 6) == "admin/") {
      return;
    }
    $moduleName = $request->getModuleName();
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if((SESBUSINESSURLENABLED == 1 && $settings->getSetting('sesbusiness.enable.shorturl', 0)) && (($moduleName == 'core' && $controllerName != 'comment' && $controllerName != 'widget') || ($moduleName == 'sesbusiness' && $controllerName == 'profile' && $actionName == 'index'))) {
      $arrayOfManifestUrl[] = $settings->getSetting('sesbusiness.business.manifest', 'business-directory').'/';
      $replacedPath = trim(str_replace($arrayOfManifestUrl,'',$request->getPathInfo()),'/');
      $exploded = (explode('/',$replacedPath));
      $isShortURL = true;
      if($settings->getSetting('sesbusiness.shorturl.onlike', 0)) {
        $likeCount = Engine_Api::_()->sesbusiness()->getBusinessLikeCount($exploded[0]);
        if($likeCount < $settings->getSetting('sesbusiness.countlike', 10))
          $isShortURL = false;
      }
      $urlData = Engine_Api::_()->sesbasic()->checkBannedWord($exploded[0],"",$routeType = 1);
      if($urlData && $urlData->resource_type == 'businesses' && $isShortURL) {
        $request->setModuleName('sesbusiness');
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
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbusiness/externals/scripts/core.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbusiness/externals/scripts/activitySwitchBusiness.js');
    $checkWelcomeBusiness = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.check.welcome', 2);
    $checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.welcome', 1);
    $checkWelcomeBusiness = (($checkWelcomeBusiness == 1 && $viewer->getIdentity() == 0) ? true : (($checkWelcomeBusiness == 0 && $viewer->getIdentity() != 0) ? true : (($checkWelcomeBusiness == 2) ? true : false)));
    if (!$checkWelcomeEnable)
      $checkWelcomeBusiness = false;
    if ($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sesbusiness') {
      $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
      if (!$checkWelcomeBusiness)
        $redirector->gotoRoute(array('module' => 'sesbusiness', 'controller' => 'index', 'action' => 'home'), 'sesbusiness_general', false);
      else if ($checkWelcomeEnable == 2)
        $redirector->gotoRoute(array('module' => 'sesbusiness', 'controller' => 'index', 'action' => 'browse'), 'sesbusiness_general', false);
    }

    if ($moduleName == 'sesbusiness' && $actionName == 'index' && $controllerName == 'profile') {
      $bagroundImageId = Engine_Api::_()->core()->getSubject('businesses')->background_photo_id;
      if ($bagroundImageId != 0 && $bagroundImageId != '') {
        $backgroundImage = Engine_Api::_()->storage()->get($bagroundImageId, '')->getPhotoUrl();
      }
      if (isset($backgroundImage)) {
        $script .= "window.addEvent('domready', function() {document.getElementById('global_wrapper').style.backgroundImage = \"url('" . $backgroundImage . "')\";});";
      }
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Sesbusiness/externals/styles/styles.css');
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Sesbusiness/externals/styles/style_profile.css');
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspackage.enable.package', 0)) {
      $openPopup = 0;
    } else {
      $openPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.icon.open.smoothbox', 1);
    }
    $script .= "var isOpenBusinessPopup = '" . $openPopup . "';var showAddnewBusinessIconShortCut = " . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.addbusinesseshortcut', 1) . ";
  ";

    // Check sesalbum plugin is enabled for lightbox
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
      $script .= "var sesAlbumEnabled = 1;";
    } else {
      $script .= "var sesAlbumEnabled = 0;";
    }

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.follow', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.follow', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.integration', 0)) {
      $script .= "var sesbusinessFollowIntegrate = 1;";
    } else {
      $script .= "var sesbusinessFollowIntegrate = 0;";
    }

    if ($viewer->getIdentity() != 0 && $view->subject() && $view->subject()->getType() == "businesses" && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $isAdmin = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->isAdmin(array('business_id' => $view->subject()->getIdentity(), 'user_id' => $view->viewer()->getIdentity()));
      if (Engine_Api::_()->authorization()->isAllowed('businesses', Engine_Api::_()->user()->getViewer(), 'auth_crosspost') && count(Engine_Api::_()->getDbTable('crossposts', 'sesbusiness')->getCrossposts(array('business_id' => $view->subject()->getIdentity(), 'receiver_approved' => true))) && $isAdmin) {
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
        $res = Engine_Api::_()->getItemTable('businesses')->fetchAll($membershipSelect);
        if (count($res)) {
          //multi post sesbusiness feed
          $text = $view->translate('Select Businesses');
          $script .= '
           sesJqueryObject(document).ready(function() {
             sesJqueryObject(".sesact_content_pulldown_wrapper").show();
             sesJqueryObject(".sesact_content_pulldown_wrapper").find(".sesact_chooser_btn").html("'.$text.'");
             sesJqueryObject(".sesact_content_pulldown").hide();
             sesJqueryObject.post("sesbusiness/index/get-membership-business/business_id/' . $view->subject()->getIdentity() . '",function(res){
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
    if (($actionName != 'create' && $moduleName == 'sesbusiness') && $viewer->getIdentity() != 0 && Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'create')) {
      $script .= 'sesJqueryObject(document).ready(function() {
			if(sesJqueryObject("body").attr("id").search("sesbusiness") > -1 && typeof showAddnewBusinessIconShortCut != "undefined" && showAddnewBusinessIconShortCut && typeof isOpenBusinessPopup != "undefined" && isOpenBusinessPopup == 1){
				sesJqueryObject("<a class=\'sesbasic_create_button sesbusiness_quick_create_button sessmoothbox sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'sesbusiness_general') . '\' title=\'Add New Business\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
            else if(sesJqueryObject("body").attr("id").search("sesbusiness") > -1 && typeof showAddnewBusinessIconShortCut != "undefined" && showAddnewBusinessIconShortCut){
				sesJqueryObject("<a class=\'sesbasic_create_button sesbusiness_quick_create_button sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'sesbusiness_general') . '\' title=\'Add New Business\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
		});';
    }
    $script .= "var businessURLsesbusiness = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.businesses.manifest', 'business-directories') . "';";
    $view->headScript()->appendScript($script);
  }

  protected function insertBusinessLikeCommentDetails($payload, $type) {

    if(!empty($payload->resource_type) && $payload->resource_type == 'businesses' && $type == "core_like") {
      $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $item = $table->createRow();
        $item->resource_type = 'businesses';
        $item->resource_id = $payload->resource_id;
        $item->poster_type = "user";
        $item->poster_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->creation_date = date('Y-m-d H:i:s');
        $item->save();
        $db->commit();
      } catch (Exception $e) {}
    }
    if (!empty($payload->poster_type) && $payload->poster_type == "businesses"){
      $table = Engine_Api::_()->getDbTable('activitycomments', 'sesbusiness');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $itemTable = Engine_Api::_()->getDbTable('activitycomments', 'sesbusiness');
        $item = $itemTable->createRow();
        $item->type = $type;
        $item->item_id = !empty($payload->like_id) ? $payload->like_id : $payload->getIdentity();
        $item->business_id = $payload->poster_id;
        $item->business_type = "businesses";
        $item->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->user_type = 'user';
        $item->save();
        $db->commit();
      } catch (Exception $e){throw $e;}
    }
  }

  /*public function onActivityCommentCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertBusinessLikeCommentDetails($payload, 'activity_comment');
  }*/

  public function onActivityLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertBusinessLikeCommentDetails($payload, 'activity_like');
  }

  public function onCoreLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertBusinessLikeCommentDetails($payload, 'core_like');
  }

  protected function delteLikeComment($payload, $type){
    if ($payload) {
      if (!empty($payload->poster_type) && @$payload->poster_type == "businesses") {
        $table = Engine_Api::_()->getDbTable('activitycomments', 'sesbusiness');
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
      if (!empty($payload->resource_type ) && @$payload->resource_type == 'businesses') {
        $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
        $select = $table->select()->where('resource_id =?', $payload->resource_id)->where('resource_type =?', 'businesses')->where('poster_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
        $result = $table->fetchRow($select);
        if ($result)
          $result->delete();
      }
    }
  }

  public function onCommentCreateAfter($event) {
    $payload = $event->getPayload();
    $this->insertBusinessLikeCommentDetails($payload, $payload->getType());
  }

  public function multiPost($payload, $viewer) {
    $res_type = $payload->object_type;
    $res_id = $payload->object_id;
    $main_action_id = $payload->getIdentity();
    //check business enable scroll posting
    $viewer_id = $viewer->getIdentity();
    $business = Engine_Api::_()->getItem('businesses', $res_id);

    $db = Engine_Db_Table::getDefaultAdapter();
    $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
    foreach ($_POST['multibusiness'] as $businessGuid) {
      $business = Engine_Api::_()->getItemByGuid($businessGuid);
      $business_id = $business->getIdentity();
      if (!$business)
        continue;
      $businessOwner = $business->getOwner();
      if (!$businessOwner)
        continue;
      $businessOwnerId = $businessOwner->getIdentity();

      $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
      $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
      if (!$action_id)
        continue;

      $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
      $action->subject_id = $viewer->getIdentity();
      $action->object_id = $business_id;
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
    if (!empty($_POST['multibusiness'])) {
      $this->multiPost($payload, $viewer);
    }

    //this is only for status post.
    if($payload->type == 'post') {
//       $business = Engine_Api::_()->getItem('businesses', $payload->object_id);
//       $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $business, 'sesbusiness_business_postedpost', null);
    }

    //cross posting work
    if (!empty($_POST['crosspostVal']) && Engine_Api::_()->authorization()->isAllowed('businesses', Engine_Api::_()->user()->getViewer(), 'auth_crosspost') && !empty($payload->object_type) && $payload->object_type == "businesses" && Engine_Api::_()->getItem('businesses', $payload->object_id)->getOwner()->getIdentity() == $viewer->getIdentity()) {
      $res_type = $payload->object_type;
      $res_id = $payload->object_id;
      $main_action_id = $payload->getIdentity();
      //check business enable scroll posting
      $crossPosts = Engine_Api::_()->getDbTable('crossposts', 'sesbusiness')->getCrossposts(array('business_id' => $res_id, 'receiver_approved' => true));

      if (!count($crossPosts))
        return true;


      $attributionType = 1;
      $businessAttributionType = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'seb_attribution');
      $allowUserChooseBusinessAttribution = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'auth_defattribut');
      if (!$businessAttributionType || $attributionType == 0) {
        $isBusinessSubject = 'user';
      }
      if ($businessAttributionType && !$allowUserChooseBusinessAttribution) {
        $isBusinessSubject = 'businesses';
      }
      if ($businessAttributionType && $allowUserChooseBusinessAttribution && $attributionType == 1) {
        $isBusinessSubject = 'businesses';
      }


      $db = Engine_Db_Table::getDefaultAdapter();
      $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
      foreach ($crossPosts as $crossPost) {
        $business_id = $crossPost['sender_business_id'] != $res_id ? $crossPost['sender_business_id'] : $crossPost['receiver_business_id'];
        $business = Engine_Api::_()->getItem('businesses', $business_id);
        if (!$business)
          continue;
        $businessOwner = $business->getOwner();

        if (!$businessOwner)
          continue;
        $businessOwnerId = $businessOwner->getIdentity();

        $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
        $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
        if (!$action_id)
          continue;
        $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
        $action->subject_id = $businessOwnerId;
        $action->object_id = $business_id;
        if ($isBusinessSubject == "businesses") {
          $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
          if($detail_id) {
            $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
            $detailAction->sesresource_type = 'businesses';
            $detailAction->sesresource_id = $business_id;
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
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.pluginactivated'))
      return;
    $businessTable = Engine_Api::_()->getItemTable('businesses');
    $select = new Zend_Db_Select($businessTable->getAdapter());
    $select->from($businessTable->info('name'), 'COUNT(business_id) as count')->where('is_approved = ?', 0);
    $data = $select->query()->fetch();
    if (empty($data['count'])) {
    return;
    }
    $translate = Zend_Registry::get('Zend_Translate');
    $message = vsprintf($translate->translate(array(
                'There is <a href="%s">%d new business</a> awaiting your approval.',
                'There are <a href="%s">%d new businesses</a> awaiting your approval.',
                $data['count']
            )), array(
        Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbusiness', 'controller' => 'manage'), 'admin_default', true) . '?is_approved=0',
        $data['count'],
    ));
    $event->addResponse($message);
  }
  function onUserDeleteBefore($event){
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
      $table = Engine_Api::_()->getDbTable('businesses','sesbusiness');
      $select = $table->select()->where('owner_id =?',$user_id);
      $items = $table->fetchAll($select);
      foreach($items as $item){
        $item->delete();  
      }
    }
  }
}
