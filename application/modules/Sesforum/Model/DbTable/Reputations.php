<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reputations.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_DbTable_Reputations extends Engine_Db_Table {

    protected $_rowClass = "Sesforum_Model_Reputation";

    public function isReputation($params = array()) {

        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $select = $this->select()
                    ->where('resource_id = ?', $params['resource_id'])
                    ->where('poster_id = ?', $viewer_id)
                    ->where('post_id = ?', $params['post_id'])
                    ->query()
                    ->fetchColumn();
        return $select;
    }

    public function getIncreaseReputation($params = array()) {

        $select = $this->select()
                        ->from($this->info('name'),'reputation_id')
                        ->where('reputation = ?', 1);
        if(isset($params['user_id']) && !empty($params['user_id'])) {
            $select->where('resource_id = ?', $params['user_id']);
        }
        if(isset($params['post_id']) && !empty($params['user_id'])) {
            $select->where('post_id = ?', $params['post_id']);
        }
        $results = $this->fetchAll($select);
        return count($results);

    }

    public function getDecreaseReputation($params = array()) {

        $select = $this->select()
                        ->from($this->info('name'),'reputation_id')
                        ->where('reputation = ?', 0);
        if(isset($params['user_id']) && !empty($params['user_id'])) {
            $select->where('resource_id = ?', $params['user_id']);
        }
        if(isset($params['post_id']) && !empty($params['user_id'])) {
            $select->where('post_id = ?', $params['post_id']);
        }
        $results = $this->fetchAll($select);
        return count($results);

    }

    public function getAllUserReputations($user_id) {
        $select = $this->select()
                        ->from($this->info('name'),'reputation_id')
                        ->where('resource_id = ?', $user_id);
        $results = $this->fetchAll($select);
        return count($results);
    }
}
