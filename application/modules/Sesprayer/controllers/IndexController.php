<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesprayer_prayer', null, 'view')->isValid() ) return;
  }

  public function getusersAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

    $sesdata = array();

    $select = $viewer->membership()->getMembersOfSelect();
    $friends = $paginator = Zend_Paginator::factory($select);

    // Get stuff
    $ids = array();
    foreach( $friends as $friend ) {
      $ids[] = $friend->resource_id;
    }

    if($ids) {
      $users_table = Engine_Api::_()->getDbtable('users', 'user');
      $select = $users_table->select()
                      ->where('user_id IN (?)', $ids)
                      ->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%')
                      ->order('displayname ASC')->limit('40');
      $users = $users_table->fetchAll($select);

      foreach ($users as $user) {
        $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
        $sesdata[] = array(
            'id' => $user->user_id,
            'label' => $user->displayname,
            'photo' => $user_icon_photo
        );
      }
    }
    return $this->_helper->json($sesdata);
  }

  public function getIframelyInformationAction() {

    $url = trim(strip_tags($this->_getParam('uri')));
    $ajax = $this->_getParam('ajax', false);
    $information = $this->handleIframelyInformation($url);
    $this->view->ajax = $ajax;
    $this->view->valid = !empty($information['code']);
    $this->view->iframely = $information;
  }

  //fetch user like item as per given item id .
  public function likeItemAction() {

    $item_id = $this->_getParam('item_id', '0');
    $item_type = $this->_getParam('item_type', '0');
    if (!$item_id || !$item_type)
      return;
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);
		$this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $item = Engine_Api::_()->getItem($item_type, $item_id);
    $param['type'] = $this->view->item_type = $item_type;
    $param['id'] = $this->view->item_id = $item->getIdentity();
    $paginator = Engine_Api::_()->sesprayer()->likeItemCore($param);
    $this->view->item_id = $item_id;
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($page);
  }

  public function topPrayerPostersAction() {

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);
		$this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';

    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');

    $prayerTable = Engine_Api::_()->getDbTable('prayers', 'sesprayer');
    $prayerTableName = $prayerTable->info('name');

    $select = $userTable->select()
                      ->from($userTable, array('COUNT(*) AS prayer_count', 'user_id', 'displayname'))
                      ->setIntegrityCheck(false)
                      ->join($prayerTableName, $prayerTableName . '.owner_id=' . $userTableName . '.user_id')
                      ->group($userTableName . '.user_id')
                      ->order('prayer_count DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }


  function likeAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    if ($viewer_id == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $type = $this->_getParam('type', false);

    $notificationType = 'sesprayer_prayer_like';

    $item_id = $this->_getParam('id');


    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $item = Engine_Api::_()->getItem($type, $item_id);
    $itemTable = Engine_Api::_()->getDbtable('prayers', 'sesprayer');
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');
    $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', $type)
            ->where('poster_id = ?', $viewer_id)
            ->where('poster_type = ?', 'user')
            ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);
    if (count($result) > 0) {
      //delete
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {
        $like = $tableLike->createRow();
        $like->poster_id = $viewer_id;
        $like->resource_type = $type;
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();
        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array('prayer_id = ?' => $item_id));
        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //Send notification and activity feed work.
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }

  public function prayerPopupAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->actionparam = $this->_getParam('actionparam',false);

    $this->view->prayer_id = $prayer_id = $this->_getParam('prayer_id',false);
    //$this->view->photo_id = $this->_getParam('photo_id',false);
    $this->view->prayers = $prayer = Engine_Api::_()->getItem('sesprayer_prayer',$prayer_id);
    // Get tags
    $this->view->prayerTags = $prayer->tags()->getTagMaps();
    // Do other stuff
    $this->view->mine = true;
    $this->view->canEdit = $this->_helper->requireAuth()->setAuthParams($prayer, null, 'edit')->checkRequire();
  }

  public function viewAction()
  {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $prayer = Engine_Api::_()->getItem('sesprayer_prayer', $this->_getParam('prayer_id'));
    if( $prayer ) {
      Engine_Api::_()->core()->setSubject($prayer);
    }

    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }
    $canView = $this->_helper->requireAuth()->setAuthParams('sesprayer_prayer', null, 'view')->checkRequire();
    if(empty($canView)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Prepare data
    $prayerTable = Engine_Api::_()->getDbtable('prayers', 'sesprayer');

    $this->view->prayer = $prayer;
    $this->view->owner = $owner = $prayer->getOwner();
    $this->view->viewer = $viewer;
    $this->view->viewer_id = $viewer->getIdentity();

    // Do other stuff
    $this->view->mine = true;
    $this->view->canEdit = $this->_helper->requireAuth()->setAuthParams($prayer, null, 'edit')->checkRequire();
    if( !$prayer->getOwner()->isSelf(Engine_Api::_()->user()->getViewer()) ) {
      $prayer->getTable()->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'prayer_id = ?' => $prayer->getIdentity(),
      ));
      $this->view->mine = false;
    }

    if ($viewer->getIdentity() != 0 && isset($prayer->prayer_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_sesprayer_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $prayer->prayer_id . '", "sesprayer_prayer","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    // Get tags
    $this->view->prayerTags = $prayer->tags()->getTagMaps();

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
  }

  public function indexAction()
  {
    // Render
    $sesprayer_prayercreate = Zend_Registry::isRegistered('sesprayer_prayercreate') ? Zend_Registry::get('sesprayer_prayercreate') : null;
    if(!empty($sesprayer_prayercreate)) {
      $this->_helper->content->setEnabled();
    }
  }

  // USER SPECIFIC METHODS
  public function manageAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    $sesprayer_prayercreate = Zend_Registry::isRegistered('sesprayer_prayercreate') ? Zend_Registry::get('sesprayer_prayercreate') : null;
    if(!empty($sesprayer_prayercreate)) {
      // Render
      $this->_helper->content
          //->setNoRender()
          ->setEnabled();
    }

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesprayer_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesprayer_prayer', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Process form
    $defaultValues = $form->getValues();
    if( $form->isValid($this->_getAllParams()) ) {
      $values = $form->getValues();
    } else {
      $values = $defaultValues;
    }
    $this->view->formValues = array_filter($values);
    $values['user_id'] = $viewer->getIdentity();
    $values['actionname'] == 'manage';
    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('sesprayer_prayer')->getPrayersPaginator($values);
    $items_per_page = 10; //Engine_Api::_()->getApi('settings', 'core')->blog_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
  }


  public function createAction()
  {
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesprayer_prayer', null, 'create')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // set up data needed to check quota
    $viewer = Engine_Api::_()->user()->getViewer();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprayer_Form_Create();
    }

    // If not post or form not valid, return
