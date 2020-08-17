<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('seswishe_wishe', null, 'view')->isValid() ) return;
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
    $paginator = Engine_Api::_()->seswishe()->likeItemCore($param);
    $this->view->item_id = $item_id;
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($page);
  }

  public function topWishePostersAction() {

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);
		$this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    
    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');
    
    $wisheTable = Engine_Api::_()->getDbTable('wishes', 'seswishe');
    $wisheTableName = $wisheTable->info('name');
    
    $select = $userTable->select()
                      ->from($userTable, array('COUNT(*) AS wishe_count', 'user_id', 'displayname'))
                      ->setIntegrityCheck(false)
                      ->join($wisheTableName, $wisheTableName . '.owner_id=' . $userTableName . '.user_id')
                      ->group($userTableName . '.user_id')
                      ->order('wishe_count DESC');
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

    $notificationType = 'seswishe_wishe_like';

    $item_id = $this->_getParam('id');

    
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $item = Engine_Api::_()->getItem($type, $item_id);
    $itemTable = Engine_Api::_()->getDbtable('wishes', 'seswishe');
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
        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array('wishe_id = ?' => $item_id));
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
  
  public function wishePopupAction() {
  
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->actionparam = $this->_getParam('actionparam',false);

    $this->view->wishe_id = $wishe_id = $this->_getParam('wishe_id',false);
    //$this->view->photo_id = $this->_getParam('photo_id',false);
    $this->view->wishes = $wishe = Engine_Api::_()->getItem('seswishe_wishe',$wishe_id);
    // Get tags
    $this->view->wisheTags = $wishe->tags()->getTagMaps();
    // Do other stuff
    $this->view->mine = true;
    $this->view->canEdit = $this->_helper->requireAuth()->setAuthParams($wishe, null, 'edit')->checkRequire();
  }
  
  public function viewAction()
  {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $wishe = Engine_Api::_()->getItem('seswishe_wishe', $this->_getParam('wishe_id'));
    if( $wishe ) {
      Engine_Api::_()->core()->setSubject($wishe);
    }

    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }
    $canView = $this->_helper->requireAuth()->setAuthParams('seswishe_wishe', null, 'view')->checkRequire();
    if(empty($canView)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Prepare data
    $wisheTable = Engine_Api::_()->getDbtable('wishes', 'seswishe');
    
    $this->view->wishe = $wishe;
    $this->view->owner = $owner = $wishe->getOwner();
    $this->view->viewer = $viewer;
    $this->view->viewer_id = $viewer->getIdentity();

    // Do other stuff
    $this->view->mine = true;
    $this->view->canEdit = $this->_helper->requireAuth()->setAuthParams($wishe, null, 'edit')->checkRequire();
    if( !$wishe->getOwner()->isSelf(Engine_Api::_()->user()->getViewer()) ) {
      $wishe->getTable()->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'wishe_id = ?' => $wishe->getIdentity(),
      ));
      $this->view->mine = false;
    }
    
    if ($viewer->getIdentity() != 0 && isset($wishe->wishe_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_seswishe_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $wishe->wishe_id . '", "seswishe_wishe","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }
    
    // Get tags
    $this->view->wisheTags = $wishe->tags()->getTagMaps();

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
  }
  
  public function indexAction()
  {
    // Render
    $seswishe_wishecreate = Zend_Registry::isRegistered('seswishe_wishecreate') ? Zend_Registry::get('seswishe_wishecreate') : null;
    if(!empty($seswishe_wishecreate)) {
      $this->_helper->content->setEnabled();
    }
  }

  // USER SPECIFIC METHODS
  public function manageAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;
    
    $seswishe_wishecreate = Zend_Registry::isRegistered('seswishe_wishecreate') ? Zend_Registry::get('seswishe_wishecreate') : null;
    if(!empty($seswishe_wishecreate)) {
      // Render
      $this->_helper->content
          //->setNoRender()
          ->setEnabled();
    }
    
    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Seswishe_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('seswishe_wishe', null, 'create')->checkRequire();

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

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('seswishe_wishe')->getWishesPaginator($values);
    $items_per_page = 10; //Engine_Api::_()->getApi('settings', 'core')->blog_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
  }
  

  public function createAction()
  {
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('seswishe_wishe', null, 'create')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    
    // set up data needed to check quota
    $viewer = Engine_Api::_()->user()->getViewer();
    
    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Seswishe_Form_Create();
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
      $table = Engine_Api::_()->getItemTable('seswishe_wishe');
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
        
        

        $wishe = $table->createRow();
        
        if(!empty($_FILES['photo']['name'])) {
          $wishe->setPhoto($_FILES['photo']);
        }
        
        if($values['video']) {
          $information = $this->handleIframelyInformation($values['video']);
          try{
            $wishe->setPhoto($information['thumbnail']);
          }catch(Exception $e){
            //silence  
          }
          $values['code'] = $information['code'];
        }
        $wishe->save();
        // Auth
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        $viewMax = array_search($values['auth_view'], $roles);
        $commentMax = array_search($values['auth_comment'], $roles);

        foreach( $roles as $i => $role ) {
          $auth->setAllowed($wishe, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($wishe, $role, 'comment', ($i <= $commentMax));
        }
        
        // Add tags 
        $tags = preg_split('/[,]+/', $values['tags']);
        $wishe->tags()->addTagMaps($viewer, $tags);

        // Add activity only if blog is published
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $wishe, 'seswishe_new');
        // make sure action exists before attaching the blog to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $wishe);

          if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
            $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
            foreach($tags as $tag) {
              $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');  
            }
          }
        }
        $wishe->setFromArray($values);
        if( $action ) {
          $wishe->action_id = $action->getIdentity();
        }
        $wishe->save();

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
//       'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'seswishe_general', true),
//       'messages' => Array(Zend_Registry::get('Zend_Translate')->_('Your wishe has been posted successfully.'))
//     ));
  }
  
  // HELPER FUNCTIONS
  public function handleIframelyInformation($uri) {
  
    $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe_iframely_disallow');
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
    $this->view->wishe_id = $this->_getParam('wishe_id');
    
    $wishe = Engine_Api::_()->getItem('seswishe_wishe', $this->_getParam('wishe_id'));
    
    if (isset($wishe->category_id) && $wishe->category_id != 0)
      $this->view->category_id = $wishe->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
  
    if (isset($wishe->subcat_id) && $wishe->subcat_id != 0)
      $this->view->subcat_id = $wishe->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;
      
    if (isset($wishe->subsubcat_id) && $wishe->subsubcat_id != 0)
      $this->view->subsubcat_id = $wishe->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    
//     if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($wishe, $viewer, 'edit')->isValid() ) return;
    
    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Seswishe_Form_Edit();

      $this->view->category_id = $wishe->category_id;
      $this->view->subcat_id = $wishe->subcat_id;
      $this->view->subsubcat_id = $wishe->subsubcat_id;
      
      // Populate form
      $form->populate($wishe->toArray());

      $tagStr = '';
      foreach( $wishe->tags()->getTagMaps() as $tagMap ) {
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
          if( $auth->isAllowed($wishe, $role, 'view') ) {
           $form->auth_view->setValue($role);
          }
        }

        if ($form->auth_comment){
          if( $auth->isAllowed($wishe, $role, 'comment') ) {
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
        $wishe->setFromArray($values);
        $wishe->modified_date = date('Y-m-d H:i:s');
        $wishe->save();
        
        // Add photo
        if( !empty($_FILES['photo']['name']) ) {
          $wishe->setPhoto($_FILES['photo']);
        }
        
        // Auth
  //       $viewMax = array_search($values['auth_view'], $roles);
  //       $commentMax = array_search($values['auth_comment'], $roles);
  // 
  //       foreach( $roles as $i => $role ) {
  //         $auth->setAllowed($wishe, $role, 'view', ($i <= $viewMax));
  //         $auth->setAllowed($wishe, $role, 'comment', ($i <= $commentMax));
  //       }

        // handle tags
        $tags = preg_split('/[,]+/', $values['tags']);
        $wishe->tags()->setTagMaps($viewer, $tags);

        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags && $wishe->action_id) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$wishe->action_id."'");
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$wishe->action_id.'", "'.$tag.'")');  
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
//       'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'seswishe_general', true),
//       'messages' => Array(Zend_Registry::get('Zend_Translate')->_('Your wishe has been edited successfully.'))
//     ));
  }
  
  public function deleteAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $wishe = Engine_Api::_()->getItem('seswishe_wishe', $this->getRequest()->getParam('wishe_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($wishe, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Seswishe_Form_Delete();

    if( !$wishe ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Wishe entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $wishe->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$wishe->action_id."'");
      }
      $wishe->delete();
      
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your wishe entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'seswishe_general', true),
      'messages' => Array($this->view->message)
    ));
  }
}
