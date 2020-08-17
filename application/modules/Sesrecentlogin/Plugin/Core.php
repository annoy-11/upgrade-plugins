<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecentlogin
 * @package    Sesrecentlogin
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecentlogin_Plugin_Core extends Zend_Controller_Plugin_Abstract {

    public function onUserLoginAfter($event) {

        $payload = $event->getPayload();
        $user_id = $payload->getIdentity();
        //setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        if (!isset($_COOKIE['sesrecentlogin_users'])) {
            $cookie_value = Zend_Json::encode(array("userid_".$user_id => $user_id. '_'.$payload->password));
            setcookie('sesrecentlogin_users', $cookie_value, time() + 86400, '/');
        } else {
            $sesrecentlogin_users = Zend_Json::decode($_COOKIE['sesrecentlogin_users']);
            $cookie_value_merge = array_merge(array("userid_".$user_id => $user_id. '_'.$payload->password), $sesrecentlogin_users);
            $cookie_value = Zend_Json::encode(array_unique($cookie_value_merge));
            setcookie('sesrecentlogin_users', $cookie_value, time() + 86400, '/');
        }
    }
}
