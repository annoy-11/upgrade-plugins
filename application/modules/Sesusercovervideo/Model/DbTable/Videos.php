<?php

class Sesusercovervideo_Model_DbTable_Videos extends Engine_Db_Table {

    protected $_rowClass = "Sesusercovervideo_Model_Video";

    public function isUserVideo($params = array()) {

        $select = $this->select()
                ->from($this->info('name'), 'file_id')
                ->where('cover_video =?', 1)
                ->where('user_id = ?', $params['user_id']);
        return $select->query()->fetchColumn();
    }
}
