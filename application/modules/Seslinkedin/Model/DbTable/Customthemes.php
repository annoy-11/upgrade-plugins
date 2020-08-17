<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Customthemes.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Model_DbTable_Customthemes extends Engine_Db_Table {

  protected $_rowClass = "Seslinkedin_Model_Customtheme";

  public function getCustomThemes($param = array()) {

    $tableName = $this->info('name');
    $select = $this->select()->from($tableName);
    if(empty($param['all'])) {
      $select->where('`default` = ?', '1');
    }
    return $this->fetchAll($select);
  }

}
