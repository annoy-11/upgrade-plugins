<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Comments.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesautoaction_Model_DbTable_Comments extends Engine_Db_Table {

    protected $_rowClass = "Sesautoaction_Model_Comment";

    public function getComment($param = array()) {

        $tableName = $this->info('name');
        $select = $this->select()
                ->from($tableName)->order('comment_id DESC');
        if (isset($param['fetchAll'])) {
            $select->where('enabled =?', 1);
            return $this->fetchAll($select);
        }
        return Zend_Paginator::factory($select);
    }

    public function resourceComment() {

        $tableName = $this->info('name');
        $select = $this->select()
                ->from($tableName)
                ->where('enabled =?', 1)
                ->order('RAND()')->limit(1);
        return $this->fetchRow($select);
    }


}