//     if( !$this->getRequest()->isPost() ) {
//       return;
//     }
//
//     if( !$form->isValid($this->getRequest()->getPost()) ) {
//       return;
//     }
    if($is_ajax) {
      // Process
      $receiverTable = Engine_Api::_()->getDbTable('receivers', 'sesprayer');
      $table = Engine_Api::_()->getItemTable('sesprayer_prayer');
      $db = $table->getAdapter();
      $db->beginTransaction();
      $values = $_POST; //$form->getValues();

      try {
        // Create blog
        $viewer = Engine_Api::_()->user()->getViewer();
        $formValues = $_POST; //$form->getValues();

        if( empty($values['auth_view']) ) {
          $formValues['auth_view'] = 'everyone';
        }

        if( empty($values['auth_comment']) ) {
          $formValues['auth_comment'] = 'everyone';
        }

        $values = array_merge($formValues, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity(),
        ));


        $networkValues = array();
        foreach (Engine_Api::_()->getDbtable('networks', 'network')->fetchAll() as $network) {
          $networkValues[] = $network->network_id;
        }
        if (@$values['networks'])
          $values['networks'] = json_encode($values['networks']);
        else
          $values['networks'] = json_encode($networkValues);

        if (@$values['lists'])
          $values['lists'] = json_encode($values['lists']);
        else
          $values['lists'] = '';


        $prayer = $table->createRow();

        if(!empty($_FILES['photo']['name'])) {
          $prayer->setPhoto($_FILES['photo']);
        }

        if($values['video']) {
          $information = $this->handleIframelyInformation($values['video']);
          try{
            $prayer->setPhoto($information['thumbnail']);
          }catch(Exception $e){
            //silence
          }
          $values['code'] = $information['code'];
        }
        $prayer->save();
        // Auth
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        $viewMax = array_search($values['auth_view'], $roles);
        $commentMax = array_search($values['auth_comment'], $roles);

        foreach( $roles as $i => $role ) {
          $auth->setAllowed($prayer, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($prayer, $role, 'comment', ($i <= $commentMax));
        }

        // Add tags
        $tags = preg_split('/[,]+/', $values['tags']);
        $prayer->tags()->addTagMaps($viewer, $tags);

        $prayer->setFromArray($values);
        $prayer->save();

        $privacy = '';

        //SES Custom Work
        if($prayer->posttype == 1) {
          $networksArray = Zend_Json::decode($values['networks']);
          $networksTable = Engine_Api::_()->getDbtable('membership', 'network');
          $select = $networksTable->select()->from($networksTable->info('name'), array('user_id'))->where('resource_id IN (?)', $networksArray)->group('user_id');
          foreach($networksArray as $networks){
            $privacy .= 'network_list_'.$networks.',';
          }
          $users = $networksTable->fetchAll($select);
          foreach($users as $user) {
            $user = Engine_Api::_()->getItem('user', $user->user_id);
            if($user->getIdentity() != $prayer->owner_id) {
                //Receiver Table Entry
                $receiverRow = $receiverTable->createRow();
                $receiverRow->prayer_id = $prayer->getIdentity();
                $receiverRow->sender_id = $prayer->owner_id;
                $receiverRow->resource_id = $user->getIdentity();
                $receiverRow->save();

                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $prayer, 'sesprayer_sendprayer');
            }
          }
        } else if($prayer->posttype == 2) {

          $listsArray = Zend_Json::decode($values['lists']);
          $privacy .= 'members_list_'.$listsArray.',';
//           foreach($listsArray as $list){
//             $privacy .= 'members_list_'.$list.',';
//           }

          $listitemsTable = Engine_Api::_()->getItemTable('user_list_item');
          $select = $listitemsTable->select()->from($listitemsTable->info('name'), array('child_id'))->where('list_id IN (?)', $listsArray)->group('child_id');
          $users = $listitemsTable->fetchAll($select);
          foreach($users as $user) {
            $user = Engine_Api::_()->getItem('user', $user->child_id);
            if($user->getIdentity() != $prayer->owner_id) {
                //Receiver Table Entry
                $receiverRow = $receiverTable->createRow();
                $receiverRow->prayer_id = $prayer->getIdentity();
                $receiverRow->sender_id = $prayer->owner_id;
                $receiverRow->resource_id = $user->getIdentity();
                $receiverRow->save();

                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $prayer, 'sesprayer_sendprayer');
            }

          }
        } else if($prayer->posttype == 3) {
            $user = Engine_Api::_()->getItem('user', $values['user_id']);

            //Receiver Table Entry
            $receiverRow = $receiverTable->createRow();
            $receiverRow->prayer_id = $prayer->getIdentity();
            $receiverRow->sender_id = $prayer->owner_id;
            $receiverRow->resource_id = $user->getIdentity();
            $receiverRow->save();

            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $prayer, 'sesprayer_sendprayer');
          $privacy .= 'friends_list_'.$values['user_id'];
        }else{
          $privacy = "everyone";
        }
        //SES Custom Work


        // Add activity only if blog is published
        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
          if($privacy) {
            $privacy = trim($privacy);
            $privacy = rtrim($privacy, ',');
            $action = Engine_Api::_()->getDbTable('actions', 'sesadvancedactivity')->addActivity($viewer, $prayer, 'sesprayer_new', null, null, array('privacy' => $privacy));
          }
        } else {
          $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $prayer, 'sesprayer_new');
        }
        // make sure action exists before attaching the blog to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $prayer);
        }

        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags && $action) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
          }
          $prayer->action_id = $action->getIdentity();
          $prayer->save();
        }

        //Case of everyone
        if($prayer->posttype == 0) {
          $prayer->lists = '';
          $prayer->networks = '[]';
          $prayer->save();
        }

        // Commit
        $db->commit();
        echo Zend_Json::encode(array('status' => 1));exit();
      } catch( Exception $e ) {
          $db->rollBack();
          throw $e;
          echo 0;die;
      }
    }
