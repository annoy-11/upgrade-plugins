<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesautoaction_Plugin_Core extends Zend_Controller_Plugin_Abstract {

    public function onItemCreateAfter($event) {

        $payload = $event->getPayload();

        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.enbouautoaction', 1)) {
            $resource_type = $payload->getType();
            $resource_id = $payload->getIdentity();

            $getResults = Engine_Api::_()->getDbTable('integrateothersmodules', 'sesautoaction')->getResults(array('enabled' => 1));

            $intArray = array();
            foreach($getResults as $getResult) {
                $intArray[] = $getResult['content_type'];
            }


            if(in_array($resource_type, $intArray)) {

                $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
                if(isset($resource->owner_id)) {
                    $owner_id = $resource->owner_id;
                } else if(isset($resource->user_id)) {
                    $owner_id = $resource->user_id;
                }

                $botActions = Engine_Api::_()->getDbTable('botactions', 'sesautoaction')->getBotaction(array('fetchAll' => 1));
                foreach($botActions as $botAction) {
                    $usersIDs = explode(',', $botAction->users);
                    $memberLevelsIds = explode(',', $botAction->member_levels);

                    $getAllLevelUsers = Engine_Api::_()->sesautoaction()->getAllLevelUsers($memberLevelsIds);

                    if($botAction->actionperform == 1 && count($usersIDs) > 0 && $owner_id == $botAction->resource_id) {
                        foreach($usersIDs as $usersID) {
                            $user = Engine_Api::_()->getItem('user', $usersID);
                            Engine_Api::_()->sesautoaction()->actions($resource, $user, $botAction);
                        }
                    } else if($botAction->actionperform == 0 && count($memberLevelsIds) > 0 && in_array($owner_id, $getAllLevelUsers)) {
                        foreach($usersIDs as $usersID) {
                            $user = Engine_Api::_()->getItem('user', $usersID);
                            Engine_Api::_()->sesautoaction()->actions($resource, $user, $botAction);
                        }
                    }

                }
            }
        }
    }

    public function onUserCreateAfter($event) {

        $user = $event->getPayload();

        //Friends Settings
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.enautofriendship', 1)) {
            $friends = Engine_Api::_()->getDbTable('friends', 'sesautoaction')->getFriend(array('enabled' => 1));
            if(count($friends) > 0) {
                foreach($friends as $result) {
                    $member_levels = explode(',', $result->member_levels);
                    if(count($member_levels) > 0 && in_array($user->level_id, $member_levels)) {
                        Engine_Api::_()->sesautoaction()->autoFriend($result->users, $user);
                    }
                }
            }
        }

        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.ennewsignupaction', 1)) {

            $autoactiontable = Engine_Api::_()->getDbTable('actions', 'sesautoaction');
            $autoactiontableName = $autoactiontable->info('name');

            $select = $autoactiontable->select()
                        ->from($autoactiontableName)
                        ->where('newsignup =?', 1)
                        ->where('enabled =?', 1);
            $results = $autoactiontable->fetchAll($select);

            foreach($results as $result) {

                $member_levels = explode(',', $result->member_levels);

                if(count($member_levels) > 0 && in_array($user->level_id, $member_levels)) {
                    $resource_type = $result->resource_type;
                    $resource_id = $result->resource_id;

                    $resource_type = Engine_Api::_()->sesautoaction()->getResourceType($resource_type);
                    $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
                    Engine_Api::_()->sesautoaction()->actions($resource, $user, $result);
                }
            }
        }
    }
}
