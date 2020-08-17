<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ForumController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_ForumController extends Core_Controller_Action_Standard
{
  public function init()
  {
    if( 0 !== ($forum_id = (int) $this->_getParam('forum_id')) &&
        null !== ($sesforum = Engine_Api::_()->getItem('sesforum_forum', $forum_id)) )
    {
      Engine_Api::_()->core()->setSubject($sesforum);
    }

    else if( 0 !== ($category_id = (int) $this->_getParam('category_id')) &&
        null !== ($category = Engine_Api::_()->getItem('sesforum_category', $category_id)) )
    {
      Engine_Api::_()->core()->setSubject($category);
    }
  }

  public function viewAction()
  {
    if( !$this->_helper->requireSubject('sesforum_forum')->isValid() ) {
      return;
    }
    $sesforum = Engine_Api::_()->core()->getSubject();
    if( !$this->_helper->requireAuth->setAuthParams($sesforum, null, 'view')->isValid() ) {
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer->getIdentity()) {
        $viewerId = 0;
    } else {
        $viewerId = $viewer->level_id;
    }
    $viewPermission = Engine_Api::_()->sesforum()->isAllowed('sesforum_forum',$viewerId, 'view');
     if(!$viewPermission) {
      return;
    }

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
  }

  public function topicCreateAction()
  {
  if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireSubject('sesforum_forum')->isValid() ) {
      return;
    }

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->sesforum = $sesforum = Engine_Api::_()->core()->getSubject();
    if (!$this->_helper->requireAuth()->setAuthParams($sesforum, null, 'topic.create')->isValid() ) {
      return;
    }

    $this->view->form = $form = new Sesforum_Form_Topic_Create();

    // Remove the file element if there is no file being posted
    if( $this->getRequest()->isPost() && empty($_FILES['photo']) ) {
      $form->removeElement('photo');
    }

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $values = $form->getValues();
    $values['user_id'] = $viewer->getIdentity();
    $values['forum_id'] = $sesforum->getIdentity();

    $topicTable = Engine_Api::_()->getDbtable('topics', 'sesforum');
    $topicWatchesTable = Engine_Api::_()->getDbtable('topicwatches', 'sesforum');
    $postTable = Engine_Api::_()->getDbtable('posts', 'sesforum');

    $db = $topicTable->getAdapter();
    $db->beginTransaction();

    try {

      // Create topic
      $topic = $topicTable->createRow();
      $topic->setFromArray($values);
      $topic->title = $values['title'];
      $topic->description = $values['body'];
      $topic->save();

      $tags = preg_split('/[,]+/', $values['tags']);
      $topic->tags()->addTagMaps($viewer, $tags);
      $topic->seo_keywords = implode(',', $tags);

      $topic->save();

      // Create post
      $values['topic_id'] = $topic->getIdentity();

      $post = $postTable->createRow();
      $values['body'] = Engine_Text_BBCode::prepare($values['body']);
      $post->setFromArray($values);
      $post->save();

      if( !empty($values['photo']) ) {
        $post->setPhoto($form->photo);
      }

      $auth = Engine_Api::_()->authorization()->context;
      $auth->setAllowed($topic, 'registered', 'create', true);

      // Create topic watch
      $topicWatchesTable->insert(array(
        'resource_id' => $sesforum->getIdentity(),
        'topic_id' => $topic->getIdentity(),
        'user_id' => $viewer->getIdentity(),
        'watch' => (bool) $values['watch'],
      ));

      $topicLink = '<a href="' . $topic->getHref() . '">' . $topic->getTitle() . '</a>';

      // Add activity
      $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
      $action = $activityApi->addActivity($viewer, $topic, 'sesforum_topic_create',null,  array("topictitle" => $topicLink));
      if( $action ) {
        $action->attach($topic);
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
}
