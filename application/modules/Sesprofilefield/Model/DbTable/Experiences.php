<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Experiences.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Experiences extends Core_Model_Item_DbTable_Abstract 
{
  protected $_rowClass = "Sesprofilefield_Model_Experience";
  
  public function getAllExperiences($subject_id) {
    
    $select = $this->select()
                  ->from($this->info('name'))
                  ->where('owner_id =?', $subject_id)
                  ->order('experience_id DESC');
    return $this->fetchAll($select);
  
  }
}