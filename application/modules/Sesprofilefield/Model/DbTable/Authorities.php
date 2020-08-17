<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Authorities.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Authorities extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Sesprofilefield_Model_Authority";
  protected $_name = 'sesprofilefield_authorities';
  
  public function getAllAuthoritys($subject_id = null) {
    
    $select = $this->select()
              ->from($this->info('name'))->order('authority_id DESC');
    
    if($subject_id)
      $select->where('owner_id =?', $subject_id);
      
    return $this->fetchAll($select);
  
  }
  
  public function getColumnValue($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'authority_id')
            ->where('name = ?', $params['name'])
            ->query()
            ->fetchColumn();
  }
}