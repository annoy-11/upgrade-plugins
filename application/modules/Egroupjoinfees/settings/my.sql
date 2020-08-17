
/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("egroupjoinfees_admin_main", "egroupjoinfees", "Group Joining Fees", "", '{"route":"admin_default","module":"egroupjoinfees","controller":"settings", "action":"extension"}', "sesgroup_admin_main", "", 995),
('egroupjoinfees_admin_main_settings', 'egroupjoinfees', 'Global Settings', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"settings","action":"extension"}', 'egroupjoinfees_admin_main', '', 1),
("egroupjoinfees_admin_main_currency", "egroupjoinfees", "Manage Currency", "Egroupjoinfees_Plugin_Menus::canViewMultipleCurrency", '{"route":"admin_default","module":"sesmultiplecurrency","controller":"settings","action":"currency","target":"_blank"}', "egroupjoinfees_admin_main", "", 5),
("egroupjoinfees_main_myorders", "egroupjoinfees", "My Orders", "Egroupjoinfees_Plugin_Menus::canViewOrders", '{"route":"egroupjoinfees_user_order","controller":"index","action":"view"}', "sesgroup_main", "", 10);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('egroupjoinfees_admin_main', 'egroupjoinfees', 'Group Joining Fees', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"settings", "action":"extension"}', 'sesgroup_admin_main', '', 1, 0, 995),
('egroupjoinfees_admin_main_settings', 'egroupjoinfees', 'Global Settings', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"settings","action":"extension"}', 'egroupjoinfees_admin_main', '', 1, 0, 1),
('egroupjoinfees_admin_main_currency', 'egroupjoinfees', 'Manage Currency', 'Egroupjoinfees_Plugin_Menus::canViewMultipleCurrency', '{"route":"admin_default","module":"sesmultiplecurrency","controller":"settings","action":"currency","target":"_blank"}', 'egroupjoinfees_admin_main', '', 1, 0, 5),
('egroupjoinfees_main_myorders', 'egroupjoinfees', 'My Orders', 'Egroupjoinfees_Plugin_Menus::canViewOrders', '{"route":"egroupjoinfees_user_order","controller":"index","action":"view"}', 'sesgroup_main', '', 1, 0, 10),
('egroupjoinfees_admin_main_settingsmemberlevel', 'egroupjoinfees', 'Member Level Settings', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"settings","action":"level"}', 'egroupjoinfees_admin_main', '', 1, 0, 2),
('egroupjoinfees_admin_main_manageorders', 'egroupjoinfees', 'Manage Orders', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"settings","action":"orders"}', 'egroupjoinfees_admin_main', '', 1, 0, 3),
('egroupjoinfees_admin_main_paymentrequest', 'egroupjoinfees', 'Manage Payments', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"payment"}', 'egroupjoinfees_admin_main', '', 1, 0, 4),
('egroupjoinfees_admin_main_paymentrequestsub', 'egroupjoinfees', 'Payment Requests', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"payment"}', 'egroupjoinfees_admin_main_pa', '', 1, 0, 1),
('egroupjoinfees_admin_main_managepaymenteventownersub', 'egroupjoinfees', 'Manage Payments Made', '', '{"route":"admin_default","module":"egroupjoinfees","controller":"settings","action":"manage-payment-group-owner"}', 'egroupjoinfees_admin_main_pa', '', 1, 0, 2),
('egroupjoinfees_admin_main_gateway', 'egroupjoinfees', 'Manage Gateways', '', '{"route":"admin_default","module":"payment","controller":"gateway","target":"_blank"}', 'egroupjoinfees_admin_main', '', 1, 0, 6);

