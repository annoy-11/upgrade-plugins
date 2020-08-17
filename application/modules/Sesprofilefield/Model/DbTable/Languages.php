<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Languages.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Languages extends Engine_Db_Table {

  protected $_rowClass = 'Sesprofilefield_Model_Language';

  public function getLanguages($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);
    if(isset($params['user_id'])) {
	    $select->where('user_id = ?', $params['user_id']);
    }
    return $this->fetchAll($select);
  }

  public function getColumnName($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);
    if (isset($params['languagename'])) {
      $select = $select->where('languagename = ?', $params['languagename']);
    }
    return $select = $select->query()->fetchColumn();
  }
}