//     return $this->_forward('success' ,'utility', 'core', array(
//       'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesprayer_general', true),
//       'messages' => Array(Zend_Registry::get('Zend_Translate')->_('Your prayer has been posted successfully.'))
//     ));
  }

  // HELPER FUNCTIONS
  public function handleIframelyInformation($uri) {

    $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer_iframely_disallow');
    if (parse_url($uri, PHP_URL_SCHEME) === null) {
        $uri = "http://" . $uri;
    }
    $uriHost = Zend_Uri::factory($uri)->getHost();
    if ($iframelyDisallowHost && in_array($uriHost, $iframelyDisallowHost)) {
        return;
    }
    $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
    $iframely = Engine_Iframely::factory($config)->get($uri);
    if (!in_array('player', array_keys($iframely['links']))) {
        return;
    }
    $information = array('thumbnail' => '', 'title' => '', 'description' => '', 'duration' => '');
    if (!empty($iframely['links']['thumbnail'])) {
        $information['thumbnail'] = $iframely['links']['thumbnail'][0]['href'];
        if (parse_url($information['thumbnail'], PHP_URL_SCHEME) === null) {
            $information['thumbnail'] = str_replace(array('://', '//'), '', $information['thumbnail']);
            $information['thumbnail'] = "http://" . $information['thumbnail'];
        }
    }
    if (!empty($iframely['meta']['title'])) {
        $information['title'] = $iframely['meta']['title'];
    }
    if (!empty($iframely['meta']['description'])) {
        $information['description'] = $iframely['meta']['description'];
    }
    if (!empty($iframely['meta']['duration'])) {
        $information['duration'] = $iframely['meta']['duration'];
    }
    $information['code'] = $iframely['html'];
    return $information;
  }

  public function editAction()
  {
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    if( !$this->_helper->requireUser()->isValid() ) return;

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->prayer_id = $this->_getParam('prayer_id');

    $prayer = Engine_Api::_()->getItem('sesprayer_prayer', $this->_getParam('prayer_id'));

    if (isset($prayer->category_id) && $prayer->category_id != 0)
      $this->view->category_id = $prayer->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;

    if (isset($prayer->subcat_id) && $prayer->subcat_id != 0)
      $this->view->subcat_id = $prayer->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    if (isset($prayer->subsubcat_id) && $prayer->subsubcat_id != 0)
      $this->view->subsubcat_id = $prayer->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

//     if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($prayer, $viewer, 'edit')->isValid() ) return;

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprayer_Form_Edit();

      $this->view->category_id = $prayer->category_id;
      $this->view->subcat_id = $prayer->subcat_id;
      $this->view->subsubcat_id = $prayer->subsubcat_id;


      $prayer['networks'] = json_decode($prayer['networks']);
      $prayer['lists'] = json_decode($prayer['lists']);

      // Populate form
      $form->populate($prayer->toArray());

      $tagStr = '';
      foreach( $prayer->tags()->getTagMaps() as $tagMap ) {
        $tag = $tagMap->getTag();
        if( !isset($tag->text) ) continue;
        if( '' !== $tagStr ) $tagStr .= ', ';
        $tagStr .= $tag->text;
      }

      $form->populate(array(
        'tags' => $tagStr,
      ));
      $this->view->tagNamePrepared = $tagStr;

      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      foreach( $roles as $role ) {
        if ($form->auth_view){
          if( $auth->isAllowed($prayer, $role, 'view') ) {
           $form->auth_view->setValue($role);
          }
        }

        if ($form->auth_comment){
          if( $auth->isAllowed($prayer, $role, 'comment') ) {
            $form->auth_comment->setValue($role);
          }
        }
      }
    }

    // Check post/form
