<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pricingtables.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Pricingtables extends Engine_Db_Table {

  protected $_rowClass = 'Sespagebuilder_Model_Pricingtable';

  public function getPricingTable($id) {
 
    return $this->fetchAll($this->select()->where('table_id = ?', $id)->order('order ASC'));
  }

}

