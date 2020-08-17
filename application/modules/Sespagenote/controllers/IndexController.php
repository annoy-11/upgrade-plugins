<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_IndexController extends Core_Controller_Action_Standard
{
    public function init() {
        $id = $this->_getParam('pagenote_id', $this->_getParam('pagenote_id', null));
            if ($id && intval($id)) {
            $note = Engine_Api::_()->getItem('pagenote', $id);
            if ($note) {
                Engine_Api::_()->core()->setSubject($note);
            }
        }
    }

	public function browseAction() {
        // Render
        $this->_helper->content->setEnabled();
	}
    public function homeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }

  public function viewAction()
  {
    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $note = Engine_Api::_()->getItem('pagenote', $this->_getParam('pagenote_id'));
    if( !$note ) {
      Engine_Api::_()->core()->setSubject($note);
    }

    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    if( !$this->_helper->requireAuth()->setAuthParams($note, $viewer, 'view')->isValid() ) {
      return;
    }

    if( !$note || !$note->getIdentity() ||
        ($note->draft && !$note->isOwner($viewer)) ) {
      return $this->_helper->requireSubject->forward();
    }

    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_sespage_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $note->getIdentity() . '", "' . $note->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    // Prepare data
    $noteTable = Engine_Api::_()->getDbtable('pagenotes', 'sespagenote');
    if( !$note->isOwner($viewer) ) {
      $noteTable->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'pagenote_id = ?' => $note->getIdentity(),
      ));
    }
    // Render
    $this->_helper->content->setEnabled();
  }

  public function deleteAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $note = Engine_Api::_()->getItem('pagenote', $this->getRequest()->getParam('pagenote_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($note, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sespagenote_Form_Delete();

    if( !$note ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Note entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $note->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $note->delete();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your note entry has been deleted.');

    $parentItem = Engine_Api::_()->getItem('sespage_page', $this->_getParam('parent_id', null));

    $widgetId = Engine_Api::_()->sespage()->getIdentityWidget('sespagenote.profile-notes','widget','sespage_profile_index_'.$parentItem->pagestyle);
    if($widgetId)
        $widgetId = '/tab/'.$widgetId;
    else
        $widgetId = '';

    $url = $parentItem->getHref().$widgetId;

    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => $url,
      'messages' => Array($this->view->message)
    ));
  }

  public function editAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content->setEnabled();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sespage_main');

    $note = Engine_Api::_()->getItem('pagenote', $this->_getParam('pagenote_id'));
    if( !Engine_Api::_()->core()->hasSubject('pagenote') ) {
      Engine_Api::_()->core()->setSubject($note);
    }

    $parent_id = $this->_getParam('parent_id', null);
    if(empty($parent_id))
        return;

    $this->view->parentItem = $parentItem = Engine_Api::_()->getItem('sespage_page', $parent_id);

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($note, $viewer, 'edit')->isValid() ) return;

    // Prepare form
    $this->view->form = $form = new Sespagenote_Form_Edit();

    // Populate form
    $form->populate($note->toArray());

    $tagStr = '';
    foreach( $note->tags()->getTagMaps() as $tagMap ) {
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
        if( $auth->isAllowed($note, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($note, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $note->draft == "0" ) {
      $form->removeElement('draft');
    }

    // Check post/form
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {
      $values = $form->getValues();

      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }
      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $values['view_privacy'] = $values['auth_view'];
      $values['parent_id'] = $parent_id;

      $note->setFromArray($values);
      $note->modified_date = date('Y-m-d H:i:s');
      $note->save();

      // Add photo
      if( !empty($values['photo']) ) {
        $note->setPhoto($form->photo);
      }

      // Auth
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($note, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($note, $role, 'comment', ($i <= $commentMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $note->tags()->setTagMaps($viewer, $tags);

      // insert new activity if pagenote is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($note);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' ) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $note, 'sespagenote_new');
          // make sure action exists before attaching the pagenote to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $note);
        }
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($note) as $action ) {
        $actionTable->resetActivityBindings($action);
      }
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'view',  'pagenote_id' => $note->getIdentity(), 'slug' => $note->getSlug()), 'sespagenote_view', true);
  }

    public function createAction() {

        if (!$this->_helper->requireUser->isValid())
        return;

        if( !$this->_helper->requireAuth()->setAuthParams('pagenote', null, 'create')->isValid()) return;
        $parent_id = $this->_getParam('parent_id', null);
        if(empty($parent_id))
            return;

        $this->view->parentItem = $parentItem = Engine_Api::_()->getItem('sespage_page', $parent_id);

        $getPageRolePermission = Engine_Api::_()->sespage()->getPageRolePermission($parentItem->getIdentity(),'post_content','note',false);

        $allowed = true;
        $canUpload = $getPageRolePermission ? $getPageRolePermission : $parentItem->authorization()->isAllowed($viewer, 'note');
        $canUpload = !$allowed ? false : $canUpload;
        if(!$canUpload)
            return $this->_forward('notfound', 'error', 'core');

        // Render
        $this->_helper->content->setEnabled();

        // set up data needed to check quota
        $viewer = Engine_Api::_()->user()->getViewer();
        $values['user_id'] = $viewer->getIdentity();
        $values['parent_id'] = $parent_id;
//         $paginator = Engine_Api::_()->getItemTable('pagenote')->getNotesPaginator($values);
//
//         $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'pagenote', 'max');
//         $this->view->current_count = $paginator->getTotalItemCount();

        // Prepare form
        $this->view->form = $form = new Sespagenote_Form_Create();

        // If not post or form not valid, return
        if( !$this->getRequest()->isPost() ) {
            return;
        }

        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }

        // Process
        $table = Engine_Api::_()->getItemTable('pagenote');
        $db = $table->getAdapter();
        $db->beginTransaction();

        try {
        // Create pagenote
        $viewer = Engine_Api::_()->user()->getViewer();
        $formValues = $form->getValues();

        if( empty($formValues['auth_view']) ) {
            $formValues['auth_view'] = 'everyone';
        }

        if( empty($formValues['auth_comment']) ) {
            $formValues['auth_comment'] = 'everyone';
        }

        $values = array_merge($formValues, array(
            'owner_type' => $viewer->getType(),
            'owner_id' => $viewer->getIdentity(),
            'parent_id' => $parent_id,
            'view_privacy' => $formValues['auth_view'],
        ));

        $note = $table->createRow();
        $note->setFromArray($values);
        $note->save();

        if( !empty($values['photo']) ) {
            $note->setPhoto($form->photo);
        }

        // Auth
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        $viewMax = array_search($formValues['auth_view'], $roles);
        $commentMax = array_search($formValues['auth_comment'], $roles);

        foreach( $roles as $i => $role ) {
            $auth->setAllowed($note, $role, 'view', ($i <= $viewMax));
            $auth->setAllowed($note, $role, 'comment', ($i <= $commentMax));
        }

        // Add tags
        $tags = preg_split('/[,]+/', $values['tags']);
        $note->tags()->addTagMaps($viewer, $tags);

        // Add activity only if pagenote is published
        if( $values['draft'] == 0 ) {
            $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $parentItem, 'sespagenote_new');
            // make sure action exists before attaching the pagenote to the activity
            if( $action ) {
                Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $note);
            }
        }
        // Commit
        $db->commit();
        } catch( Exception $e ) {
            return $this->exceptionWrapper($e, $form, $db);
        }

        $widgetId = Engine_Api::_()->sespage()->getIdentityWidget('sespagenote.profile-notes','widget','sespage_profile_index_'.$parentItem->pagestyle);
        if($widgetId)
        $widgetId = '/tab/'.$widgetId;
        else
        $widgetId = '';

        $url = $parentItem->getHref().$widgetId;
        header("location:".$url);
    }
}
