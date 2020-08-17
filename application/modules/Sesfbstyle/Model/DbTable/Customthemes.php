<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Customthemes.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbstyle_Model_DbTable_Customthemes extends Engine_Db_Table {

  protected $_rowClass = "Sesfbstyle_Model_Customtheme";

  public function getCustomThemes($param = array()) {
  
    $tableName = $this->info('name');
    $select = $this->select()->from($tableName);
    if(empty($param['all'])) {
      $select->where('`default` = ?', '1');
    }
    return $this->fetchAll($select);
  }

}
