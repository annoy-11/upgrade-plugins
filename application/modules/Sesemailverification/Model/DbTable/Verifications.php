<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Verifications.php  2017-01-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemailverification_Model_DbTable_Verifications extends Engine_Db_Table
{
  protected $_rowClass = 'Sesemailverification_Model_Verification';

  public function rowExists($user_id) {

    $verification_id = $this->select()
            ->from($this->info('name'), 'verification_id')
            ->where('user_id = ?', $user_id)
            ->where('sesemailverified = ?', 1)
            ->query()
            ->fetchColumn();
    return $verification_id;
  }

  public function rowExist($user_id) {

    $verification_id = $this->select()
            ->from($this->info('name'), 'verification_id')
            ->where('user_id = ?', $user_id)
            ->query()
            ->fetchColumn();
    return $verification_id;
  }

  public function isRowExists($id) {

    $db = Engine_Db_Table::getDefaultAdapter();

    $verification_id = $this->select()
            ->from($this->info('name'), 'verification_id')
            ->where('user_id =?', $id)
            ->query()
            ->fetchColumn();
    if(empty($verification_id)) {
        $row = $this->createRow();
        $row->user_id = $id;
        $row->sesemailverified = 0;
        $row->save();
    } else {
        $db->update('engine4_sesemailverification_verifications', array('sesemailverified' => 1), array('user_id =?' => $id));
    }
  }
}
