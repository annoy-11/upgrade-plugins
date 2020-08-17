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



class Sesforum_Widget_StatisticsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
        $this->view->viewtype = $this->_getParam('viewtype', 'vertical');

        $this->view->stats = $stats = $this->_getParam('stats', null);


        $this->view->sesforum = $sesforum = Engine_Api::_()->core()->hasSubject() ? Engine_Api::_()->core()->getSubject() : null;

        $this->view->forum_id = 0;

        if(empty($stats))
            return $this->setNoRender();

        $forumTable = Engine_Api::_()->getDbTable('forums', 'sesforum');
        $forumTableName = $forumTable->info('name');

        $select = $forumTable->select()
                            ->from($forumTableName, array("COUNT(*) as forumCount", "SUM(post_count) as postCount", "SUM(topic_count) as topicCount"));
        if(isset($sesforum) && $sesforum->getType() == 'sesforum_forum') {
            $this->view->forum_id = $sesforum->forum_id;
            $select->where('forum_id = ?', $sesforum->forum_id);
        }

        $this->view->results = $results = $forumTable->fetchRow($select);
        $sesforum_widgets = Zend_Registry::isRegistered('sesforum_widgets') ? Zend_Registry::get('sesforum_widgets') : null;
        if(empty($sesforum_widgets))
          return $this->setNoRender();
        $userTable = Engine_Api::_()->getDbTable('users', 'user');
        $userTableName = $userTable->info('name');
        $this->view->totalusers = $userTable->select()
                    ->from($userTableName, array("COUNT(*) as userCount"))
                    ->where('verified = ?', 1)
                    ->where('enabled = ?', 1)
                    ->where('approved = ?', 1)
                    ->query()
                    ->fetchColumn();
        //$this->view->totalusers = $forumTable->fetchRow($selectUsers);

        if(isset($sesforum) && $sesforum->getType() == 'sesforum_forum') {
            $postsTable = Engine_Api::_()->getDbTable('posts', 'sesforum');
            $postsTableName = $postsTable->info('name');
            $this->view->activeUsers = $postsTable->select()
                        ->from($postsTableName, array('user_id'))->group('user_id')
                        ->where('forum_id =?', $sesforum->forum_id)
                        ->query()
                        ->fetchColumn();
        } else {
            $postsTable = Engine_Api::_()->getDbTable('posts', 'sesforum');
            $postsTableName = $postsTable->info('name');
            $this->view->activeUsers = $postsTable->select()
                        ->from($postsTableName, array('user_id'))->group('user_id')
                        ->query()
                        ->fetchColumn();
        }
        //$this->view->activeUsers = $postsTable->fetchRow($selectPosts);
  }
}
