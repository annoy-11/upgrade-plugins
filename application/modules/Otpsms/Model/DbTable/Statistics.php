<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Statistics.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Model_DbTable_Statistics extends Engine_Db_Table {
  public function getStatistics($language = null) {
    $select = $this->select()
                   ->from($this->info('name'));
    $select->where('language =?',$language)->limit(1);
    return $this->fetchRow($select);
  }
}