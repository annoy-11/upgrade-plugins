<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Likeclassrooms.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Likeclassrooms extends Engine_Db_Table {
    protected $_searchTriggers = false;
    public function getLikes($resourceId) {
        $select = $this->select()
                ->from($this->info('name'), 'owner_id')
                ->where('resource_id = ?', $resourceId);
        return $this->fetchAll($select);
    }
}
