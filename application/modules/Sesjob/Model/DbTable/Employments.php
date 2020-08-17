<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Employments.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Employments extends Engine_Db_Table
{
  protected $_rowClass = 'Sesjob_Model_Employment';

  public function getEmploymentsAssoc()
  {
    $stmt = $this->select()
        ->from($this, array('employment_id', 'employment_name'))
        ->order('employment_name ASC')
        ->query();

    $data = array();
    foreach( $stmt->fetchAll() as $employment ) {
      $data[$employment['employment_id']] = $employment['employment_name'];
    }

    return $data;
  }
}
