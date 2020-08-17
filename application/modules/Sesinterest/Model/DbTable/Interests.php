<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Interests.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Model_DbTable_Interests extends Engine_Db_Table {

    protected $_rowClass = 'Sesinterest_Model_Interest';

    public function getResults($params = array()) {

        $select = $this->select()
                ->from($this->info('name'), $params['column_name']);

        if($params['approved'] == '1')
            $select->where('approved =?', 1);

        if($params['approved'] == '0')
            $select->where('approved =?', 0);

        if(!empty($params['interest_name']))
            $select->where('interest_name LIKE ?', '%' . $params['interest_name'] . '%');

        if(empty($params['fetchAll']))
            return $this->fetchAll($select);
        else
            return $select;
    }

    public function isExist($params = array()) {

        $select = $this->select()
                ->from($this->info('name'), 'interest_id');

        if (isset($params['interest_name']))
            $select = $select->where('interest_name = ?', $params['interest_name']);

        if (isset($params['user_id']))
            $select = $select->where('user_id = ?', $params['user_id']);

        return $select->query()->fetchColumn();
    }

    public function getColumnName($params = array()) {

        $select = $this->select()
                ->from($this->info('name'), $params['column_name']);

        if (isset($params['interest_name']))
            $select = $select->where('interest_name = ?', $params['interest_name']);

        if (isset($params['interest_id']))
            $select = $select->where('interest_id = ?', $params['interest_id']);


        return $select = $select->query()->fetchColumn();
    }
}
