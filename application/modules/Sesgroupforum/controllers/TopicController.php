<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: TopicController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_TopicController extends Core_Controller_Action_Standard {

  public function init() {
  
    if( 0 !== ($topic_id = (int) $this->_getParam('topic_id')) &&
        null !== ($topic = Engine_Api::_()->getItem('sesgroupforum_topic', $topic_id)) &&
        $topic instanceof Sesgroupforum_Model_Topic ) {
      Engine_Api::_()->core()->setSubject($topic);
    }
  }

  public function deleteAction() {
  
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams('sesgroupforum', null, 'topic.delete')->isValid() ) {
      return;
    }

    $this->view->form = $form = new Sesgroupforum_Form_Topic_Delete();

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $table = Engine_Api::_()->getItemTable('sesgroupforum_topic');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try
    {
      $topic->delete();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Topic deleted.')),
      'layout' => 'default-simple',
      'parentRedirect' => $sesgroupforum->getHref(),
    ));
  }

  public function editAction()
  {
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams($sesgroupforum, null, 'topic.edit')->isValid() ) {
      return;
    }

    $this->view->form = $form = new Sesgroupforum_Form_Topic_Edit();

    if( !$this->getRequest()->isPost() )
    {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    // Process
    $table = Engine_Api::_()->getItemTable('sesgroupforum_topic');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      $values = $form->getValues();

      $topic->setFromArray($values);
      $topic->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
  }

  public function viewAction()
  {
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->_helper->content->setEnabled();
  }

  public function stickyAction()
  {
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams('sesgroupforum', null, 'topic.edit')->isValid() ) {
      return;
    }

    $table = $topic->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      $topic = Engine_Api::_()->core()->getSubject();
      $topic->sticky = ( null === $this->_getParam('sticky') ? !$topic->sticky : (bool) $this->_getParam('sticky') );
      $topic->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    $this->_redirectCustom($topic);
  }

  public function closeAction()
  {
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams('sesgroupforum', null, 'topic.edit')->isValid() ) {
      return;
    }

    $table = $topic->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      $topic = Engine_Api::_()->core()->getSubject();
      $topic->closed = ( null === $this->_getParam('closed') ? !$topic->closed : (bool) $this->_getParam('closed') );
      $topic->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    $this->_redirectCustom($topic);
  }

  public function renameAction()
  {
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams('sesgroupforum', null, 'topic.edit')->isValid() ) {
      return;
    }

    $this->view->form = $form = new Sesgroupforum_Form_Topic_Rename();

    if( !$this->getRequest()->isPost() )
    {
      $form->title->setValue(htmlspecialchars_decode(($topic->title)));
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    $table = $topic->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      $title = $form->getValue('title');
      $topic = Engine_Api::_()->core()->getSubject();
      $topic->title = $title;
      $topic->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Topic renamed.')),
      'layout' => 'default-simple',
      'parentRefresh' => true,
    ));
  }

  public function moveAction()
  {
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams('sesgroupforum', null, 'topic.edit')->isValid() ) {
      return;
    }

    $this->view->form = $form = new Sesgroupforum_Form_Topic_Move();

    // Populate with options
    $multiOptions = array();
    foreach( Engine_Api::_()->getItemTable('sesgroupforum')->fetchAll() as $sesgroupforum ) {
      $multiOptions[$sesgroupforum->getIdentity()] = $this->view->translate($sesgroupforum->getTitle());
    }
    $form->getElement('forum_id')->setMultiOptions($multiOptions);

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();

    $table = $topic->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      // Update topic
      $topic->forum_id = $values['forum_id'];
      $topic->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Topic moved.')),
      'layout' => 'default-simple',
      //'parentRefresh' => true,
      'parentRedirect' => $topic->getHref(),
    ));
  }

  public function postCreateAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->group = Engine_Api::_()->getItem('sesgroup_group', $topic->group_id);
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams($sesgroupforum, null, 'post.create')->isValid() ) {
      return;
    }
    if($topic->closed ) {
      return;
    }

    $this->view->form = $form = new Sesgroupforum_Form_Post_Create();

    // Remove the file element if there is no file being posted
    if( $this->getRequest()->isPost() && empty($_FILES['photo']) ) {
      $form->removeElement('photo');
    }

    $allowHtml = (bool) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupforum_html', 0);

    $allowBbcode = (bool) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupforum_bbcode', 0);

    $quote_id = $this->getRequest()->getParam('quote_id');
    if( !empty($quote_id) ) {
      $quote = Engine_Api::_()->getItem('sesgroupforum_post', $quote_id);
      if($quote->user_id == 0) {
          $owner_name = Zend_Registry::get('Zend_Translate')->_('Deleted Member');
      } else {
          $owner_name = $quote->getOwner()->__toString();
      }
      if ( !$allowHtml && !$allowBbcode ) {
		$form->body->setValue( strip_tags($this->view->translate('%1$s said:', $owner_name)) . " ''" . strip_tags($quote->body) . "''\n-------------\n" );
	  } elseif( $allowHtml ) {
        $form->body->setValue("<blockquote><strong>" . $this->view->translate('%1$s said:', $owner_name) . "</strong><br />" . $quote->body . "</blockquote><br />");
      } else {
        $form->body->setValue("[quote][b]" . strip_tags($this->view->translate('%1$s said:', $owner_name)) . "[/b]\r\n" . htmlspecialchars_decode($quote->body, ENT_COMPAT) . "[/quote]\r\n");
      }
    }

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $values = $form->getValues();
    $values['body'] = Engine_Text_BBCode::prepare($values['body']);
    $values['user_id'] = $viewer->getIdentity();
    $values['topic_id'] = $topic->getIdentity();
    $values['forum_id'] = $sesgroupforum->getIdentity();

    $topicTable = Engine_Api::_()->getDbtable('topics', 'sesgroupforum');
    $topicWatchesTable = Engine_Api::_()->getDbtable('topicwatches', 'sesgroupforum');
    $postTable = Engine_Api::_()->getDbtable('posts', 'sesgroupforum');
    $userTable = Engine_Api::_()->getItemTable('user');
    $notifyApi = Engine_Api::_()->getDbtable('notifications', 'activity');
    $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');

    $viewer = Engine_Api::_()->user()->getViewer();
    $topicOwner = $topic->getOwner();
    $isOwnTopic = $viewer->isSelf($topicOwner);

    $watch = 1;
    $isWatching = $topicWatchesTable
      ->select()
      ->from($topicWatchesTable->info('name'), 'watch')
      ->where('resource_id = ?', $sesgroupforum->getIdentity())
      ->where('topic_id = ?', $topic->getIdentity())
      ->where('user_id = ?', $viewer->getIdentity())
      ->limit(1)
      ->query()
      ->fetchColumn(0)
      ;

    $db = $postTable->getAdapter();
    $db->beginTransaction();

    try {

      $post = $postTable->createRow();
      $post->setFromArray($values);
      $post->save();

      if( !empty($values['photo']) ) {
        try {
          $post->setPhoto($form->photo);
        } catch( Engine_Image_Adapter_Exception $e ) {}
      }

      // Watch
      if( false === $isWatching ) {
        $topicWatchesTable->insert(array(
          'resource_id' => $sesgroupforum->getIdentity(),
          'topic_id' => $topic->getIdentity(),
          'user_id' => $viewer->getIdentity(),
          'watch' => (bool) $watch,
        ));
      } else if( $watch != $isWatching ) {
        $topicWatchesTable->update(array(
          'watch' => (bool) $watch,
        ), array(
          'resource_id = ?' => $sesgroupforum->getIdentity(),
          'topic_id = ?' => $topic->getIdentity(),
          'user_id = ?' => $viewer->getIdentity(),
        ));
      }
      $topicLink = '<a href="' . $topic->getHref() . '">' . $topic->getTitle() . '</a>';
      // Activity
      $action = $activityApi->addActivity($viewer, $topic, 'sesgroupforum_topic_reply',null,  array("topictitle" => $topicLink));
      if( $action ) {
        $action->attach($post, $topic);
      }

      // Notifications
      $notifyUserIds = $topicWatchesTable->select()
        ->from($topicWatchesTable->info('name'), 'user_id')
        ->where('resource_id = ?', $sesgroupforum->getIdentity())
        ->where('topic_id = ?', $topic->getIdentity())
        ->where('watch = ?', 1)
        ->query()
        ->fetchAll(Zend_Db::FETCH_COLUMN)
        ;

      foreach( $userTable->find($notifyUserIds) as $notifyUser ) {
        // Don't notify self
        if( $notifyUser->isSelf($viewer) ) {
          continue;
        }
        if($notifyUser->isSelf($topicOwner) ) {
          $type = 'sesgroupforum_topic_response';
        } else {
          $type = 'sesgroupforum_topic_reply';
        }
        $notifyApi->addNotification($notifyUser, $viewer, $topic, $type, array(
          'message' => $this->view->BBCode($post->body),
          'postGuid' => $post->getGuid(),
        ));
      }

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_redirectCustom($post);
  }

  public function watchAction()
  {
    if( !$this->_helper->requireSubject('sesgroupforum_topic')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum = $sesgroupforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams($sesgroupforum, $viewer, 'view')->isValid() ) {
      return;
    }

    $watch = $this->_getParam('watch', true);

    $topicWatchesTable = Engine_Api::_()->getDbtable('topicwatches', 'sesgroupforum');
    $db = $topicWatchesTable->getAdapter();
    $db->beginTransaction();

    try
    {
      $isWatching = $topicWatchesTable
        ->select()
        ->from($topicWatchesTable->info('name'), 'watch')
        ->where('resource_id = ?', $sesgroupforum->getIdentity())
        ->where('topic_id = ?', $topic->getIdentity())
        ->where('user_id = ?', $viewer->getIdentity())
        ->limit(1)
        ->query()
        ->fetchColumn(0)
        ;

        if($topic->user_id != $viewer->getIdentity() && $watch == 1) {
            $owner = Engine_Api::_()->getItem('user', $topic->user_id);
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $topic, 'sesgroupforum_topicsubs');
        }
      if( false === $isWatching ) {
        $topicWatchesTable->insert(array(
          'resource_id' => $sesgroupforum->getIdentity(),
          'topic_id' => $topic->getIdentity(),
          'user_id' => $viewer->getIdentity(),
          'watch' => (bool) $watch,
        ));
      } else if( $watch != $isWatching ) {
        $topicWatchesTable->update(array(
          'watch' => (bool) $watch,
        ), array(
          'resource_id = ?' => $sesgroupforum->getIdentity(),
          'topic_id = ?' => $topic->getIdentity(),
          'user_id = ?' => $viewer->getIdentity(),
        ));
      }

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    $this->_redirectCustom($topic);
  }
}
