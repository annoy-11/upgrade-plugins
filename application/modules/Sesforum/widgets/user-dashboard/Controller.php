<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



class Sesforum_Widget_UserDashboardController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {
        if(isset($_POST['params']))
            $params = $_POST['params'];
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $requestParams = $request->getParams();

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->view->show_criterias = $show_criterias = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('myTopics', 'myPosts', 'mySubscribedTopics',"TopicsILiked","postsILiked"));

         $params['limit_data'] = $limit_data = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data',$settings->getSetting('sesforum.forum.pagelength',10));

        $page = $_POST['page'] ? $_POST['page'] : $this->_getParam('page', 1);
        $this->view->view_type = $type = $_POST['type'] ? $_POST['type'] : $requestParams['type'];
        $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : $this->view->identity;

        $this->view->load_content = $params['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content',"button");

         $this->view->widgetName = 'user-dashboard';

         $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
         $this->view->request_ajax = $request_ajax = isset($_POST['request_ajax']) ? true : false;
        $sesforum_widgets = Zend_Registry::isRegistered('sesforum_widgets') ? Zend_Registry::get('sesforum_widgets') : null;
        if(empty($sesforum_widgets))
          return $this->setNoRender();
        if(is_array($show_criterias)){
        foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria} = $show_criteria;
        }
        if(is_null($show_criterias) || empty($show_criterias))
            return $this->setNoRender();

        if($type == 'topics-i-liked') {
            $liked = 1;
            $type = 'topics';
        } elseif($type == 'posts-i-liked'){
             $liked = 1;
            $type = 'posts';
        } elseif($type == 'my-subscriptions'){
             $liked = 2;
            $type = 'topics';
        } elseif($type == 'my-topics'){
            $type = 'topics';
        }elseif($type ==  'my-posts'){
            $type = 'posts';
        } else if($type == 'signature') {
           $type =  'signature';
        }
        $this->view->liked = $params['liked'] = $liked = isset($_POST['liked']) ? $_POST['liked'] : $liked;

        $viewer = Engine_Api::_()->user()->getViewer();
        // Get sesforums allowed to be viewed by current user

    if($type != "signature") {

        $sesforumIds = array();
        $authTable = Engine_Api::_()->getDbtable('allow', 'authorization');
        $perms = $authTable->select()
            ->where('resource_type = ?', 'sesforum_forum')
            ->where('action = ?', 'view')
            ->query()
            ->fetchAll();
        foreach( $perms as $perm ) {
            if( $perm['role'] == 'everyone' ) {
                $sesforumIds[] = $perm['resource_id'];
            } else if( $viewer &&
                $viewer->getIdentity() &&
                $perm['role'] == 'authorization_level' &&
                $perm['role_id'] == $viewer->level_id ) {
                $sesforumIds[] = $perm['resource_id'];
            }
        }

        if($type == "topics") {

            // Get paginator
            $postsTable = Engine_Api::_()->getDbtable('topics', 'sesforum');
            $likeTableName = Engine_Api::_()->getDbtable('likes', 'core')->info('name');
            $topicwatchesTableName = Engine_Api::_()->getDbTable('topicwatches', 'sesforum')->info('name');
            $postsSelect = $postsTable->select();
            if(!empty($liked) && $liked == '1') {
                $postsSelect->setIntegrityCheck(false)
                ->from($postsTable->info('name'))
                ->join($likeTableName, $likeTableName . '.resource_id = ' . $postsTable->info('name') . '.topic_id', null)->where($likeTableName.'.resource_type = ?', 'sesforum_topic')->where($likeTableName.'.poster_id = ?', $viewer->getIdentity());
            } elseif(!empty($liked) && $liked == '2') {
                $postsSelect->setIntegrityCheck(false)
                ->from($postsTable->info('name'))
                ->join($topicwatchesTableName, $topicwatchesTableName . '.topic_id = ' . $postsTable->info('name') . '.topic_id', null)->where($topicwatchesTableName.'.watch =?', 1)->where($topicwatchesTableName.'.user_id =?', $viewer->getIdentity())->group($topicwatchesTableName.'.topic_id');
            }

            $postsSelect->where('forum_id IN(?)', $sesforumIds)
                        ->order('creation_date DESC');
            if(empty($liked))
                $postsSelect->where('user_id = ?', $viewer->getIdentity());
        } else {

            $likeTableName = Engine_Api::_()->getDbtable('likes', 'core')->info('name');
            $postsTable = Engine_Api::_()->getDbtable('posts', 'sesforum');
            $postsSelect = $postsTable->select()->order('creation_date DESC');

            if(!empty($liked) && $liked == '1') {
                $postsSelect->setIntegrityCheck(false)
                ->from($postsTable->info('name'))
                ->join($likeTableName, $likeTableName . '.resource_id = ' . $postsTable->info('name') . '.post_id', null)->where($likeTableName.'.resource_type = ?', 'sesforum_post');
                $postsSelect->where($likeTableName.'.poster_id = ?', $viewer->getIdentity())->where($postsTable->info('name').'.forum_id IN(?)', $sesforumIds);
            } else {
                $postsSelect->where('user_id = ?', $viewer->getIdentity())->where('forum_id IN(?)', $sesforumIds);
            }
        }
            $this->view->params = $params;
            $this->view->sesforum_topic_pagelength = $settings->getSetting('sesforum_topic_pagelength');
            $this->view->paginator = $paginator = Zend_Paginator::factory($postsSelect);
            $this->view->page = $page;
            // Set item count per page and current page number
            $paginator->setItemCountPerPage($limit_data);
            $paginator->setCurrentPageNumber($page);
    } else if(in_array('signature',$show_criterias)){
        $this->view->form = $form = new Sesforum_Form_Signature();
         $viewer = Engine_Api::_()->user()->getViewer();
        $allowHtml = (bool) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum_html', 0);
        $allowBbcode = (bool) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum_bbcode', 0);
        $signatureTable = Engine_Api::_()->getDbTable('signatures','sesforum');
        $signature = $signatureTable->getSignature();
        if(!count($signature)){
              if(isset($_POST['body'])) {
                $signature = $signatureTable->createRow();

                $signature->body = Engine_Text_BBCode::prepare($_POST['body']);
                $signature->user_id = $viewer->getIdentity();
                $signature->creation_date = date('Y-m-d H:i:s');
                $signature->modified_date = date('Y-m-d H:i:s');
                $signature->save();
                $form->addNotice('Your changes have been saved.');
             }
        }
        else{
          if(isset($_POST['body'])) {
            $signature->body = Engine_Text_BBCode::prepare($_POST['body']);
            $signature->user_id = $viewer->getIdentity();
            $signature->modified_date = date('Y-m-d H:i:s');
            $signature->save();
            $form->addNotice('Your changes have been saved.');
          }
        }
        if(!empty($signature)) {
            if (!$allowHtml && !$allowBbcode ) {
                    $form->body->setValue(strip_tags($signature->body));
            } elseif($allowHtml ) {
               $form->body->setValue(htmlspecialchars_decode($signature->body, ENT_COMPAT));
            } else {
                $form->body->setValue(htmlspecialchars_decode($signature->body, ENT_COMPAT));
            }
        }
    }
    $this->view->type = $type;
  }
}
