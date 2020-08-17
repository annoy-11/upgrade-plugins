<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$emessagesRoute = "emessages";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
	$module1 = $request->getModuleName();
	$action = $request->getActionName();
	$controller = $request->getControllerName();
}
if (empty($request) || !((strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
	$setting = Engine_Api::_()->getApi('settings', 'core');
	$emessagesRoute = $setting->getSetting('emessages.manifest', 'messages');
}

return array (
  'package' =>
	array(
		'type' => 'module',
		'name' => 'emessages',
		//'sku' => 'emessages',
		'version' => '5.2.1p1',
		'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
		'path' => 'application/modules/Emessages',
		'title' => 'SNS - Professional Messages Plugin',
		'description' => 'SNS - Professional Messages Plugin',
		'author' => '<a href="http://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
		'actions' => array(
			'install',
			'upgrade',
			'refresh',
			'enable',
			'disable',
		),
		'callback' => array(
			'path' => 'application/modules/Emessages/settings/install.php',
			'class' => 'Emessages_Installer',
		),
		'directories' => array(
			'application/modules/Emessages',
		),
		'files' => array(
			'application/languages/en/emessages.csv',
		),
	),
	'items' => array(
		'emessages',
		'emessages_userlist',
		'emessages_groupuser',
		'emessages_messageattachment',
		'emessages_recipients',
		'emessages_usersetting',
	),
	'routes' => array(
		'messages_general' => array(
			'route' => 'request/:action/*',
			'defaults' => array(
				'module' => 'emessages',
				'controller' => 'settings',
				'action' => 'index',
			),
			'reqs' => array(
				'action' => '(index)',
			),
		),
		'emessages_setting' => array(
			'route' => 'message_settings/:action/*',
			'defaults' => array(
				'module' => 'emessages',
				'controller' => 'messagesetting',
				'action' => 'index',
			),
			'reqs' => array(
				'action' => '(index)',
			),
		),
		'messages' => array(
			'route' => $emessagesRoute.'messagess/:action/*',
			'defaults' => array(
				'module' => 'emessages',
				'controller' => 'messages',
				'action' => 'index',
			),
			'reqs' => array(
				'action' => '(index|addnewuseringroup|changegroupname|suggest|notificationlistappend|editmessage)',
			),
		),
	),
);
