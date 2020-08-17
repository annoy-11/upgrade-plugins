<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Projects.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Projects extends Core_Model_Item_DbTable_Abstract
{
  protected $_rowClass = "Sesprofilefield_Model_Project";

  public function getAllProjects($subject_id) {

    $select = $this->select()
                  ->from($this->info('name'))
                  ->where('owner_id =?', $subject_id)
                  ->order('project_id DESC');
    return $this->fetchAll($select);

  }
}
