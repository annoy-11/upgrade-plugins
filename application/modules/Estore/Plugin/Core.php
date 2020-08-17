<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Plugin_Core extends Zend_Controller_Plugin_Abstract  {


  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $moduleName = $request->getModuleName();
    if (substr($request->getPathInfo(), 1, 6) == "admin/") {
        $headScript = new Zend_View_Helper_HeadScript();
        if($moduleName == "estore")
            $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
      return;
    }

    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();

    if((ESTOREURLENABLED == 1) && (($moduleName == 'core' && $controllerName != 'comment' && $controllerName != 'widget') || ($moduleName == 'estore' && $controllerName == 'profile' && $actionName == 'index'))) {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $arrayOfManifestUrl[] = $settings->getSetting('estore.store.manifest', 'store-directory').'/';
      $replacedPath = trim(str_replace($arrayOfManifestUrl,'',$request->getPathInfo()),'/');
      $exploded = (explode('/',$replacedPath));
      $urlData = Engine_Api::_()->sesbasic()->checkBannedWord($exploded[0],"",$routeType = 1);
      if($urlData && $urlData->resource_type == 'stores') {
        $request->setModuleName('estore');
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
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Estore/externals/scripts/core.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Estore/externals/scripts/activitySwitchStore.js');
    $checkWelcomeStore = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.check.welcome', 2);
    $checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.welcome', 1);
    $checkWelcomeStore = (($checkWelcomeStore == 1 && $viewer->getIdentity() == 0) ? true : (($checkWelcomeStore == 0 && $viewer->getIdentity() != 0) ? true : (($checkWelcomeStore == 2) ? true : false)));
    if (!$checkWelcomeEnable)
      $checkWelcomeStore = false;
    if ($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'estore') {
      $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
      if (!$checkWelcomeStore)
        $redirector->gotoRoute(array('module' => 'estore', 'controller' => 'index', 'action' => 'home'), 'estore_general', false);
      else if ($checkWelcomeEnable == 2)
        $redirector->gotoRoute(array('module' => 'estore', 'controller' => 'index', 'action' => 'browse'), 'estore_general', false);
    }

    if ($moduleName == 'estore' && $actionName == 'index' && $controllerName == 'profile') {
      $bagroundImageId = Engine_Api::_()->core()->getSubject('stores')->background_photo_id;
      if ($bagroundImageId != 0 && $bagroundImageId != '') {
        $backgroundImage = Engine_Api::_()->storage()->get($bagroundImageId, '')->getPhotoUrl();
      }
      if (isset($backgroundImage)) {
        $script .= "window.addEvent('domready', function() {document.getElementById('global_wrapper').style.backgroundImage = \"url('" . $backgroundImage . "')\";});";
      }
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Estore/externals/styles/styles.css');
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Estore/externals/styles/style_profile.css');
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.enable.package', 0)) {
      $openPopup = 0;
    } else {
      $openPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.icon.open.smoothbox', 1);
    }
    $script .= "var isOpenStorePopup = '" . $openPopup . "';var showAddnewStoreIconShortCut = " . Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.addstoreshortcut', 1) . ";
  ";

    // Check sesalbum plugin is enabled for lightbox
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
      $script .= "var sesAlbumEnabled = 1;";
    } else {
      $script .= "var sesAlbumEnabled = 0;";
    }

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.follow', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.follow', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.integration', 0)) {
      $script .= "var estoreFollowIntegrate = 1;";
    } else {
      $script .= "var estoreFollowIntegrate = 0;";
    }

    if ($viewer->getIdentity() != 0 && $view->subject() && $view->subject()->getType() == "stores" && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $isAdmin = Engine_Api::_()->getDbTable('storeroles', 'estore')->isAdmin(array('store_id' => $view->subject()->getIdentity(), 'user_id' => $view->viewer()->getIdentity()));
      if (Engine_Api::_()->authorization()->isAllowed('stores', Engine_Api::_()->user()->getViewer(), 'auth_crosspost') && count(Engine_Api::_()->getDbTable('crossposts', 'estore')->getCrossposts(array('store_id' => $view->subject()->getIdentity(), 'receiver_approved' => true))) && $isAdmin) {
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
        $res = Engine_Api::_()->getItemTable('stores')->fetchAll($membershipSelect);
        if (count($res)) {
          //multi post estore feed
          $text = $view->translate('Select Stores');
          $script .= '
           sesJqueryObject(document).ready(function() {
             sesJqueryObject(".sesact_content_pulldown_wrapper").show();
             sesJqueryObject(".sesact_content_pulldown_wrapper").find(".sesact_chooser_btn").html("'.$text.'");
             sesJqueryObject(".sesact_content_pulldown").hide();
             sesJqueryObject.post("estore/index/get-membership-store/store_id/' . $view->subject()->getIdentity() . '",function(res){
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
    if (($actionName != 'create' && $moduleName == 'estore') && $viewer->getIdentity() != 0 && Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'create')) {
      $script .= 'sesJqueryObject(document).ready(function() {
			if(sesJqueryObject("body").attr("id").search("estore") > -1 && typeof showAddnewStoreIconShortCut != "undefined" && showAddnewStoreIconShortCut && typeof isOpenStorePopup != "undefined" && isOpenStorePopup == 1){
				sesJqueryObject("<a class=\'sesbasic_create_button estore_quick_create_button sessmoothbox sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'estore_general') . '\' title=\'Add New Store\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
            else if(sesJqueryObject("body").attr("id").search("estore") > -1 && typeof showAddnewStoreIconShortCut != "undefined" && showAddnewStoreIconShortCut){
				sesJqueryObject("<a class=\'sesbasic_create_button estore_quick_create_button sesbasic_animation\' href=\'' . $view->url(array('action' => 'create'), 'estore_general') . '\' title=\'Add New Store\'><i class=\'fa fa-plus\'></i></a>").appendTo("body");
			}
		});';
    }
    $script .= "var storeURLestore = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.stores.manifest', 'stores') . "';";
    $view->headScript()->appendScript($script);
  }

  protected function insertStoreLikeCommentDetails($payload, $type) {

    if(!empty($payload->resource_type) && $payload->resource_type == 'stores' && $type == "core_like") {
      $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $item = $table->createRow();
        $item->resource_type = 'stores';
        $item->resource_id = $payload->resource_id;
        $item->poster_type = "user";
        $item->poster_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->creation_date = date('Y-m-d H:i:s');
        $item->save();
        $db->commit();
      } catch (Exception $e) {}
    }
    if (!empty($payload->poster_type) && $payload->poster_type == "stores"){
      $table = Engine_Api::_()->getDbTable('activitycomments', 'estore');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $itemTable = Engine_Api::_()->getDbTable('activitycomments', 'estore');
        $item = $itemTable->createRow();
        $item->type = $type;
        $item->item_id = !empty($payload->like_id) ? $payload->like_id : $payload->getIdentity();
        $item->store_id = $payload->poster_id;
        $item->store_type = "stores";
        $item->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $item->user_type = 'user';
        $item->save();
        $db->commit();
      } catch (Exception $e){throw $e;}
    }
  }

  /*public function onActivityCommentCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertStoreLikeCommentDetails($payload, 'activity_comment');
  }*/

  public function onActivityLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertStoreLikeCommentDetails($payload, 'activity_like');
  }

  public function onCoreLikeCreateAfter($event){
    $payload = $event->getPayload();
    $this->insertStoreLikeCommentDetails($payload, 'core_like');
  }

  protected function delteLikeComment($payload, $type){
    if ($payload) {
      if (!empty($payload->poster_type) && @$payload->poster_type == "stores") {
        $table = Engine_Api::_()->getDbTable('activitycomments', 'estore');
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
      if (!empty($payload->resource_type ) && @$payload->resource_type == 'stores') {
        $table = Engine_Api::_()->getDbTable('likes', 'sesbasic');
        $select = $table->select()->where('resource_id =?', $payload->resource_id)->where('resource_type =?', 'stores')->where('poster_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
        $result = $table->fetchRow($select);
        if ($result)
          $result->delete();
      }
    }
  }

  public function onCommentCreateAfter($event) {
    $payload = $event->getPayload();
    $this->insertStoreLikeCommentDetails($payload, $payload->getType());
  }

  public function multiPost($payload, $viewer) {
    $res_type = $payload->object_type;
    $res_id = $payload->object_id;
    $main_action_id = $payload->getIdentity();
    //check store enable scroll posting
    $viewer_id = $viewer->getIdentity();
    $store = Engine_Api::_()->getItem('stores', $res_id);

    $db = Engine_Db_Table::getDefaultAdapter();
    $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
    foreach ($_POST['multistore'] as $storeGuid) {
      $store = Engine_Api::_()->getItemByGuid($storeGuid);
      $store_id = $store->getIdentity();
      if (!$store)
        continue;
      $storeOwner = $store->getOwner();
      if (!$storeOwner)
        continue;
      $storeOwnerId = $storeOwner->getIdentity();

      $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
      $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
      if (!$action_id)
        continue;

      $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
      $action->subject_id = $viewer->getIdentity();
      $action->object_id = $store_id;
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
    if (!empty($_POST['multistore'])) {
      $this->multiPost($payload, $viewer);
    }

    //this is only for status post.
    if($payload->type == 'post') {
//       $store = Engine_Api::_()->getItem('stores', $payload->object_id);
//       $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $store, 'estore_store_postedpost', null);
    }

    //cross posting work
    if (!empty($_POST['crosspostVal']) && Engine_Api::_()->authorization()->isAllowed('stores', Engine_Api::_()->user()->getViewer(), 'auth_crosspost') && !empty($payload->object_type) && $payload->object_type == "stores" && Engine_Api::_()->getItem('stores', $payload->object_id)->getOwner()->getIdentity() == $viewer->getIdentity()) {
      $res_type = $payload->object_type;
      $res_id = $payload->object_id;
      $main_action_id = $payload->getIdentity();
      //check store enable scroll posting
      $crossPosts = Engine_Api::_()->getDbTable('crossposts', 'estore')->getCrossposts(array('store_id' => $res_id, 'receiver_approved' => true));

      if (!count($crossPosts))
        return true;


      $attributionType = 1;
      $storeAttributionType = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'seb_attribution');
      $allowUserChooseStoreAttribution = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'auth_defattribut');
      if (!$storeAttributionType || $attributionType == 0) {
        $isStoreSubject = 'user';
      }
      if ($storeAttributionType && !$allowUserChooseStoreAttribution) {
        $isStoreSubject = 'stores';
      }
      if ($storeAttributionType && $allowUserChooseStoreAttribution && $attributionType == 1) {
        $isStoreSubject = 'stores';
      }


      $db = Engine_Db_Table::getDefaultAdapter();
      $table = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity');
      foreach ($crossPosts as $crossPost) {
        $store_id = $crossPost['sender_store_id'] != $res_id ? $crossPost['sender_store_id'] : $crossPost['receiver_store_id'];
        $store = Engine_Api::_()->getItem('stores', $store_id);
        if (!$store)
          continue;
        $storeOwner = $store->getOwner();

        if (!$storeOwner)
          continue;
        $storeOwnerId = $storeOwner->getIdentity();

        $select = "SELECT * FROM `engine4_activity_actions` WHERE action_id = " . $main_action_id;
        $action_id = $this->createRowCustom($db, $main_action_id, $select, 'engine4_activity_actions', 'action_id');
        if (!$action_id)
          continue;
        $action = Engine_Api::_()->getItem('sesadvancedactivity_action', $action_id);
        $action->subject_id = $storeOwnerId;
        $action->object_id = $store_id;
        if ($isStoreSubject == "stores") {
          $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
          if($detail_id) {
            $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
            $detailAction->sesresource_type = 'stores';
            $detailAction->sesresource_id = $store_id;
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
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.pluginactivated'))
      return;
    $storeTable = Engine_Api::_()->getItemTable('stores');
    $select = new Zend_Db_Select($storeTable->getAdapter());
    $select->from($storeTable->info('name'), 'COUNT(store_id) as count')->where('is_approved = ?', 0);
    $data = $select->query()->fetch();
    if (empty($data['count'])) {
    return;
    }
    $translate = Zend_Registry::get('Zend_Translate');
    $message = vsprintf($translate->translate(array(
                'There is <a href="%s">%d new store</a> awaiting your approval.',
                'There are <a href="%s">%d new stores</a> awaiting your approval.',
                $data['count']
            )), array(
        Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'estore', 'controller' => 'manage'), 'admin_default', true) . '?is_approved=0',
        $data['count'],
    ));
    $event->addResponse($message);
  }
  function onUserDeleteBefore($event){
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
      $table = Engine_Api::_()->getDbTable('stores','estore');
      $select = $table->select()->where('owner_id =?',$user_id);
      $items = $table->fetchAll($select);
      foreach($items as $item){
        $store = Engine_Api::_()->getItem('stores', $item->store_id);
        if(!empty($store))
            Engine_Api::_()->estore()->deleteStore($store);
      }
    }
  }
}
