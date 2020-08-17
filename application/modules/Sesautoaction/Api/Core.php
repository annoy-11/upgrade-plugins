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

class Sesautoaction_Api_Core extends Core_Api_Abstract {

    public function getPluginItem($moduleName) {
            //initialize module item array
        $moduleType = array();
        $filePath =  APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName) . "/settings/manifest.php";
            //check file exists or not
        if (is_file($filePath)) {
                //now include the file
        $manafestFile = include $filePath;
                $resultsArray =  Engine_Api::_()->getDbtable('integrateothermodules', 'sesbasic')->getResults(array('module_name'=>$moduleName));
        if (is_array($manafestFile) && isset($manafestFile['items'])) {
            foreach ($manafestFile['items'] as $item)
            if (!in_array($item, $resultsArray))
                $moduleType[$item] = $item.' ';
        }
        }
        return $moduleType;
    }

    public function getResourceType($resource_type) {

        switch($resource_type) {
            case 'music_playlist_song':
            $resource_type = 'music_playlist';
            break;
        }
        return $resource_type;

    }

    public function actions($resource, $user, $result) {

        //Like Work
        if(!empty($result->likeaction)) {
            $this->likeAction($resource, $user);
        }

        //Comment Work
        if(!empty($result->commentaction)) {
            $this->commentAction($resource, $user);
        }

        //Friend Work
//         if(!empty($result->friend) && $result->resource_type == 'user') {
//             $this->friendAction($resource, $user);
//         }

        if(!empty($result->join)) {
            $this->joinAction($resource, $user);
        }

        $dbChek = Zend_Db_Table_Abstract::getDefaultAdapter();

        $table = Engine_Api::_()->getItemTable($resource->getType());
        $tableName = $table->info('name');

        $follow_count_exist = $dbChek->query("SHOW COLUMNS FROM ".$tableName." LIKE 'follow_count'")->fetch();
        if(!empty($result->follow) && !empty($follow_count_exist)) {
            $this->followAction($resource, $user);
        }

        $favourite_count_exist = $dbChek->query("SHOW COLUMNS FROM ".$tableName." LIKE 'favourite_count'")->fetch();
        if(!empty($result->favourite) && !empty($favourite_count_exist)) {
            $this->favouriteAction($resource, $user);
        }
    }

    public function favouriteAction($resource, $user) {

        $table = Engine_Api::_()->getItemTable($resource->getType());
        $tableName = $table->info('name');

        $primary_id = current($table->info("primary"));
        $modulename = strtolower($resource->getModuleName());

        //update
        $db = Engine_Api::_()->getDbTable('favourites', $modulename)->getAdapter();
        $db->beginTransaction();
        try {
            $fav = Engine_Api::_()->getDbTable('favourites', $modulename)->createRow();
            $fav->owner_id = $user->getIdentity();
            $fav->resource_type = $resource->getType();
            $fav->resource_id = $resource->getIdentity();
            $fav->save();
            $resource->favourite_count++;
            $resource->save();
            // Commit
            $db->commit();
        } catch (Exception $e) {
        }
    }


    public function followAction($resource, $user) {

        $table = Engine_Api::_()->getItemTable($resource->getType());
        $tableName = $table->info('name');

        $primary_id = current($table->info("primary"));
        $modulename = strtolower($resource->getModuleName());

        $db = Engine_Api::_()->getDbTable('followers', $modulename)->getAdapter();
        $db->beginTransaction();
        try {
            $follow = Engine_Api::_()->getDbTable('followers', $modulename)->createRow();
            $follow->owner_id = $user->getIdentity();
            $follow->resource_type = $resource->getType();
            $follow->resource_id = $resource->getIdentity();
            $follow->save();
            $resource->follow_count++;
            $resource->save();
            // Commit
            $db->commit();
        } catch (Exception $e) {

        }
    }

    public function commentAction($resource, $user) {
        $viewer = $user;
        $subject = $resource;
        $resourceComment = Engine_Api::_()->getDbTable('comments', 'sesautoaction')->resourceComment();
        $comments = $resourceComment['comments'];
        $db = $resource->comments()->getCommentTable()->getAdapter();
        $db->beginTransaction();
        try {
            $commentRow = $resource->comments()->addComment($user, $comments);

            $notifyApi = Engine_Api::_()->getDbtable('notifications', 'activity');
            $subjectOwner = $subject->getOwner('user');

            // Notifications

            // Add notification for owner (if user and not viewer)
            $this->view->subject = $subject->getGuid();
            $this->view->owner = $subjectOwner->getGuid();
            if( $subjectOwner->getType() == 'user' && $subjectOwner->getIdentity() != $viewer->getIdentity() )
            {
                $notifyApi->addNotification($subjectOwner, $viewer, $subject, 'commented', array(
                    'label' => $subject->getShortType()
                ));
            }

            // Add a notification for all users that commented or like except the viewer and poster
            // @todo we should probably limit this
            $commentedUserNotifications = array();
            foreach( $subject->comments()->getAllCommentsUsers() as $notifyUser )
            {
                if( $notifyUser->getIdentity() == $viewer->getIdentity() || $notifyUser->getIdentity() == $subjectOwner->getIdentity() ) continue;

                // Don't send a notification if the user both commented and liked this
                $commentedUserNotifications[] = $notifyUser->getIdentity();

                $notifyApi->addNotification($notifyUser, $viewer, $subject, 'commented_commented', array(
                    'label' => $subject->getShortType()
                ));
            }

            // Add a notification for all users that liked
            // @todo we should probably limit this
            foreach( $subject->likes()->getAllLikesUsers() as $notifyUser )
            {
                // Skip viewer and owner
                if( $notifyUser->getIdentity() == $viewer->getIdentity() || $notifyUser->getIdentity() == $subjectOwner->getIdentity() ) continue;

                // Don't send a notification if the user both commented and liked this
                if( in_array($notifyUser->getIdentity(), $commentedUserNotifications) ) continue;

                $notifyApi->addNotification($notifyUser, $viewer, $subject, 'liked_commented', array(
                'label' => $subject->getShortType()
                ));
            }

            // Increment comment count
            Engine_Api::_()->getDbtable('statistics', 'core')->increment('core.comments');

            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
        }
    }

    public function likeAction($resource, $user) {
        try {
            if ($resource->likes()->isLike($user)) {
                return;
            }
            Engine_Api::_()->getItemTable('core_like')->addLike($resource, $user);

        } catch (Exception $e) {

        }
    }

    public function joinAction($resource, $user) {
        try {
            if( $resource->membership()->isMember($user) ) {
                return;
            }
            $resource->membership()->addMember($user)->setUserApproved($user)->setResourceApproved($user);
            $row = $resource->membership()->getRow($user);
            if($row) {
                $row->rsvp = '2';
                $row->save();
            }

            //Count increase
            $resource->member_count = $resource->membership()->getMemberCount();
            $resource->save();
        } catch (Exception $e) {


        }
    }

    public function friendAction($resource, $user) {
        // Process
        $db = Engine_Api::_()->getDbtable('membership', 'user')->getAdapter();
        $db->beginTransaction();
        $viewer = $user;
        try {

            // send request
            $resource->membership()
                ->addMember($viewer)
                ->setUserApproved($viewer);

            if( !$viewer->membership()->isUserApprovalRequired() && !$viewer->membership()->isReciprocal() ) {
                // if one way friendship and verification not required

                // Add activity
                Engine_Api::_()->getDbtable('actions', 'activity')
                    ->addActivity($viewer, $resource, 'friends_follow', '{item:$subject} is now following {item:$object}.');

                // Add notification
                Engine_Api::_()->getDbtable('notifications', 'activity')
                    ->addNotification($resource, $viewer, $viewer, 'friend_follow');

            } else if( !$viewer->membership()->isUserApprovalRequired() && $viewer->membership()->isReciprocal() ) {
                // if two way friendship and verification not required

                // Add activity
                Engine_Api::_()->getDbtable('actions', 'activity')
                    ->addActivity($resource, $viewer, 'friends', '{item:$object} is now friends with {item:$subject}.');
                Engine_Api::_()->getDbtable('actions', 'activity')
                    ->addActivity($viewer, $resource, 'friends', '{item:$object} is now friends with {item:$subject}.');

                // Add notification
                Engine_Api::_()->getDbtable('notifications', 'activity')
                    ->addNotification($resource, $viewer, $resource, 'friend_accepted');

            } else if( !$resource->membership()->isReciprocal() ) {
                // if one way friendship and verification required

                // Add notification
                Engine_Api::_()->getDbtable('notifications', 'activity')
                    ->addNotification($resource, $viewer, $resource, 'friend_follow_request');

            } else if( $resource->membership()->isReciprocal() ) {
                // if two way friendship and verification required

                // Add notification
                Engine_Api::_()->getDbtable('notifications', 'activity')
                    ->addNotification($resource, $viewer, $resource, 'friend_request');
            }

            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
        }
    }

    public function getAllLevelUsers($levelIds) {

        $table = Engine_Api::_()->getItemTable('user');
        $tableName = $table->info('name');

        $select = $table->select()
                        ->from($tableName, 'user_id')
                        ->where('level_id IN (?)', $levelIds);
        $results = $table->fetchAll($select);
        $data = array();
        foreach($results as $result) {
            $data[] = $result->user_id;
        }
        return $data;
    }

    public function autoFriend($resource, $user) {

        $friendIds = explode(',', $resource);

        $viewer = $user; //Engine_Api::_()->getItem('user', $payload->user_id);
        // Process
        $table = Engine_Api::_()->getDbtable('membership', 'user');

        // For backwards compatiblitiy this block will only execute if the
        // getDefaultNotifications function exists. If notifications aren't
        // being added to the engine4_activity_notificationsettings table
        // check to see if the Activity_Model_DbTable_NotificationTypes class
        // is out of date

        //$db = $table->getAdapter();
        //$db->beginTransaction();
        //$dbInsert = Engine_Db_Table::getDefaultAdapter();
        try
        {
            foreach($friendIds as $friendId) {

                $user = Engine_Api::_()->getItem('user', $friendId);

                //$db->query('INSERT IGNORE INTO `engine4_user_membership` (`resource_id`, `user_id`, `active`, `resource_approved`, `user_approved`) VALUES ("'.$user->getIdentity().'", "'.$viewer->getIdentity().'", "1", "1", "1");');
                //$db->query('INSERT IGNORE INTO `engine4_user_membership` (`resource_id`, `user_id`, `active`, `resource_approved`, `user_approved`) VALUES ("'.$viewer->getIdentity().'", "'.$user->getIdentity().'", "1", "1", "1");');

                // send request
                $user->membership()
                  ->addMember($viewer)
                  ->setUserApproved($viewer);

                $user->member_count++;
                $user->save();
                $viewer->member_count++;
                $viewer->save();
            }

            // Increment friends counter
            Engine_Api::_()->getDbtable('statistics', 'core')->increment('user.friendships');
            //$db->commit();
        } catch( Exception $e ) {
//             $db->rollBack();
//             $this->view->status = false;
//             $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error has occurred.');
//             $this->view->exception = $e->__toString();
//             return;
        }
    }

}
