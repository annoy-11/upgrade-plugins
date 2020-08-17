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
 class Sesforum_Widget_ForumCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $params = array();
    if(isset($_POST['params']))
        $params = $_POST['params'];
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $requestParams = $request->getParams();
    $category_id = $requestParams['category_id'];
    if ($category_id)
      $category_id = Engine_Api::_()->getDbTable('categories', 'sesforum')->getCategoryId($category_id);
    $this->view->openTab = $openTab = isset($_POST['openTab']) ? $_POST['openTab'] : 'all';
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->itemCount = isset($_POST['itemCount']) ? $_POST['itemCount'] : 0;
    $this->view->showTopics  = $showTopics  =  isset($_POST['showTopics']) ? $_POST['showTopics'] : $this->_getParam('showTopics','1');
    $this->view->showForums  = $showForums  =  isset($_POST['showForum']) ? $_POST['showForum'] : $this->_getParam('showForum','1');
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    if($openTab == 'category' || $openTab == 'all'){
        $this->view->cat2ndShow  = $params['showcategory'] = isset($params['showcategory']) ? $params['showcategory'] : $this->_getParam('showcategory',1);
        $this->view->description_truncation_category  = $params['description_truncation_category'] = isset($params['description_truncation_category']) ? $params['description_truncation_category'] : $this->_getParam('description_truncation_category',45);
        $this->view->description_truncation_post  = $params['description_truncation_post'] = isset($params['description_truncation_post']) ? $params['description_truncation_post'] : $this->_getParam('description_truncation_post',45);
        $this->view->themecolor  = $params['themecolor'] = isset($params['themecolor']) ? $params['themecolor'] : $this->_getParam('themecolor','theme');
        $this->view->iconShape  = $params['iconShape'] = isset($params['iconShape']) ? $params['iconShape'] : $this->_getParam('iconShape',1);
        $this->view->load_content  = $params['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content',"button");

        $limit_data = $params['limit_data'] = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data',5);
        $show_criterias = $params['show_criteria']  = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('topicCount', 'postCount','postDetails'));
        if(is_array($show_criterias)){
        foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria} = $show_criteria;
        }
        $this->view->params = $params;
    }
    $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : $this->view->identity;
     $this->view->widgetName = 'forum-category';
    $this->view->category_id = $category_id = isset($params['category_id']) ? $params['category_id'] : $category_id;
     $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesforum');
    if($category_id){
        if($openTab == 'category' || $openTab == 'all'){
            $select = $categoryTable->getCategoriesAssoc(array('limit'=>$limit_data,'category_id'=>$category_id,'widget'=>1));
        }
        if(($openTab == 'forum' || $openTab == 'all')){
             $forum_page = isset($_POST['forum_page']) ? $_POST['forum_page'] : 1;
            $forum_limit_data = $forumParams['forum_limit_data'] =  isset($params['forum_limit_data']) ? $params['forum_limit_data'] : $this->_getParam('forum_limit_data',5);
            $this->view->forum_load_content  = $topicParams['forum_load_content'] = isset($params['forum_load_content']) ? $params['forum_load_content'] : $this->_getParam('forum_load_content',"button");
            $sesforumTable = Engine_Api::_()->getItemTable('sesforum_forum');
            $sesforumSelect = $sesforumTable->select()->where('category_id = ?',$category_id)
            ->order('order ASC')->limit($forum_limit_data);
            $this->view->forumPaginator = $forumPaginator = Zend_Paginator::factory($sesforumSelect);
            $forumPaginator->setItemCountPerPage($forum_limit_data);
            $forumPaginator->setCurrentPageNumber($forum_page);
             $this->view->forum_page = $forum_page;
            $this->view->forumParams = $forumParams;
        }
        if(($openTab == 'topic' || $openTab == 'all')){
             $this->view->topic_load_content  = $topicParams['topic_load_content'] = isset($params['topic_load_content']) ? $params['topic_load_content'] : $this->_getParam('topic_load_content',"button");
            $topic_limit_data = $topicParams['topic_limit_data'] = isset($params['topic_limit_data']) ? $params['topic_limit_data'] : $this->_getParam('topic_limit_data',5);
            $topic_page = isset($_POST['topic_page']) ? $_POST['topic_page'] : 1;
            $topicTable = Engine_Api::_()->getItemTable('sesforum_topic');
            $topicTableName = $topicTable->info('name');
            $forumTable = Engine_Api::_()->getItemTable('sesforum_forum')->info('name');
            $topicSelect = $topicTable->select()->from($topicTableName,'*')
                ->setIntegrityCheck(false)->joinLeft($forumTable, "$forumTable.forum_id = $topicTableName.forum_id",null)
                ->where($forumTable.".category_id = ?",$category_id);
            $this->view->topicPaginator = $topicPaginator = Zend_Paginator::factory($topicSelect);
            $topicPaginator->setItemCountPerPage($topic_limit_data);
            $topicPaginator->setCurrentPageNumber($topic_page);
            $this->view->topic_page = $topic_page;
            $this->view->topicparams = $topicParams;
        }
    } else {
        $select = $categoryTable->getCategoriesAssoc(array('limit'=>$limit_data));
    }
    if($openTab == 'category' || $openTab == 'all'){
        $this->view->paginator = $paginator = Zend_Paginator::factory($select);
        $paginator->setItemCountPerPage($limit_data);
        $paginator->setCurrentPageNumber($page);
        $this->view->page = $page;
    }
     if ($is_ajax)
    $this->getElement()->removeDecorator('Container');
  }
}
