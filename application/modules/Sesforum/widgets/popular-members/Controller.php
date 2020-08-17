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



class Sesforum_Widget_PopularMembersController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $limit = $this->_getParam('itemCountPerPage', 3);

        $userTable = Engine_Api::_()->getDbTable('users', 'user');
        $userTableName = $userTable->info('name');
        $this->view->criteria = $criteria = $this->_getParam('criteria', 'topicCount');
        if($criteria == 'topicCount') {
            $tableName = 'topics';
        } elseif($criteria == 'postCount') {
            $tableName = 'posts';
        } elseif($criteria == 'thanksCount') {
            $tableName = 'thanks';
        } elseif($criteria == 'reputationCount') {
            $tableName = 'reputations';
        }
        $table = Engine_Api::_()->getDbTable($tableName, 'sesforum');
        $tableName = $table->info('name');
        $select = $userTable->select()
                ->setIntegrityCheck(false)
                ->from($userTableName, array(''));
        if(in_array($criteria, array('topicCount', 'postCount'))) {
            $select->join($tableName, $tableName . '.user_id = ' . $userTableName . '.user_id', array("count(" . $tableName . ".user_id) as totalResult", "user_id"));
            $select->group($tableName . '.user_id');
        } elseif(in_array($criteria, array('thanksCount', 'reputationCount'))) {
            $select->join($tableName, $tableName . '.resource_id = ' . $userTableName . '.user_id', array("count(" . $tableName . ".resource_id) as totalResult", "resource_id"));
            $select->group($tableName . '.resource_id');
        }
        $select->order('totalResult DESC');
        $select->limit($limit);

        $this->view->members = $members = $userTable->fetchAll($select);
        if (count($members) == 0)
            return $this->setNoRender();
    }
}
