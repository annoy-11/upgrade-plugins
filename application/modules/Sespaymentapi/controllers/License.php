<?php

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {
  if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespaymentapi.pluginactivated')) {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
    ("sespaymentapi_admin_main_managepayment", "sespaymentapi", "Manage Payments", "", \'{"route":"admin_default","module":"sespaymentapi","controller":"payment"}\', "sespaymentapi_admin_main", "", 3),
    ("sespaymentapi_admin_main_paymentrequests", "sespaymentapi", "Payment Requests", "", \'{"route":"admin_default","module":"sespaymentapi","controller":"payment"}\', "sespaymentapi_admin_main_managepayment", "", 1),
    ("sespaymentapi_admin_main_managepaymentmade", "sespaymentapi", "Manage Payments Made", "", \'{"route":"admin_default","module":"sespaymentapi","controller":"payment","action":"manage-payment-made"}\', "sespaymentapi_admin_main_managepayment", "", 2),
    ("sespaymentapi_admin_main_managerefunds", "sespaymentapi", "Manage Refunds", "", \'{"route":"admin_default","module":"sespaymentapi","controller":"refund"}\', "sespaymentapi_admin_main", "", 4),
    ("sespaymentapi_admin_main_refundrequests", "sespaymentapi", "Refund Requests", "", \'{"route":"admin_default","module":"sespaymentapi","controller":"refund"}\', "sespaymentapi_admin_main_managerefunds", "", 1),
    ("sespaymentapi_admin_main_managerefundmade", "sespaymentapi", "Manage Refunds Made", "", \'{"route":"admin_default","module":"sespaymentapi","controller":"refund","action":"manage-refund-made"}\', "sespaymentapi_admin_main_managerefunds", "", 2),
    ("sespaymentapi_profile_payment", "sespaymentapi", "Payment Settings", "Sespaymentapi_Plugin_Menus", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"account-details"}\', "user_profile", "", 999),
    ("sespaymentapi_settings_paymentsettings", "sespaymentapi", "Payment Settings", "", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"account-details"}\', "user_settings", "", 1),
    ("sespaymentapi_settings_paymentgateways", "sespaymentapi", "Payment Settings", "", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"account-details"}\', "sespaymentapi_settings", "", 1),
    ("sespaymentapi_settings_manageorders", "sespaymentapi", "Manage Orders", "", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"manage-orders"}\', "sespaymentapi_settings", "", 2),
    ("sespaymentapi_settings_managetransactions", "sespaymentapi", "Manage Transactions", "", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"manage-transactions"}\', "sespaymentapi_settings", "", 3),
    ("sespaymentapi_settings_paymenrredeem", "sespaymentapi", "Redeem Payment", "", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"payment-requests"}\', "sespaymentapi_settings", "", 4),
    ("sespaymentapi_settings_paymentrequests", "sespaymentapi", "Payment Requests", "", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"payment-requests"}\', "sespaymentapi_settings_paymenrredeem", "", 1),
    ("sespaymentapi_settings_payrevetransactions", "sespaymentapi", "Payments Received", "", \'{"route":"sespaymentapi_extended", "module":"sespaymentapi", "controller":"index", "action":"payment-transaction"}\', "sespaymentapi_settings_paymenrredeem", "", 2),
    ("sespaymentapi_edit_subscribe", "sespaymentapi", "Profile Subscription", "", \'{"route":"sesmembersubscription_extended","module":"sesmembersubscription","controller":"index","action":"index"}\', "sespaymentapi_settings", "", 5);');
    
    $db->query('DROP TABLE IF EXISTS `engine4_sespaymentapi_packages`;');
    $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespaymentapi_packages` (
      `package_id` int(10) unsigned NOT NULL auto_increment,
      `downgrade_level_id` int(10) unsigned NOT NULL default "0",
      `price` decimal(16,2) unsigned NOT NULL,
      `recurrence` int(11) unsigned NOT NULL,
      `recurrence_type` enum("day","week","month","year","forever") NOT NULL,
      `duration` int(11) unsigned NOT NULL,
      `duration_type` enum("day","week","month","year","forever") NOT NULL,
      `trial_duration` int(11) unsigned NOT NULL default "0",
      `trial_duration_type` enum("day","week","month","year","forever") default NULL,
      `enabled` tinyint(1) unsigned NOT NULL default "1",
      `resource_id` INT(11) NOT NULL,
      `resource_type` varchar(255) NOT NULL DEFAULT "user",
      PRIMARY KEY  (`package_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
    
    $db->query('DROP TABLE IF EXISTS `engine4_sespaymentapi_usergateways`;');
    $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespaymentapi_usergateways` (
      `usergateway_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) UNSIGNED NOT NULL,
      `title` varchar(128)  NOT NULL,
      `description` text,
      `enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT "0",
      `plugin` varchar(128)  NOT NULL,
      `sponsorship` varchar(128)  NOT NULL,
      `config` mediumblob,
      `test_mode` tinyint(1) UNSIGNED NOT NULL DEFAULT "0",
      PRIMARY KEY (`usergateway_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
    
    $db->query('DROP TABLE IF EXISTS `engine4_sespaymentapi_orders`;');
    $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespaymentapi_orders` (
      `order_id` int(10) unsigned NOT NULL auto_increment,
      `resource_id` int(255) UNSIGNED NOT NULL,
      `resource_type` varchar(255) DEFAULT NULL,
      `user_id` int(11) UNSIGNED NOT NULL,
      `gateway_id` varchar(128) DEFAULT NULL,
      `fname` varchar(128) DEFAULT NULL,
      `lname` varchar(128) DEFAULT NULL,
      `email` varchar(128) DEFAULT NULL,
      `order_no` varchar(255) DEFAULT NULL,
      `gateway_transaction_id` varchar(128) DEFAULT NULL,
      `commission_amount` float DEFAULT "0",
      `private` tinyint(1) DEFAULT "0",
      `state` enum("pending","cancelled","failed","incomplete","complete","refund") DEFAULT "incomplete",
      `total_amount` float DEFAULT "0",
      `total_useramount` float DEFAULT "0",
      `currency_symbol` varchar(45) NOT NULL,
      `gateway_type` varchar(45) NOT NULL DEFAULT "Paypal",
      `is_delete` tinyint(1) NOT NULL DEFAULT "0",
      `creation_date` datetime NOT NULL,
      `modified_date` datetime NOT NULL,
      `gateway_profile_id` VARCHAR(128) NULL,
      PRIMARY KEY (`order_id`),
      KEY `resource_id` (`resource_id`),
      KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
    
    $db->query('DROP TABLE IF EXISTS `engine4_sespaymentapi_transactions`;');
    $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespaymentapi_transactions` (
      `transaction_id` int(10) unsigned NOT NULL auto_increment,
      `user_id` int(10) unsigned NOT NULL default "0",
      `gateway_id` int(10) unsigned NOT NULL,
      `timestamp` datetime NOT NULL,
      `order_id` int(10) unsigned NOT NULL default "0",
      `type` varchar(64)  NULL,
      `state` enum("pending","cancelled","failed","imcomplete","complete","refund","okay","overdue","initial","active") NOT NULL DEFAULT "pending",
      `gateway_transaction_id` varchar(128)  NOT NULL,
      `gateway_parent_transaction_id` varchar(128)  NULL,
      `gateway_order_id` varchar(128)  NULL,
      `amount` decimal(16,2) NOT NULL,
      `currency` char(3)  NOT NULL default "",
      `expiration_date` datetime NOT NULL,
      `resource_id` int(10) unsigned NOT NULL default "0",
      `resource_type` VARCHAR(128) DEFAULT NULL,
      `gateway_profile_id` VARCHAR(128) DEFAULT NULL,
      `package_id` INT(11) NOT NULL,
      PRIMARY KEY  (`transaction_id`),
      KEY `user_id` (`user_id`),
      KEY `gateway_id` (`gateway_id`),
      KEY `type` (`type`),
      KEY `state` (`state`),
      KEY `gateway_transaction_id` (`gateway_transaction_id`),
      KEY `gateway_parent_transaction_id` (`gateway_parent_transaction_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
    
    $db->query('DROP TABLE IF EXISTS `engine4_sespaymentapi_remainingpayments`;');
    $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespaymentapi_remainingpayments` (
      `remainingpayment_id` int(10) unsigned NOT NULL auto_increment,
      `user_id` int(11) UNSIGNED NOT NULL,
      `remaining_payment` float DEFAULT "0",
      `resource_id` INT(255) NOT NULL,
      `resource_type` VARCHAR(255) NOT NULL DEFAULT "user",
      PRIMARY KEY (`remainingpayment_id`),
      UNIQUE( `user_id`, `resource_id`, `resource_type`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
    
    $db->query('DROP TABLE IF EXISTS `engine4_sespaymentapi_userpayrequests`;');
    $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespaymentapi_userpayrequests` (
      `userpayrequest_id` INT(11) unsigned NOT NULL auto_increment,
      `resource_id` INT(11) unsigned NOT NULL,
      `resource_type` VARCHAR(255) NOT NULL DEFAULT "user",
      `owner_id` INT(11) unsigned NOT NULL,
      `requested_amount` FLOAT DEFAULT "0",
      `release_amount` FLOAT DEFAULT "0",
      `user_message` TEXT,
      `admin_message` TEXT,
      `creation_date` datetime NOT NULL,
      `release_date` datetime NOT NULL,
      `is_delete` TINYINT(1) NOT NULL DEFAULT "0",
      `gateway_id` TINYINT (1) DEFAULT "2",
      `gateway_transaction_id` varchar(128) DEFAULT NULL,
      `state` ENUM("pending","cancelled","failed","incomplete","complete","refund") DEFAULT "pending",
      `currency_symbol` VARCHAR(45) NOT NULL,
      `gateway_type` VARCHAR(45) NOT NULL DEFAULT "Paypal",
      PRIMARY KEY (`userpayrequest_id`),
      KEY `resource_id` (`resource_id`),
      KEY `owner_id` (`owner_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
    
    $db->query('ALTER TABLE `engine4_sespaymentapi_packages` ADD `message` TEXT NOT NULL;');
    
    $db->query('DROP TABLE IF EXISTS `engine4_sespaymentapi_refundrequests`;');
    $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespaymentapi_refundrequests` (
      `refundrequest_id` INT(11) unsigned NOT NULL auto_increment,
      `transaction_id` INT(11) unsigned NOT NULL,
      `user_id` INT(11) unsigned NOT NULL,
      `total_amount` FLOAT DEFAULT "0",
      `release_amount` FLOAT DEFAULT "0",
      `user_message` TEXT,
      `admin_message` TEXT,
      `creation_date` datetime NOT NULL,
      `release_date` datetime NOT NULL,
      `is_delete` TINYINT(1) NOT NULL DEFAULT "0",
      `gateway_id` TINYINT (1) DEFAULT "2",
      `gateway_transaction_id` varchar(128) DEFAULT NULL,
      `state` ENUM("pending","cancelled","failed","incomplete","complete","refund") DEFAULT "pending",
      `currency_symbol` VARCHAR(45) NOT NULL,
      `gateway_type` VARCHAR(45) NOT NULL DEFAULT "Paypal",
      PRIMARY KEY (`refundrequest_id`),
      KEY `transaction_id` (`transaction_id`),
      KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
    
    $db->query('ALTER TABLE `engine4_sespaymentapi_refundrequests` ADD `resource_id` INT(11) NOT NULL AFTER `release_amount`, ADD `resource_type` VARCHAR(255) NOT NULL AFTER `resource_id`;');

    include_once APPLICATION_PATH . "/application/modules/Sespaymentapi/controllers/defaultsettings.php";

    Engine_Api::_()->getApi('settings', 'core')->setSetting('sespaymentapi.pluginactivated', 1);
  }
}