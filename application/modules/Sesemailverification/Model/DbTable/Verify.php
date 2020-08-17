<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Verify.php  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemailverification_Model_DbTable_Verify extends Engine_Db_Table
{
  public function gc()
  {
    // Delete rows for users that are verified or the user does not exist
    $verifyTableName = $this->info('name');
    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');
    $select = new Zend_Db_Select($this->getAdapter());
    $select
      ->from($verifyTableName, null)
      ->joinLeft($userTableName, $userTableName . '.user_id=' . $verifyTableName . '.user_id', array('verified', 'user_id'))
      ->where($userTableName . '.verified = ?', 1);

    $gcIds = array();
    foreach( $select->query()->fetchAll() as $row ) {
      if( !empty($row['verified']) || empty($row['user_id']) ) {
        $gcIds[] = $row['user_id'];
      }
    }

    // Delete them
    if( !empty($gcIds) ) {
      $this->delete(array(
        'user_id IN(?)' => $gcIds,
      ));
    }

    return $this;
  }
}