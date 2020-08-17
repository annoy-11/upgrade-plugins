<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Botactions.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesautoaction_Model_DbTable_Botactions extends Engine_Db_Table {

  protected $_rowClass = "Sesautoaction_Model_Botaction";

  public function getBotaction($param = array()) {

    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName)->order('botaction_id DESC');
    if (isset($param['fetchAll'])) {
        $select->where('enabled =?', 1);
        return $this->fetchAll($select);
    }
    return Zend_Paginator::factory($select);
  }
}
