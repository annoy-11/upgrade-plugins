<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Subscribes.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_DbTable_Subscribes extends Engine_Db_Table {

    protected $_rowClass = "Sesforum_Model_Subscribe";

    public function isSubscribe($params = array()) {

        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $select = $this->select()
                    ->from($this->info('name'), 'subscribe_id')
                    ->where('resource_id = ?', $params['resource_id'])
                    ->where('poster_id = ?', $viewer_id)
                    ->query()
                    ->fetchColumn();
        return $select;
    }

    public function getAllUserSubscribes($user_id) {
        $select = $this->select()
                        ->from($this->info('name'),'subscribe_id')
                        ->where('resource_id = ?', $user_id);
        $results = $this->fetchAll($select);
        return count($results);
    }
}
