<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Studies.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Studies extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Sesprofilefield_Model_Study";
  protected $_name = "sesprofilefield_studys";
  
  public function getAllStudys($subject_id = null) {
    
    $select = $this->select()
              ->from($this->info('name'))->order('study_id DESC');
    
    if($subject_id)
      $select->where('owner_id =?', $subject_id);
      
    return $this->fetchAll($select);
  
  }
  
  public function getColumnValue($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'study_id')
            ->where('name = ?', $params['name'])
            ->query()
            ->fetchColumn();
  }
}