/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my-upgrade-4.10.3p9-4.10.3p10.sql 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

UPDATE `engine4_core_menuitems` SET `label` = 'SES - Web & Mobile...' WHERE `engine4_core_menuitems`.`name` = 'core_admin_main_settings_sesbrowserpush';

ALTER TABLE `engine4_sesbrowserpush_tokens` ADD `user_agent` VARCHAR(32) NULL;

DELETE FROM `engine4_core_menuitems` WHERE `engine4_core_menuitems`.`module` = 'sesbrowserpush';

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_settings_sesbrowserpush', 'sesbrowserpush', 'SES - Web & Mobile...', '', '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 1),
('sesbrowserpush_admin_main_settings', 'sesbrowserpush', 'Global Settings', '', '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"index"}', 'sesbrowserpush_admin_main', '', 1),
("sesbrowserpush_admin_main_fbsettings", "sesbrowserpush", "API Settings", "", '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"fb-settings"}', "sesbrowserpush_admin_main", "", 2),
("sesbrowserpush_admin_main_welcome", "sesbrowserpush", "Welcome Notification", "", '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"welcome"}', "sesbrowserpush_admin_main", "", 3),
("sesbrowserpush_admin_main_sendnoti", "sesbrowserpush", "Send Notifications", "", '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"notification"}', "sesbrowserpush_admin_main", "", 4),
("sesbrowserpush_admin_main_scheduled", "sesbrowserpush", "Schedule Notifications", "", '{"route":"admin_default","module":"sesbrowserpush","controller":"scheduled","action":"index"}', "sesbrowserpush_admin_main", "", 5),
("sesbrowserpush_admin_main_sentscheduled", "sesbrowserpush", "Sent Notifications", "", '{"route":"admin_default","module":"sesbrowserpush","controller":"scheduled","action":"sent"}', "sesbrowserpush_admin_main", "", 6),
("sesbrowserpush_admin_main_managesubscriber", "sesbrowserpush", "Manage Subscribers", "", '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"subscriber"}', "sesbrowserpush_admin_main", "", 7),
("sesbrowserpush_admin_main_reports", "sesbrowserpush", "Report & Statistics", "", '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"reports"}', "sesbrowserpush_admin_main", "", 8);

ALTER TABLE `engine4_sesbrowserpush_scheduleds` ADD INDEX(`criteria`);
ALTER TABLE `engine4_sesbrowserpush_scheduleds` ADD INDEX(`sent`);
ALTER TABLE `engine4_sesbrowserpush_tokens` ADD INDEX(`browser`);
ALTER TABLE `engine4_sesbrowserpush_tokens` ADD INDEX(`user_agent`);

DROP TABLE IF EXISTS `engine4_sesbrowserpush_notifications`;
CREATE TABLE IF NOT EXISTS `engine4_sesbrowserpush_notifications` (
  `notification_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `access_token` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT "",
  `user_id` INT(11) UNSIGNED NOT NULL,
  `scheduled_id` INT(11) UNSIGNED NOT NULL,
  `param` TINYINT(1) DEFAULT "1",
  PRIMARY KEY (`notification_id`),
  KEY `user_id` (`user_id`),
  KEY `scheduled_id` (`scheduled_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
