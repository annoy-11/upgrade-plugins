<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Educations.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Educations extends Engine_Db_Table
{
  protected $_rowClass = 'Sesjob_Model_Education';

  public function getEducationsAssoc()
  {
    $stmt = $this->select()
        ->from($this, array('education_id', 'education_name'))
        ->order('education_name ASC')
        ->query();

    $data = array();
    foreach( $stmt->fetchAll() as $education ) {
      $data[$education['education_id']] = $education['education_name'];
    }

    return $data;
  }
}
