<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Manageskills.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Manageskills extends Engine_Db_Table {

  protected $_rowClass = 'Sesprofilefield_Model_Manageskill';

  public function getSkill($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);
            
    if (isset($params['param']) && $params['param'] != 'admin')
      $select = $select->where('enabled = ?', 1);
    
    return $this->fetchAll($select);
  }

  public function getColumnName($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);
            
    if (isset($params['skillname']))
      $select = $select->where('skillname = ?', $params['skillname']);
    
    if (isset($params['manageskill_id']))
      $select = $select->where('manageskill_id = ?', $params['manageskill_id']);

    return $select = $select->query()->fetchColumn();
  }
}