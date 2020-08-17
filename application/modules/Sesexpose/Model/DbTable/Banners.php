<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Banners.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesexpose_Model_DbTable_Banners extends Engine_Db_Table {

  protected $_rowClass = "Sesexpose_Model_Banner";

  public function getBanner($param = array()) {
    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName);
    if (isset($param['fetchAll'])) {
      $select->where('enabled =?', 1);
      return $this->fetchAll($select);
      }
    return Zend_Paginator::factory($select);
  }

}
