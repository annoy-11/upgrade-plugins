<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userinterests.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Model_DbTable_Userinterests extends Engine_Db_Table {

    protected $_rowClass = 'Sesinterest_Model_Userinterest';

    public function getUserInterests($params = array()) {

        $select = $this->select()
                ->from($this->info('name'), array('*'));
        if(isset($params['user_id']))
            $select->where('user_id =?', $params['user_id']);
        return $this->fetchAll($select);
    }

    public function isInterestCount($params = array()) {

        $select = $this->select()
                ->from($this->info('name'), new Zend_Db_Expr('COUNT(userinterest_id) as countinterest'));

        if (isset($params['userinterest_id']))
            $select = $select->where('userinterest_id = ?', $params['userinterest_id']);

        return $select->query()->fetchColumn();
    }
}
