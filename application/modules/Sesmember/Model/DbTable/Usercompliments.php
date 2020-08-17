<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Usercompliments.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Model_DbTable_Usercompliments extends Engine_Db_Table {

  protected $_rowClass = "Sesmember_Model_Usercompliment";
  protected $_name = "sesmember_usercompliments";

  public function getComplementsUser($params) {
    $tablename = $this->info('name');
    $table = Engine_Api::_()->getDbTable('compliments', 'sesmember');
    $Name = $table->info('name');
    $select = $this->select()->from($tablename)->setIntegrityCheck(false);
    $select->joinLeft($Name, $Name . '.compliment_id = ' . $tablename . '.type', array('comtitle' => 'title', 'comfile_id' => 'file_id'));
    $select->where($Name . '.compliment_id IS NOT NULL');
    if (isset($params['user_id']))
      $select->where($tablename . '.user_id =?', $params['user_id']);
    if (isset($params['id']))
      $select->where($tablename . '.usercompliment_id =?', $params['id']);
    $select->order('usercompliment_id DESC');
    return Zend_Paginator::factory($select);
  }

  public function getCountUserCompliments($params = array()) {
    $tablename = $this->info('name');
    $table = Engine_Api::_()->getDbTable('compliments', 'sesmember');
    $Name = $table->info('name');
    $select = $this->select()->from($tablename, array(new Zend_Db_Expr('COUNT(usercompliment_id) as totalcount')))->setIntegrityCheck(false);

    $select->joinLeft($Name, $Name . '.compliment_id = ' . $tablename . '.type', array('comtitle' => 'title', 'comfile_id' => 'file_id'));
    $select->where($Name . '.compliment_id IS NOT NULL');
    if (isset($params['user_id']))
      $select->where($tablename . '.user_id =?', $params['user_id']);
    $select->group($tablename . '.type');
    return $this->fetchAll($select);
  }

}
