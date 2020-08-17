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
class Sesforum_Widget_ForumViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if(isset($_POST['params']))
        $params = $_POST['params'];
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->showModerators = $params['moderators'] = isset($params['moderators']) ? $params['moderators'] : $this->_getParam('moderators',1);
    $this->view->load_content = $params['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content',"button");
    $this->view->widgetName = 'forum-view';
    $this->view->viewer =  $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $params['limit_data'] = $limit_data = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data',$settings->getSetting('sesforum.forum.pagelength',10));
    $this->view->show_data = $params['show_data'] = isset($params['show_data']) ? $params['show_data'] : $this->_getParam('show_data',1);
    $show_criterias = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('ownerName', 'ownerPhoto', 'likeCount',"ratings","showDatetime","viewCount","replyCount","latestPostDetails","postTopicButton","title","tags"));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria} = $show_criteria;
    }
      switch($this->_getParam('sort', 'recent')) {
      case 'popular':
        $order = 'view_count';
        break;
      case 'recent':
      default:
        $order = 'modified_date';
        break;
    }
    $sesforum_widgets = Zend_Registry::isRegistered('sesforum_widgets') ? Zend_Registry::get('sesforum_widgets') : null;
    if(empty($sesforum_widgets))
      return $this->setNoRender();
    if(Engine_Api::_()->core()->hasSubject())
        $this->view->sesforum = $sesforum = Engine_Api::_()->core()->getSubject();
    if(!empty($sesforum)) {
        $params['forum_id'] = $sesforum->getIdentity();
    } elseif(isset($params['forum_id'])) {
        $this->view->sesforum=  $sesforum = Engine_Api::_()->getItem('sesforum_forum', $params['forum_id']);
        $params['forum_id'] = $sesforum->getIdentity();
    } else {
          return $this->setNoRender();
    }
    $table = Engine_Api::_()->getItemTable('sesforum_topic');
    $select = $table->select()
      ->where('forum_id = ?', $sesforum->getIdentity())
      ->order('sticky DESC')
      ->order($order . ' DESC');
      //->limit($limit_data);

    if ($this->_getParam('search', false)) {
      $select->where('title LIKE ? OR description LIKE ?', '%'.$this->_getParam('search').'%');
    }
    if($viewer->getIdentity())
        $levelId = $viewer->level_id;
    else
        $levelId = 5;
    $this->view->canPost = $canPost =  Engine_Api::_()->sesforum()->isAllowed('sesforum_forum', $levelId, 'topic_create')->value;

    $this->view->params = $params;
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($page);
    $this->view->page = $page;
    $paginator->setItemCountPerPage($limit_data);
    $this->view->sesforum_topic_pagelength = $settings->getSetting('sesforum.topic.pagelength',10);
    $list = $sesforum->getModeratorList();
    $moderators = $this->view->moderators = $list->getAllChildren();
  }
}
