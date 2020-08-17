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


class Sesforum_Widget_ProfileForumPostsController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;

  public function indexAction()
  {

    // Don't render this if not authorized


    if(isset($_POST['params']))
        $params = $_POST['params'];

     if(Engine_Api::_()->core()->hasSubject() ) {
        $subject = Engine_Api::_()->core()->getSubject();
        $params['user_id'] = $subject->getIdentity();
    } elseif($params['user_id']) {
        $subject = Engine_Api::_()->user()->getUser($params['user_id']);
        $params['user_id'] = $params['user_id'];
    } else {
        return $this->setNoRender();
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->title_truncation_limit = $params['title_truncation_limit'] = isset($params['title_truncation_limit']) ? $params['title_truncation_limit'] : $this->_getParam('title_truncation_limit',45);
    $this->view->load_content = $params['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content',1);
     $params['limit_data'] = $limit_data = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data',$settings->getSetting('sesforum.forum.pagelength',10));

    $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : $this->view->identity;

    $params['show_criteria'] = $show_criterias = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('topic', 'likeCount', 'creationDetails','thanksCount'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria} = $show_criteria;
    }

    $is_ajax = $this->_getParam('is_ajax', 0);
    if($is_ajax)
        $this->getElement()->removeDecorator('Container');
    if($is_ajax)
        $this->getElement()->removeDecorator('Title');
    // Get subject and check auth

    if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
      return $this->setNoRender();
    }

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
    if( empty($sesforumIds) ) {
      return $this->setNoRender();
    }

    // Get paginator
    $postsTable = Engine_Api::_()->getDbtable('posts', 'sesforum');
    $postsSelect = $postsTable->select()
      ->where('forum_id IN(?)', $sesforumIds)
      ->where('user_id = ?', $viewer->getIdentity())
      ->order('creation_date DESC')
      ;

    $this->view->paginator = $paginator = Zend_Paginator::factory($postsSelect);
    $this->view->widgetName = "profile-forum-posts";
    $page = $params['page'] ? $params['page'] : $this->_getParam('page', 1);
    $this->view->params = $params;
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;

    // Set item count per page and current page number

    $paginator->setCurrentPageNumber($page);
    $this->view->page = $page;
    $paginator->setItemCountPerPage($limit_data);
    $this->view->loadJs = true;
    // Do not render if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }

    // Add count to title if configured
    if( $this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0 ) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount()
  {
    return $this->_childCount;
  }
}
