<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvpoll_Plugin_Core {

    public function onStatistics($event)
    {
        $table   = Engine_Api::_()->getDbTable('polls', 'sesadvpoll');
        $select = new Zend_Db_Select($table->getAdapter());
        $select->from($table->info('name'), 'COUNT(*) AS count');

        $event->addResponse($select->query()->fetchColumn(0), 'poll');

        $table   = Engine_Api::_()->getDbTable('votes', 'sesadvpoll');
        $select = new Zend_Db_Select($table->getAdapter());
        $select->from($table->info('name'), 'COUNT(*) AS count');

        $event->addResponse($select->query()->fetchColumn(0), 'poll vote');
    }

    public function onUserDeleteBefore($event)
    {
        $payload = $event->getPayload();
        if( $payload instanceof User_Model_User ) {
            // Delete polls
            $pollTable = Engine_Api::_()->getDbtable('polls', 'sesadvpoll');
            $pollSelect = $pollTable->select()->where('user_id = ?', $payload->getIdentity());
            foreach( $pollTable->fetchAll($pollSelect) as $poll ) {
                $poll->delete();
            }
        }
    }
}
