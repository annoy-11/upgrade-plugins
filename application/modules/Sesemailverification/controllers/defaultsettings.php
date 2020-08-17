<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$date = date('Y-m-d');
$db->query("INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ('sesemailverification.pluginactivationdate', '$date');");

$db->query('INSERT IGNORE INTO `engine4_core_tasks` (`title`, `module`, `plugin`, `timeout`) VALUES
("SES - Email Verification Reminder - Auto Account Suspend", "sesemailverification", "Sesemailverification_Plugin_Task_Autosuspend", 86400);');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesemailverification_admin_main_manage", "sesemailverification", "Manage Members", "", \'{"route":"admin_default","module":"sesemailverification","controller":"manage"}\', "sesemailverification_admin_main", "", 2);');

$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesemailverification_verifications` (
  `verification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sesemailverified` TINYINT(1) NOT NULL DEFAULT "0",
  PRIMARY KEY (`verification_id`),
  UNIQUE( `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;');

$verifyemail = Engine_Api::_()->getApi('settings', 'core')->getSetting('user.signup.verifyemail');
if($verifyemail == 2) {
  $db->query('INSERT IGNORE INTO engine4_sesemailverification_verifications (`user_id`) SELECT `user_id` FROM engine4_users as t ON DUPLICATE KEY UPDATE user_id=t.user_id;');
  $db->query('UPDATE `engine4_sesemailverification_verifications` SET `sesemailverified` = "1";');
}

$parent_content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'container')
        ->where('page_id = ?', '1')
        ->where('name = ?', 'main')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (empty($content_id)) {
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesemailverification.email-verification',
      'page_id' => 1,
      'parent_content_id' => $parent_content_id,
      'order' => 1,
  ));
}
