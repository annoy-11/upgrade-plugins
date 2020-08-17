 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('coursespackage', 'Course package', '', '4.10.5', 1, 'extra') ;


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("courses_admin_main_package", "coursespackage", "Package Settings", "", '{"route":"admin_default","module":"coursespackage","controller":"package","action":"settings"}', "courses_admin_main", "", 2),

("courses_admin_main_packageset", "coursespackage", "Package Settings", "", '{"route":"admin_default","module":"coursespackage","controller":"package","action":"settings"}', "courses_admin_main_package", "", 1),

("courses_admin_main_packman", "coursespackage", "Manage Packages", "", '{"route":"admin_default","module":"coursespackage","controller":"package"}', "courses_admin_main_package", "", 2),

("courses_admin_main_packtran", "coursespackage", "Manage Transactions", "", '{"route":"admin_default","module":"coursespackage","controller":"package","action":"manage-transaction"}', "courses_admin_main_package", "", 2);


ALTER TABLE `engine4_courses_courses` ADD `orderspackage_id` INT NOT NULL AFTER `venue_name`, ADD `transaction_id` INT NOT NULL AFTER `orderspackage_id`, ADD `existing_package_order` INT NOT NULL AFTER `transaction_id`;

ALTER TABLE `engine4_courses_courses` ADD `package_id` INT NOT NULL AFTER `existing_package_order`;

ALTER TABLE `engine4_eclassroom_classrooms` ADD `orderspackage_id` INT NOT NULL, ADD `transaction_id` INT NOT NULL AFTER `orderspackage_id`, ADD `existing_package_order` INT NOT NULL AFTER `transaction_id`;

ALTER TABLE `engine4_eclassroom_classrooms` ADD `package_id` INT NOT NULL AFTER `existing_package_order`;

DROP TABLE IF EXISTS `engine4_coursespackage_packages`;     
CREATE TABLE `engine4_coursespackage_packages` (
  `package_id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `item_count` int(8) DEFAULT '0',
  `custom_fields` text,
  `member_level` varchar(255) DEFAULT NULL,
  `price` float DEFAULT '0',
  `recurrence` varchar(25) DEFAULT '0',
  `renew_link_days` int(11) DEFAULT '0',
  `is_renew_link` tinyint(1) DEFAULT '0',
  `recurrence_type` varchar(25) DEFAULT NULL,
  `duration` varchar(25) DEFAULT '0',
  `duration_type` varchar(10) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `params` text,
  `custom_fields_params` text,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `highlight` tinyint(1) NOT NULL DEFAULT '0',
  `show_upgrade` int(11) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `engine4_coursespackage_orderspackages`;  
CREATE TABLE `engine4_coursespackage_orderspackages` (
  `orderspackage_id` int(6) NOT NULL AUTO_INCREMENT,
  `package_id` int(4) NOT NULL,
  `item_count` int(6) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `state` enum('pending','cancelled','failed','imcomplete','complete','refund','okay','overdue','active') NOT NULL DEFAULT 'pending',
  `expiration_date` datetime NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0.0.0.0',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
   PRIMARY KEY (`orderspackage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `engine4_coursespackage_transactions`; 
CREATE TABLE `engine4_coursespackage_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(4) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `orderspackage_id` int(11) NOT NULL,
  `gateway_id` tinyint(1) DEFAULT NULL,
  `gateway_transaction_id` varchar(128) DEFAULT NULL,
  `gateway_parent_transaction_id` varchar(128) DEFAULT NULL,
  `item_count` int(11) NOT NULL DEFAULT '0',
  `gateway_profile_id` varchar(128) DEFAULT NULL,
  `state` enum('pending','cancelled','failed','imcomplete','complete','refund','okay','overdue','initial','active') NOT NULL DEFAULT 'pending',
  `change_rate` float NOT NULL DEFAULT '0',
  `total_amount` float NOT NULL DEFAULT '0',
  `currency_symbol` varchar(45) DEFAULT NULL,
  `gateway_type` varchar(45) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0.0.0.0',
  `expiration_date` datetime NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
