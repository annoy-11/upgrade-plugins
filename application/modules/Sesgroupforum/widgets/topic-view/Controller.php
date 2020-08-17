<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroupforum_Widget_TopicViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if(!Engine_Api::_()->core()->hasSubject('sesgroupforum_topic'))
        return $this->setNoRender();
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $this->view->topic = $topic = Engine_Api::_()->core()->getSubject('sesgroupforum_topic');
    $this->view->sesgroupforum =  $sesgroupforum = $topic->getParent();
    $this->view->sesgroup = $sesgroup = Engine_Api::_()->getItem('sesgroup_group', $topic->group_id);
     $show_criterias = $this->_getParam('show_criteria', array('likeCount', 'ratings', 'postReply',"shareButton","subscribeButton","backToTopicButton","quote","likeButton","thankButton","replyCount"));
    $limit_data = $this->_getParam('limit_data',10);
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria} = $show_criteria;
    }

    $show_details = $this->_getParam('show_details', array('thanksCount', 'reputationCount', 'postsCount'));
    if(is_array($show_details)){
      foreach ($show_details as $show_detail)
      $this->view->{$show_detail} = $show_detail;
    }
    $this->view->tags = $tags = $this->_getParam('tags',1);
    $this->view->rating_count = Engine_Api::_()->sesgroupforum()->ratingCount($topic->getIdentity());
    $this->view->rated = Engine_Api::_()->sesgroupforum()->checkRated($topic->getIdentity(), $viewer->getIdentity());
    $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    // Settings
    $this->view->settings = $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->post_id = $post_id = (int) @$searchParams['post_id'];
    $this->view->decode_bbcode = $settings->getSetting('sesgroupforum_bbcode');

     if($viewer->getIdentity())
        $levelId = $viewer->level_id;
    else
        $levelId = 5;
    // Views
    if( !$viewer || !$viewer->getIdentity() || $viewer->getIdentity() != $topic->user_id ) {
      $topic->view_count = new Zend_Db_Expr('view_count + 1');
      $topic->save();
    }

    // Check watching
    $isWatching = null;
    if( $viewer->getIdentity() ) {
      $topicWatchesTable = Engine_Api::_()->getDbtable('topicwatches', 'sesgroupforum');
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
      if( false === $isWatching ) {
        $isWatching = null;
      } else {
        $isWatching = (bool) $isWatching;
      }
    }
    $this->view->isWatching = $isWatching;

    // Auth for topic
    $canPost = false;
    $canEdit = false;
    $canDelete = false;
    $canPostPerminsion = Engine_Api::_()->sesgroupforum()->isAllowed('sesgroupforum',$levelId, 'post_create');
    if(!$topic->closed && $canPostPerminsion) {
      $canPost = $canPostPerminsion->value;
    }
    $canEditPerminsion = Engine_Api::_()->sesgroupforum()->isAllowed('sesgroupforum',$levelId, 'topic_edit');
    if($canEditPerminsion) {
      $canEdit = $canEditPerminsion->value;
    }
    // echo $canEdit;
    $canDeletePerminsion = Engine_Api::_()->sesgroupforum()->isAllowed('sesgroupforum',$levelId, 'topic_delete');
    if($canDeletePerminsion) {
      $canDelete = $canDeletePerminsion->value;
    }

    $this->view->canPost = $canPost;
    $this->view->canEdit = $canEdit;
    $this->view->canDelete = $canDelete;

    // Auth for posts
    $canEdit_Post = false;
    $canDelete_Post = false;
    if($viewer->getIdentity()){
      $canEdit_Post = Engine_Api::_()->sesgroupforum()->isAllowed('sesgroupforum',$levelId, 'post_edit')->value;
      $canDelete_Post = Engine_Api::_()->sesgroupforum()->isAllowed('sesgroupforum',$levelId, 'post_delete')->value;
    }
    $this->view->canEdit_Post = $canEdit_Post;
    $this->view->canDelete_Post = $canDelete_Post;

    // Make form
    if( $canPost ) {
      $this->view->form = $form = new Sesgroupforum_Form_Post_Quick();
      $form->setAction($topic->getHref(array('action' => 'post-create')));
      $form->populate(array(
        'topic_id' => $topic->getIdentity(),
        'ref' => $topic->getHref(),
        'watch' => ( false === $isWatching ? '0' : '1' ),
      ));
    }
    // Keep track of topic user views to show them which ones have new posts
    if( $viewer->getIdentity() ) {
      $topic->registerView($viewer);
    }

    $table = Engine_Api::_()->getItemTable('sesgroupforum_post');
    $select = $topic->getChildrenSelect('sesgroupforum_post', array('order'=>'post_id ASC'));
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($limit_data);

    // set up variables for pages
    $page_param = (int) @$searchParams['page'];
    $post = Engine_Api::_()->getItem('sesgroupforum_post', $post_id);

    // if there is a post_id
    if( $post_id && $post && !$page_param )
    {
      $icpp = $paginator->getItemCountPerPage();
      $post_page = ceil(($post->getPostIndex() + 1) / $icpp);

      $paginator->setCurrentPageNumber($post_page);
    }
    // Use specified page
    else if( $page_param )
    {
      $paginator->setCurrentPageNumber($page_param);
    }
  }
}

