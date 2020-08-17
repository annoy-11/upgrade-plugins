INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('sessubscribeuser', 'User Subscriber Plugin', 'User Subscriber Plugin', '4.8.13', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sessubscribeuser', 'sessubscribeuser', 'SES- Advanced User Subscriber', '', '{"route":"admin_default","module":"sessubscribeuser","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sessubscribeuser_admin_main_settings', 'sessubscribeuser', 'Global Settings', '', '{"route":"admin_default","module":"sessubscribeuser","controller":"settings"}', 'sessubscribeuser_admin_main', '', 1),
('sessubscribeuser_admin_paymentmade', 'sessubscribeuser', 'Manage Payment Made', '', '{"route":"admin_default","module":"sessubscribeuser","controller":"paymentmade"}', 'sessubscribeuser_admin_main', '', 3);


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sessubscribeuser_edit_subscribe', 'sessubscribeuser', 'Subscribe Details', '', '{"route":"sessubscribeuser_extended","module":"sessubscribeuser","controller":"index","action":"index"}', 'user_edit', '', 80),
('sessubscribeuser_edit_paypaldetails', 'sessubscribeuser', 'Paypal Details Details', '', '{"route":"sessubscribeuser_extended","module":"sessubscribeuser","controller":"index","action":"account-details"}', 'user_edit', '', 81);

INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("sessubscribeuser_subscribe_owner", "sessubscribeuser", '{item:$subject} has subscribe your profile.', 0, "");

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sessubscribeuser_profile_subscribeuser", "sessubscribeuser", "Subscriber", "Sessubscribeuser_Plugin_Menus", "", "user_profile", "", 20);

DROP TABLE IF EXISTS `engine4_sessubscribeuser_packages`;
CREATE TABLE IF NOT EXISTS `engine4_sessubscribeuser_packages` (
  `package_id` int(10) unsigned NOT NULL auto_increment,
--   `level_id` int(10) unsigned NOT NULL,
  `downgrade_level_id` int(10) unsigned NOT NULL default '0',
  `price` decimal(16,2) unsigned NOT NULL,
  `recurrence` int(11) unsigned NOT NULL,
  `recurrence_type` enum('day','week','month','year','forever') NOT NULL,
  `duration` int(11) unsigned NOT NULL,
  `duration_type` enum('day','week','month','year','forever') NOT NULL,
  `trial_duration` int(11) unsigned NOT NULL default '0',
  `trial_duration_type` enum('day','week','month','year','forever') default NULL,
  `enabled` tinyint(1) unsigned NOT NULL default '1',
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY  (`package_id`)
--   KEY `level_id` (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `engine4_sessubscribeuser_orders`;
CREATE TABLE IF NOT EXISTS `engine4_sessubscribeuser_orders` (
  `order_id` int(10) unsigned NOT NULL auto_increment,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `gateway_id` varchar(128) DEFAULT NULL,
  `fname` varchar(128) DEFAULT NULL,
  `lname` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `gateway_transaction_id` varchar(128) DEFAULT NULL,
  `commission_amount` float DEFAULT '0',
  `private` tinyint(1) DEFAULT '0',
  `state` enum('pending','cancelled','failed','incomplete','complete','refund') DEFAULT 'incomplete',
  `total_amount` float DEFAULT '0',
  `total_useramount` float DEFAULT '0',
  `currency_symbol` varchar(45) NOT NULL,
  `gateway_type` varchar(45) NOT NULL DEFAULT 'Paypal',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `gateway_profile_id` VARCHAR(128) NULL,
  PRIMARY KEY (`order_id`),
  KEY `subject_id` (`subject_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- DROP TABLE IF EXISTS `engine4_sessubscribeuser_transactions`;
-- CREATE TABLE IF NOT EXISTS `engine4_sessubscribeuser_transactions` (
--   `transaction_id` int(10) unsigned NOT NULL auto_increment,
--   `owner_id` int(11) NOT NULL,
-- 	`order_id` int(11) NOT NULL,
-- 	`orderspackage_id` int(11) NOT NULL,
--   `gateway_id` tinyint(1) DEFAULT NULL,
--   `gateway_transaction_id` varchar(128) DEFAULT NULL,
-- 	`gateway_parent_transaction_id` varchar(128) DEFAULT NULL,
--   `item_count` int(11) NOT NULL DEFAULT '0',
-- 	`gateway_profile_id` VARCHAR(128) DEFAULT NULL,
--   `state` enum('pending','cancelled','failed','imcomplete','complete','refund','okay','overdue','initial','active') NOT NULL DEFAULT 'pending',
--   `change_rate` float NOT NULL DEFAULT '0',
--   `total_amount` float NOT NULL DEFAULT '0',
--   `currency_symbol` varchar(45) DEFAULT NULL,
--   `gateway_type` varchar(45) DEFAULT NULL,
--   `ip_address` varchar(45) NOT NULL DEFAULT '0.0.0.0',
-- 	`expiration_date` datetime NOT NULL,
--   `creation_date` datetime NOT NULL,
--   `modified_date` datetime NOT NULL,
--   `package_id` INT(11) NOT NULL,
--   PRIMARY KEY (`transaction_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT = 1 ;


DROP TABLE IF EXISTS `engine4_sessubscribeuser_transactions`;
CREATE TABLE IF NOT EXISTS `engine4_sessubscribeuser_transactions` (
  `transaction_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `gateway_id` int(10) unsigned NOT NULL,
  `timestamp` datetime NOT NULL,
  `order_id` int(10) unsigned NOT NULL default '0',
  `type` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NULL,
  `state` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NULL,
  `gateway_transaction_id` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `gateway_parent_transaction_id` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NULL,
  `gateway_order_id` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NULL,
  `amount` decimal(16,2) NOT NULL,
  `currency` char(3) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL default '',
  `expiration_date` datetime NOT NULL,
  `subject_id` int(10) unsigned NOT NULL default '0',
  `gateway_profile_id` VARCHAR(128) DEFAULT NULL,
  `package_id` INT(11) NOT NULL,
  PRIMARY KEY  (`transaction_id`),
  KEY `user_id` (`user_id`),
  KEY `gateway_id` (`gateway_id`),
  KEY `type` (`type`),
  KEY `state` (`state`),
  KEY `gateway_transaction_id` (`gateway_transaction_id`),
  KEY `gateway_parent_transaction_id` (`gateway_parent_transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `engine4_sessubscribeuser_remainingpayments`;
CREATE TABLE IF NOT EXISTS `engine4_sessubscribeuser_remainingpayments` (
  `remainingpayment_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) UNSIGNED NOT NULL,
  `remaining_payment` float DEFAULT '0',
  PRIMARY KEY (`remainingpayment_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `engine4_sessubscribeuser_usergateways`;
CREATE TABLE IF NOT EXISTS `engine4_sessubscribeuser_usergateways` (
  `usergateway_id` int(10) unsigned NOT NULL auto_increment,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `plugin` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sponsorship` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `config` mediumblob,
  `test_mode` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`usergateway_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

