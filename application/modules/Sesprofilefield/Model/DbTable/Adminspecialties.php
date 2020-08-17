<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Adminspecialties.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Adminspecialties extends Engine_Db_Table {

  protected $_rowClass = 'Sesprofilefield_Model_Adminspecialty';

  public function getSpecialty($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name'])
            ->where('subid = ?', 0)
            ->where('subsubid = ?', 0);

    if (isset($params['adminspecialty_id']) && !empty($params['adminspecialty_id']))
      $select = $select->where('subid = ?', $params['adminspecialty_id']);

    if (isset($params['param']) && !empty($params['param']))
      $select = $select->where('param =?', $params['param']);

    return $this->fetchAll($select);
  }

  public function getSpecialtyAssoc($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), array('adminspecialty_id', 'name'))
            ->where('subid = ?', 0)
            ->where('subsubid = ?', 0);
            
    if (isset($params['type']) && $params['type']) {
      $select = $select->where('param = ?', $params['type']);
    }

    $select = $select->order('adminspecialty_id ASC')
            ->query()
            ->fetchAll();

    $data = array();
    foreach ($select as $specialty) {
      $data[$specialty['adminspecialty_id']] = $specialty['name'];
    }

    return $data;
  }

  public function getColumnName($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);

    if (isset($params['adminspecialty_id']))
      $select = $select->where('adminspecialty_id = ?', $params['adminspecialty_id']);

    return $select = $select->query()->fetchColumn();
  }

  public function getModuleSubspecialty($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);

    if (isset($params['adminspecialty_id']))
      $select = $select->where('subid = ?', $params['adminspecialty_id']);

    if (isset($params['param']))
      $select = $select->where('param = ?', $params['param']);

    return $this->fetchAll($select);
  }

  public function getModuleSubsubspecialty($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);

    if (isset($params['adminspecialty_id']))
      $select = $select->where('subsubid = ?', $params['adminspecialty_id']);

    if (isset($params['param']))
      $select = $select->where('param = ?', $params['param']);

    return $this->fetchAll($select);
  }
}