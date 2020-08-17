<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Likes.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Model_DbTable_Likes extends Engine_Db_Table {

    public function getLikeResults($params = array()) {

        $likesTableName = $this->info('name');

        $select = $this->select()
                            ->from($likesTableName, array('COUNT(like_id) AS like_count', '*'))
                            ->group('resource_type')
                            ->group('resource_id');

        if(!empty($params['widgetname']) && $params['widgetname'] == 'myfriendcontentlike') {
            $user = Engine_Api::_()->getItem('user', $params['viewer_id']);
            $friendIds = $user->membership()->getMembershipsOfIds();
            if(count($friendIds) > 0)
                $select->where('poster_id IN (?)', (array) $friendIds);
            else
                $select->where('poster_id IN (?)',array('0'));
        }

        if($params['viewer_id'] && @$params['widgetname'] != 'myfriendcontentlike') {
            $select->where('poster_id =?', $params['viewer_id']);
        }

        if(!empty($params['popularCol']) && ($params['popularCol'] == 'recent' || $params['popularCol'] == 'popular'))
            $select->order($params['popularCol'].' DESC');
        else if(!empty($params['popularCol']) && $params['popularCol'] == 'random')
            $select->order('RAND()');
        else
            $select->order('like_count DESC');

        if(!empty($params['resource_type']) && $params['resource_type'] != 'all')
            $select->where($likesTableName.'.resource_type =?', $params['resource_type']);
        else if(!empty($params['type']) && $params['type'] != 'all')
            $select->where($likesTableName.'.resource_type =?', $params['type']);

        $currentTime = date('Y-m-d H:i:s');
        if(isset($params['popularCol']) && !empty($params['popularCol'])) {
            if($params['popularCol'] == 'week') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
                $select->where("DATE(".$likesTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            } elseif($params['popularCol'] == 'month') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
                $select->where("DATE(".$likesTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            }
        }

        return $select;
    }

    public function wholikeme($viewer_id) {

        $select = $this->select()
                    ->from($this->info('name'), array('*'))
                    ->where('resource_id =?', $viewer_id)
                    ->where('resource_type =?', 'user')
                    ->where('poster_id <> ?', $viewer_id);
        return $select;
    }


    public function getMyContentLikeResults($params = array()) {

        $dbInsert = Zend_Db_Table_Abstract::getDefaultAdapter();

        if(!empty($params['resource_type']))
            $table = Engine_Api::_()->getItemTable($params['resource_type']);
        else
            $table = Engine_Api::_()->getItemTable($params['type']);
        $tableName = $table->info('name');
        $primary_id = current($table->info("primary"));

        $likesTableName = $this->info('name');

        $owner_id = $dbInsert->query("SHOW COLUMNS FROM ".$tableName." LIKE 'owner_id'")->fetch();

        $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->joinLeft($tableName, $tableName . $primary_id.'. = ' . $likesTableName . '.resource_id', null)
                    ->from($likesTableName, array('COUNT(like_id) AS like_count', '*'))
                    ->group($likesTableName.'.resource_type')
                    ->group($likesTableName.'.resource_id');

        if(!empty($owner_id)) {
            $select->where($tableName.'.owner_id =?', $params['viewer_id']);
        } else {
            $select->where($tableName.'.user_id =?', $params['viewer_id']);
        }

        if(!empty($params['resource_type']) && $params['resource_type'] != 'all')
            $select->where($likesTableName.'.resource_type =?', $params['resource_type']);
        else if(!empty($params['type']) && $params['type'] != 'all')
            $select->where($likesTableName.'.resource_type =?', $params['type']);

        return $select;
    }
}
