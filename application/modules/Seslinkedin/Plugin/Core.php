<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Plugin_Core extends Zend_Controller_Plugin_Abstract {

    public function routeShutdown(Zend_Controller_Request_Abstract $request) {

        if (substr($request->getPathInfo(), 1, 5) == "admin") {
            $params = $request->getParams();
            if($params['module'] == 'seslinkedin' &&  $params['controller'] == "admin-menu") {
                $request->setModuleName('sesbasic');
                $request->setControllerName('admin-menu');
                $request->setActionName($params['action']);
                $request->setParam('moduleName', 'seslinkedin');
            }
        }
    }

    public function onUserLoginAfter($event) {

        $payload = $event->getPayload();
        $user_id = $payload->getIdentity();
        //setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        if (!isset($_COOKIE['ses_login_users'])) {
            $cookie_value = Zend_Json::encode(array("userid_".$user_id => $user_id. '_'.$payload->password));
            setcookie('ses_login_users', $cookie_value, time() + 86400, '/');
        } else {
            $ses_login_users = Zend_Json::decode($_COOKIE['ses_login_users']);
            $cookie_value_merge = array_merge(array("userid_".$user_id => $user_id. '_'.$payload->password), $ses_login_users);
            $cookie_value = Zend_Json::encode(array_unique($cookie_value_merge));
            setcookie('ses_login_users', $cookie_value, time() + 86400, '/');
        }
    }

	public function onRenderLayoutDefault() {

        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl.'application/modules/Sesbasic/externals/styles/customscrollbar.css');
        $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/jquery.min.js');
        $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js');
	}
}
