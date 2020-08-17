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



class Sesforum_Widget_ListRecentTopicsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $this->view->stats = $stats = $this->_getParam('stats', null);

    $criteria = $this->_getParam('criteria', 'creation_date');

    // Get sesforums allowed to be viewed by current user
    $viewer = Engine_Api::_()->user()->getViewer();
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
    $topicsTable = Engine_Api::_()->getDbtable('topics', 'sesforum');
    $topicsSelect = $topicsTable->select()
      ->where('forum_id IN(?)', $sesforumIds)
      ->order($criteria.' DESC');


    $this->view->paginator = $paginator = Zend_Paginator::factory($topicsSelect);
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 5));

    // Do not render if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}
