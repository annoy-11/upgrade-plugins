<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvminimenu
 * @package    Sesadvminimenu
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$table_exist_recipients = $db->query('SHOW TABLES LIKE \'engine4_messages_recipients\'')->fetch();
if (!empty($table_exist_recipients)) {
	$sesadvminimenu_read = $db->query('SHOW COLUMNS FROM engine4_messages_recipients LIKE \'sesadvminimenu_read\'')->fetch();
	if (empty($sesadvminimenu_read)) {
		$db->query('ALTER TABLE `engine4_messages_recipients` ADD `sesadvminimenu_read` TINYINT(1) NOT NULL DEFAULT "0";');
	}
}

$table_exist_notifications = $db->query('SHOW TABLES LIKE \'engine4_activity_notifications\'')->fetch();
if (!empty($table_exist_notifications)) {
	$sesadvminimenu_read = $db->query('SHOW COLUMNS FROM engine4_activity_notifications LIKE \'sesadvminimenu_read\'')->fetch();
	if (empty($sesadvminimenu_read)) {
		$db->query('ALTER TABLE `engine4_activity_notifications` ADD `sesadvminimenu_read` TINYINT(1) NOT NULL DEFAULT "0";');
	}
}