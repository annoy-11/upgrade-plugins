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



class Sesforum_Widget_BrowseTopicsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
     $settings = Engine_Api::_()->getApi('settings', 'core');
    if(isset($_GET['params']))
        $params = $_GET['params'];

    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->title_truncation_limit = $params['title_truncation_limit'] = isset($params['title_truncation_limit']) ? $params['title_truncation_limit'] : $this->_getParam('title_truncation_limit',45);

    $this->view->description_truncation_limit = $params['description_truncation_limit'] = isset($params['description_truncation_limit']) ? $params['description_truncation_limit'] : $this->_getParam('description_truncation_limit',45);
    $sesforum_widgets = Zend_Registry::isRegistered('sesforum_widgets') ? Zend_Registry::get('sesforum_widgets') : null;
    if(empty($sesforum_widgets))
      return $this->setNoRender();
    $this->view->load_content = $params['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content',"button");
     $params['limit_data'] = $limit_data = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data',$settings->getSetting('sesforum.forum.pagelength',10));

    $this->view->identityForWidget = $params['identity'] = isset($params['identity']) ? $params['identity'] : $this->view->identity;

    // Get sesforums allowed to be viewed by current user
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

    $params['tag_id'] = $tag = isset($params['tag_id']) ? $params['tag_id'] : (isset($_GET['tag_id']) ? $_GET['tag_id'] : null);
    $params['query'] = $query = isset($params['query']) ? $params['query'] : (isset($_GET['query']) ? $_GET['query'] : null);
    $this->view->search_type = $params['search_type'] = $search_type = isset($params['search_type']) ? $params['search_type'] : (isset($_GET['search_type']) ? $_GET['search_type'] : 'topics');


    $topicTable = Engine_Api::_()->getDbtable('topics', 'sesforum');
    $topicTableName = $topicTable->info('name');
    $postsSelect = $topicTable->select()->setIntegrityCheck(false)->from($topicTableName,array('topic_id','forum_id','user_id','title','description','creation_date','modified_date','sticky','closed','post_count','view_count','lastpost_id','lastposter_id','like_count','rating','seo_keywords'))
      ->where($topicTableName.'.forum_id IN(?)', $sesforumIds)
      //->where('user_id = ?', $subject->getIdentity())
      ->order($topicTableName.'.creation_date DESC');

    if(!empty($tag) && isset($tag) ) {

      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $postsSelect->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $topicTableName.topic_id")
	    ->where($tmName.'.resource_type = ?', 'sesforum_topic')
	    ->where($tmName.'.tag_id = ?', $tag);
    }

        if($search_type == "topics"){

          if(!empty($query) && isset($query)) {
            $postsSelect->where($topicTableName.".title LIKE  "."'%" . $query . "%' OR ".$topicTableName.".description LIKE "."'%" . $query . "%'");
          }

        }elseif($search_type == "posts") {
            $postTable = Engine_Api::_()->getDbtable('posts', 'sesforum');
            $postTableName =  $postTable->info('name');
            $postsSelect = $postTable->select()->setIntegrityCheck(false)->from($postTableName);
            if(!empty($query) && isset($query)) {
                $postsSelect->where($postTableName.".body LIKE ? ", '%' . $query . '%');
            }
        }
    $this->view->widgetName = "browse-topics";
    if(!empty($forum_id) && isset($forum_id)) {
       $postsSelect->where('forum_id =?', $forum_id);
    }

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->sesforum_topic_pagelength = $settings->getSetting('sesforum_topic_pagelength');
    $this->view->paginator = $paginator = Zend_Paginator::factory($postsSelect);
    $this->view->page = $page = $_GET['page'] ? $_GET['page'] : $this->_getParam('page', 1);
    $this->view->params = $params;
    $this->view->is_ajax = $is_ajax = isset($_GET['is_ajax']) ? true : false;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);

  }
}