//     if( !$this->getRequest()->isPost() ) {
//       return;
//     }
//     if( !$form->isValid($this->getRequest()->getPost()) ) {
//       return;
//     }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $values = $_POST; //$form->getValues();

        if( empty($values['auth_view']) ) {
          $values['auth_view'] = 'everyone';
        }
        if( empty($values['auth_comment']) ) {
          $values['auth_comment'] = 'everyone';
        }

        $networkValues = array();
        foreach (Engine_Api::_()->getDbtable('networks', 'network')->fetchAll() as $network) {
          $networkValues[] = $network->network_id;
        }
        if ($values['networks'])
          $values['networks'] = json_encode($values['networks']);
        else
          $values['networks'] = json_encode($networkValues);

        if (@$values['lists'])
          $values['lists'] = json_encode($values['lists']);
        else
          $values['lists'] = '';


        $prayer->setFromArray($values);
        $prayer->modified_date = date('Y-m-d H:i:s');
        $prayer->save();

        // Add photo
        if( !empty($_FILES['photo']['name']) ) {
          $prayer->setPhoto($_FILES['photo']);
        }

        // Auth
  //       $viewMax = array_search($values['auth_view'], $roles);
  //       $commentMax = array_search($values['auth_comment'], $roles);
  //
  //       foreach( $roles as $i => $role ) {
  //         $auth->setAllowed($prayer, $role, 'view', ($i <= $viewMax));
  //         $auth->setAllowed($prayer, $role, 'comment', ($i <= $commentMax));
  //       }

        // handle tags
        $tags = preg_split('/[,]+/', $values['tags']);
        $prayer->tags()->setTagMaps($viewer, $tags);

        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags && $prayer->action_id) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$prayer->action_id."'");
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$prayer->action_id.'", "'.$tag.'")');
          }
        }

        $db->commit();
        echo Zend_Json::encode(array('status' => 1));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
//     return $this->_forward('success' ,'utility', 'core', array(
//       'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesprayer_general', true),
//       'messages' => Array(Zend_Registry::get('Zend_Translate')->_('Your prayer has been edited successfully.'))
//     ));
  }

  public function deleteAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $prayer = Engine_Api::_()->getItem('sesprayer_prayer', $this->getRequest()->getParam('prayer_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($prayer, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesprayer_Form_Delete();

    if( !$prayer ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Prayer entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $prayer->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$prayer->action_id."'");
      }
      $prayer->delete();

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your prayer entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesprayer_general', true),
      'messages' => Array($this->view->message)
    ));
  }
}
