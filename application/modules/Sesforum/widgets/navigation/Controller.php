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



class Sesforum_Widget_NavigationController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $table = Engine_Api::_()->getItemTable('sesforum_category');
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer->getIdentity()) {
        $levelId = 5;
    } else {
        $levelId = $viewer->level_id;
    }
    $this->view->categories = $categories = $table->fetchAll($table->select()->where('subcat_id = ?', 0)->where('subsubcat_id = ?', 0)->where("privacy LIKE ? ", '%' . $levelId . '%')->order('order ASC'));
    if(count($categories) == 0)
        return $this->setNoRender();
    $coreApi = Engine_Api::_()->core();
    $this->view->subject = $coreApi->hasSubject('sesforum_forum') ? $coreApi->getSubject('sesforum_forum') : null;
    $this->view->subjectTopic = $coreApi->hasSubject('sesforum_topic') ? $coreApi->getSubject('sesforum_topic') : null;
    $this->view->subjectCategory = $coreApi->hasSubject('sesforum_category') ? $coreApi->getSubject('sesforum_category') : null;
    $sesforum_widgets = Zend_Registry::isRegistered('sesforum_widgets') ? Zend_Registry::get('sesforum_widgets') : null;
    if(empty($sesforum_widgets))
      return $this->setNoRender();
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesforum_index_dashboard')
      ->limit(1)
      ->query()
      ->fetchColumn();

    $widget = $db->select()
      ->from('engine4_core_content', 'params')
      ->where('page_id = ?', $page_id)
      ->where('name = ?','sesforum.user-dashboard')
      ->limit(1)
      ->query()
      ->fetchColumn();
    $data = json_decode($widget,'true');
    $showContent = $data['show_criteria'];
    $urlType = false;
    if($showContent[0] == "myTopics")
        $urlType = 'my-topics';
    elseif($showContent[0] == "myPosts")
        $urlType = 'my-posts';
    elseif($showContent[0] == "mySubscribedTopics")
        $urlType = 'my-subscriptions';
    elseif($showContent[0] == "TopicsILiked")
        $urlType = 'topics-i-liked';
    elseif($showContent[0] == "postsILiked")
        $urlType = 'posts-i-liked';
    elseif($showContent[0] == "signature")
        $urlType = 'signature';
    $this->view->urlType = $urlType;
  }
}
