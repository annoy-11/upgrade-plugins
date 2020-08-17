<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecometchatapi_Plugin_Core extends Zend_Controller_Plugin_Abstract
{
    public function onAuthorizationLevelDeleteBefore($event){
        $level = $event->getPayload();
        if( $level instanceof Authorization_Model_Level ) {
            $chatData['url'] = "https://api-us.cometchat.io/v2.0/roles/".$level->getIdentity();
            $chatData['dataType'] = "DELETE";
            Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
        }
    }
    public function onAuthorizationLevelCreateAfter($event){
        $level = $event->getPayload();
        if( $level instanceof Authorization_Model_Level ) {
            $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/roles";
            $chatData['postData']['name'] = $level->getTitle();
            $chatData['postData']['description'] = $level->description;
            $chatData['postData']['role'] = $level->getIdentity();
            Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
        }
    }
    public function onAuthorizationLevelUpdateAfter($event){
        $level = $event->getPayload();
        if( $level instanceof Authorization_Model_Level ) {
            $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/roles/".$level->getIdentity();
            $chatData['postData']['name'] = $level['title'];
            $chatData['dataType'] = "PUT";
            $chatData['postData']['description'] = $level['description'];
            Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
        }
    }
    public function onUserDeleteBefore($event)
    {
        $payload = $event->getPayload();
        if( $payload instanceof User_Model_User ) {
            /*Comet Chat Code*/
            if($payload->getIdentity()) {
                /*Register User*/
                $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$payload->getIdentity()."/friends";
                $users = $payload->membership()->getMembershipsOfIds();
                $chatData['dataType'] = "DELETE";
                $chatData['postData']['friends'] = implode(',',$users);
                Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
                $chatDataDelete['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$payload->getIdentity();
                $chatDataDelete['dataType'] = "DELETE";
                Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatDataDelete);

            }
        }
    }

    public function onUserLoginAfter($event){
       $user = $event->getPayload();
       if($user->getIdentity()){
           $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity()."/friends";
           $chatData['postData']['accepted'] = $user->membership()->getMembershipsOfIds();;
           Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
       }
    }

    public function onUserEnable($event)
    {
        $payload = $event->getPayload();
        $user = $payload['user'];
        if( !($user instanceof User_Model_User) ) {
            return;
        }
        /*Comet Chat Code*/
        if($user->getIdentity()) {
            /*Register User*/
            $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users";
            $chatData['postData']['uid'] = $user->getIdentity();
            $chatData['postData']['name'] = $user->getTitle();
            $chatData['postData']['avatar'] = Engine_Api::_()->ecometchatapi()->getUserPhotoUrl($user);
            $chatData['postData']['link'] = Engine_Api::_()->ecometchatapi()->getUserProfileUrl($user);;
            $chatData['postData']['role'] = $user->level_id;

            Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
        }
    }

    public function onUserUpdateAfter($event)
    {
        $payload = $event->getPayload();
        if ($payload instanceof User_Model_User) {
            /*Comet Chat Code*/
            if($payload->getIdentity()) {
                /*Register User*/
                $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$payload->getIdentity();
                $chatData['dataType']= "PUT";
                $chatData['postData']['name'] = $payload->getTitle();
                $chatData['postData']['avatar'] = Engine_Api::_()->ecometchatapi()->getUserPhotoUrl($payload);
                $chatData['postData']['link'] = Engine_Api::_()->ecometchatapi()->getUserProfileUrl($payload);;
                $chatData['postData']['role'] = $payload->level_id;
                Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
            }
        }
    }
    public function onUserCreateAfter($event)
    {
        $payload = $event->getPayload();
        if( $payload instanceof User_Model_User ) {

            /*Comet Chat Code*/
            if($payload->getIdentity()) {
                /*Register User*/
                $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users";
                $chatData['postData']['uid'] = $payload->getIdentity();
                $chatData['postData']['name'] = $payload->getTitle();
                $chatData['postData']['avatar'] = Engine_Api::_()->ecometchatapi()->getUserPhotoUrl($payload);
                $chatData['postData']['link'] = Engine_Api::_()->ecometchatapi()->getUserProfileUrl($payload);;
                $chatData['postData']['role'] = $payload->level_id;

                Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
            }
        }
    }

}
