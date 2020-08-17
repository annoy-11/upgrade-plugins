<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Specialities.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Specialties extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Sesprofilefield_Model_Specialty";
  protected $_name = 'sesprofilefield_specialties';
  
  public function getAllSpecialties($subject_id = null) {
    
    $select = $this->select()
              ->from($this->info('name'))->order('specialty_id DESC');
    
    if($subject_id)
      $select->where('user_id =?', $subject_id);
    return $this->fetchAll($select);
  }
  
  public function getSpeciality($params = array()) {

    $select = $this->select()
            ->from($this->info('name'))
            ->where('user_id = ?', $params['user_id']);
    return $this->fetchRow($select);
    
  }

  public function getViewerSpeciality($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'specialty_id')
            ->where('user_id = ?', $params['user_id'])
            ->query()
            ->fetchColumn();
  }
  
  public function getColumnValue($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'specialty_id')
            ->where('name = ?', $params['name'])
            ->query()
            ->fetchColumn();
  }
}