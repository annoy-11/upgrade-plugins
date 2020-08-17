<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Industries.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Industries extends Engine_Db_Table
{
  protected $_rowClass = 'Sesjob_Model_Industry';

  public function getIndustriesAssoc()
  {
    $stmt = $this->select()
        ->from($this, array('industry_id', 'industry_name'))
        ->order('industry_name ASC')
        ->query();

    $data = array();
    foreach( $stmt->fetchAll() as $industry ) {
      $data[$industry['industry_id']] = $industry['industry_name'];
    }

    return $data;
  }
}