INSERT INTO `engine4_sesgroup_dashboards` (`type`, `title`, `enabled`, `main`, `action_name`, `manage_section_name`, `permission_name`) VALUES
('entry_fees_paid_sespaidext', 'Manage Fees & Orders', 1, 0,'create-entry-fees','manage_group','edit'),
('create_feed_sespaidext', 'Entry Fees', 1, 0,'manage-orders','manage_group','edit'),
('account_details_sespaidext', 'Account Details', 1, 0,'payment-requests','manage_group','edit'),
('sales_statistics_sespaidext', 'Sales Statistics', 1, 0,'payment-transaction','manage_group','edit'),
('manage_orders_sespaidext', 'Manage Orders', 1, 0,'sales-stats','manage_group','edit'),
('sales_orders_sespaidext', 'Sales Reports', 1, 0,'sales-reports','manage_group','edit'),
('payment_requests_sespaidext', 'Payment Requests', 1, 0,'account-details','manage_group','edit');
-- ('payment_transactions_sespaidext', 'Payment Transactions', 1, 0,'create-entry-fees','manage_group','edit');

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
('notify_sesgroup_group_invite', 'egroupjoinfees', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[group_name],[member_name]');

INSERT INTO `engine4_sesgroup_dashboards` (`dashboard_id`, `type`, `title`, `enabled`, `main`, `action_name`, `manage_section_name`, `permission_name`) VALUES
(24, 'insight', 'Insights', 1, 0, 'insights', 'insightreport', 'group_allow_insightreport'),
(25, 'report', 'Reports', 1, 0, 'reports', 'insightreport', 'group_allow_insightreport');

DROP TABLE IF EXISTS `engine4_egroupjoinfees_orders`;
CREATE TABLE `engine4_egroupjoinfees_orders` (
  `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` int(11) UNSIGNED NOT NULL,
  `entry_id` int(11) NOT NULL DEFAULT 0,
  `owner_id` int(11) UNSIGNED NOT NULL,
  `gateway_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gateway_transaction_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `commission_amount` float DEFAULT 0,
  `private` tinyint(1) DEFAULT 0,
  `state` enum('pending','cancelled','failed','incomplete','complete','refund') COLLATE utf8_unicode_ci DEFAULT 'incomplete',
  `change_rate` float DEFAULT 0,
  `total_amount` float DEFAULT 0,
  `currency_symbol` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `gateway_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Paypal',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(55) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `credit_point` int(11) NOT NULL DEFAULT 0,
  `credit_value` float NOT NULL DEFAULT 0,
  `ordercoupon_id` int(11) DEFAULT 0,
  `discount_type` int(6) DEFAULT NULL,
  `discount_value` int(6) DEFAULT NULL,
  KEY `group_id` (`group_id`),
  KEY `owner_id` (`owner_id`),
  KEY `gateway_id` (`gateway_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `engine4_egroupjoinfees_orders` ADD `plan_id` INT NOT NULL AFTER `discount_value`;



DROP TABLE IF EXISTS `engine4_egroupjoinfees_remainingpayments`;
CREATE TABLE `engine4_egroupjoinfees_remainingpayments` (
  `remainingpayment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` int(11) UNSIGNED NOT NULL,
  `remaining_payment` float DEFAULT 0,
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `engine4_egroupjoinfees_usergateways`;
CREATE TABLE `engine4_egroupjoinfees_usergateways` (
  `usergateway_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(244) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `plugin` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `config` mediumblob DEFAULT NULL,
  `test_mode` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `gateway_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'paypal',
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `engine4_egroupjoinfees_userpayrequests`;
CREATE TABLE `engine4_egroupjoinfees_userpayrequests` (
  `userpayrequest_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL,
  `requested_amount` float DEFAULT 0,
  `release_amount` float DEFAULT 0,
  `user_message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `release_date` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `gateway_id` tinyint(1) DEFAULT 2,
  `gateway_transaction_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` enum('pending','cancelled','failed','incomplete','complete','refund') COLLATE utf8_unicode_ci DEFAULT 'pending',
  `currency_symbol` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `gateway_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Paypal',
  KEY `group_id` (`group_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `engine4_sesgroup_groups` ADD `entry_fees` DECIMAL(7,2) NOT NULL AFTER `orderspackage_id`, ADD `currency` VARCHAR(32) NOT NULL AFTER `entry_fees`;

DROP TABLE IF EXISTS `engine4_egroupjoinfees_plans`;
CREATE TABLE `engine4_egroupjoinfees_plans` (
  `plan_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `custom_fields` text DEFAULT NULL,
  `member_level` varchar(255) DEFAULT NULL,
  `price` float DEFAULT 0,
  `recurrence` varchar(25) DEFAULT '0',
  `renew_link_days` int(11) DEFAULT 0,
  `is_renew_link` tinyint(1) DEFAULT 0,
  `recurrence_type` varchar(25) DEFAULT NULL,
  `duration` varchar(25) DEFAULT '0',
  `duration_type` varchar(10) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `params` text DEFAULT NULL,
  `custom_fields_params` text DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `highlight` tinyint(1) NOT NULL DEFAULT 0,
  `show_upgrade` int(11) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
