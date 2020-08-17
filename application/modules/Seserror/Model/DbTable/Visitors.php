<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Visitors.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Seserror_Model_DbTable_Visitors extends Engine_Db_Table {

  protected $_rowClass = 'Seserror_Model_Visitor';

  public function getAllUserEmails($params = array()) {

    $tableName = $this->info('name');
    $select = $this->select()->from($tableName, 'email');
    return $select->query()->fetchAll();
  }
  
  public function getAllContacts($params = array()) {

    $select = $this->select()->from($this->info('name'));
    return $paginator = Zend_Paginator::factory($select);
  }

}