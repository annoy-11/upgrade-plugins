<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Votes.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinesspoll_Model_DbTable_Votes extends Engine_Db_Table
{
  public function getUserId($id){
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getItemTable('sesbusinesspoll_vote');
    $tableName = $table->info('name');

    $select = $table
      ->select()
      ->from($tableName)
    ;
    if(!empty($id) && is_numeric($id))
      $select->where('poll_option_id = ?',$id );
    return $select;
  }
  public function getVotesPaginator($id)
  {
    return Zend_Paginator::factory($this->getUserId($id));
  }
}
