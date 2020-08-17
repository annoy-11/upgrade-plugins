<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Designations.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroupteam_Model_DbTable_Designations extends Engine_Db_Table {

  protected $_rowClass = "Sesgroupteam_Model_Designation";

  public function getDesignations($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), array('designation_id', 'designation'))
            ->where('group_id =?', 0);

    $select = $select->order('order ASC')->query();

    $data = array();
    if (!isset($params['type'])) {
      $data[] = 'Choose a Designation';
    }
    foreach ($select->fetchAll() as $designation) {
      $data[$designation['designation_id']] = $designation['designation'];
    }
    return $data;
  }

  public function getAllDesignations($params = array()) {

    $select = $this->select()
                  ->from($this->info('name'))
                  ->order('order ASC');
    if(isset($params['group_id']) && !empty($params['group_id'])) {
      $select->where('group_id =?', $params['group_id']);
    }
    return $this->fetchAll($select);
  }

  public function designationName($params = array()) {
    return $this->select()
                    ->from($this->info('name'), array('designation'))
                    ->where('designation_id =?', $params['designation_id'])
                    ->query()
                    ->fetchColumn();
  }

}
