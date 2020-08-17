<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagepoll_Plugin_Core
{
  public function onStatistics($event)
  {
    $table   = Engine_Api::_()->getDbTable('polls', 'sespagepoll');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'poll');
    $table   = Engine_Api::_()->getDbTable('votes', 'sespagepoll');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'poll vote');
  }

  public function onUserDeleteBefore($event)
  {
    $payload = $event->getPayload();
		if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagepoll')){
			if( $payload instanceof User_Model_User ) {
				// Delete polls
				$pollTable = Engine_Api::_()->getDbtable('polls', 'sespagepoll');
				$pollSelect = $pollTable->select()->where('user_id = ?', $payload->getIdentity());
				foreach( $pollTable->fetchAll($pollSelect) as $poll ) {
					$poll->delete();
				}
			}
		}
  }
  public function onActivitySubmittedAfter( $event){
    $payload = $event->getPayload();
	if(!empty($_POST['optionsArray']) && $payload->object_type == "sespage_page"){
		$payload->type = "sespage_page_createpoll";
		$payload->save();
	}
  }
	 
}