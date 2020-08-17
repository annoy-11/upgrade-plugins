<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ForumController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_ForumController extends Core_Controller_Action_Standard
{
  public function init()
  {
    if( 0 !== ($forum_id = (int) $this->_getParam('forum_id')) &&
        null !== ($sesgroupforum = Engine_Api::_()->getItem('sesgroupforum', $forum_id)) )
    {
      Engine_Api::_()->core()->setSubject($sesgroupforum);
    }

    else if( 0 !== ($category_id = (int) $this->_getParam('category_id')) &&
        null !== ($category = Engine_Api::_()->getItem('sesgroupforum_category', $category_id)) )
    {
      Engine_Api::_()->core()->setSubject($category);
    }
  }

  public function topicCreateAction() {

    if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireSubject('sesgroupforum')->isValid() ) {
      return;
    }

    // Render
    $this->_helper->content->setEnabled();

    $this->view->group_id = $group_id = $this->_getParam('group_id', null);
    if(empty($group_id))
      return;
    $this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->sesgroupforum = $sesgroupforum = Engine_Api::_()->core()->getSubject();
    if (!$this->_helper->requireAuth()->setAuthParams($sesgroupforum, null, 'topic.create')->isValid() ) {
      return;
    }

    $this->view->form = $form = new Sesgroupforum_Form_Topic_Create();

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
    $values['forum_id'] = $sesgroupforum->getIdentity();

    $topicTable = Engine_Api::_()->getDbtable('topics', 'sesgroupforum');
    $topicWatchesTable = Engine_Api::_()->getDbtable('topicwatches', 'sesgroupforum');
    $postTable = Engine_Api::_()->getDbtable('posts', 'sesgroupforum');

    $db = $topicTable->getAdapter();
    $db->beginTransaction();

    try {

      // Create topic
      $topic = $topicTable->createRow();
      $topic->setFromArray($values);
      $topic->title = $values['title'];
      $topic->description = $values['body'];
      $topic->group_id = $group_id;
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
        'resource_id' => $sesgroupforum->getIdentity(),
        'topic_id' => $topic->getIdentity(),
        'user_id' => $viewer->getIdentity(),
        'watch' => (bool) $values['watch'],
      ));

      $topicLink = '<a href="' . $topic->getHref() . '">' . $topic->getTitle() . '</a>';

      // Add activity
      $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
      $action = $activityApi->addActivity($viewer, $topic, 'sesgroupforum_topic_create',null,  array("topictitle" => $topicLink));
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
