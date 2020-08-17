<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgrouppoll_Plugin_Core
{
  public function onStatistics($event)
  {
    $table   = Engine_Api::_()->getDbTable('polls', 'sesgrouppoll');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'poll');
    $table   = Engine_Api::_()->getDbTable('votes', 'sesgrouppoll');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'poll vote');
  }

  public function onUserDeleteBefore($event)
  {
    $payload = $event->getPayload();
		if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgrouppoll')){
			if( $payload instanceof User_Model_User ) {
				// Delete polls
				$pollTable = Engine_Api::_()->getDbtable('polls', 'sesgrouppoll');
				$pollSelect = $pollTable->select()->where('user_id = ?', $payload->getIdentity());
				foreach( $pollTable->fetchAll($pollSelect) as $poll ) {
					$poll->delete();
				}
			}
		}
  }
public function onActivitySubmittedAfter( $event){
    $payload = $event->getPayload();
	if(!empty($_POST['optionsArray']) && $payload->object_type == "sesgroup_group"){
		$payload->type = "sesgroup_group_createpoll";
		$payload->save();
	}
  }
	 
}