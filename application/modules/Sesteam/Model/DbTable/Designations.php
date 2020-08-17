<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Designations.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Model_DbTable_Designations extends Engine_Db_Table {

  protected $_rowClass = "Sesteam_Model_Designation";

  public function getDesignations($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), array('designation_id', 'designation'))
            ->order('order ASC')
            ->query();
    $data = array();
    if (!isset($params['type'])) {
      $data[] = 'Choose a Designation';
    }
    foreach ($select->fetchAll() as $designation) {
      $data[$designation['designation_id']] = $designation['designation'];
    }
    return $data;
  }

  public function designationName($params = array()) {
    return $this->select()
                    ->from($this->info('name'), array('designation'))
                    ->where('designation_id =?', $params['designation_id'])
                    ->query()
                    ->fetchColumn();
  }

}
