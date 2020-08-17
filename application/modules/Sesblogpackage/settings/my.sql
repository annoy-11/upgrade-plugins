INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('sesblogpackage', 'SES - Advanced Blog Package', 'Advanced Blog Package', '4.8.10', 1, 'extra');


-- --------------------------------------------------------
--
-- Dumping data for table `engine4_core_menuitems`
--

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesblogpackage_admin_main_packagesetting', 'sesblogpackage', 'Package Settings', '', '{"route":"admin_default","module":"sesblogpackage","controller":"package", "action":"settings"}', 'sesblog_admin_main', '', 5),
('sesblogpackage_admin_main_managepackage', 'sesblogpackage', 'Manage Package', '', '{"route":"admin_default","module":"sesblogpackage","controller":"package", "action":"index"}', 'sesblog_admin_main', '', 6),
('sesblogpackage_admin_main_transaction', 'sesblogpackage', 'Manage Transactions', '', '{"route":"admin_default","module":"sesblogpackage","controller":"package", "action":"manage-transaction"}', 'sesblog_admin_main', '', 7);

-- --------------------------------------------------------

--
-- Table structure for table `engine4_sesblogpackage_packages`
--

DROP TABLE IF EXISTS `engine4_sesblogpackage_packages`;
CREATE TABLE IF NOT EXISTS `engine4_sesblogpackage_packages` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255),
  `description` text,
	`item_count` INT(11) DEFAULT '0',
	`custom_fields` TEXT DEFAULT NULL,
  `member_level` varchar(255) DEFAULT NULL,
  `price` float DEFAULT '0',
  `recurrence` varchar(25) DEFAULT '0',
	`renew_link_days` INT(11) DEFAULT '0',
	`is_renew_link` tinyint(1) DEFAULT '0',
  `recurrence_type` varchar(25) DEFAULT NULL,
  `duration` varchar(25) DEFAULT '0',
  `duration_type` varchar(10) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `params` text DEFAULT NULL,
	`custom_fields_params` TEXT DEFAULT NULL,
	`default` tinyint(1) NOT NULL DEFAULT '0',
	`order` INT(11) NOT NULL DEFAULT '0',
	`highlight` TINYINT(1) NOT NULL DEFAULT '0',
	`show_upgrade` INT(11) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `engine4_sesblogpackage_packages` (`package_id`, `title`, `description`, `member_level`, `price`, `recurrence`, `recurrence_type`, `duration`, `duration_type`, `enabled`, `params`, `default`, `creation_date`, `modified_date`) VALUES (NULL, 'Free Blog Package', NULL, NULL, '0', '0', 'forever', '0', 'forever', '1', '{"is_featured":"1","is_sponsored":"1","is_verified":"1","modules":["photo","review","video","music"]}', '1', 'NOW()', 'NOW()');


-- --------------------------------------------------------

--
-- Table structure for table `engine4_sesblogpackage_transactions`
--
DROP TABLE IF EXISTS `engine4_sesblogpackage_transactions`;
CREATE TABLE IF NOT EXISTS `engine4_sesblogpackage_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
	`order_id` int(11) NOT NULL,
	`orderspackage_id` int(11) NOT NULL,
  `gateway_id` tinyint(1) DEFAULT NULL,
  `gateway_transaction_id` varchar(128) DEFAULT NULL,
	`gateway_parent_transaction_id` varchar(128) DEFAULT NULL,
  `item_count` int(11) NOT NULL DEFAULT '0',
	`gateway_profile_id` VARCHAR(128) DEFAULT NULL,
  `state` enum('pending','cancelled','failed','imcomplete','complete','refund','okay','overdue','initial','active') NOT NULL DEFAULT 'pending',
  `change_rate` float NOT NULL DEFAULT '0',
  `total_amount` float NOT NULL DEFAULT '0',
  `currency_symbol` varchar(45) DEFAULT NULL,
  `gateway_type` varchar(45) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0.0.0.0',
	`expiration_date` datetime NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT = 1 ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_sesblogpackage_orderspackages`
--

CREATE TABLE IF NOT EXISTS `engine4_sesblogpackage_orderspackages` (
  `orderspackage_id` int(11) NOT NULL AUTO_INCREMENT,
	`package_id` int(11) NOT NULL,
  `item_count` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `state` enum('pending','cancelled','failed','imcomplete','complete','refund','okay','overdue','active') NOT NULL DEFAULT 'pending',
  `expiration_date` datetime NOT NULL,
	`ip_address` varchar(45) NOT NULL DEFAULT '0.0.0.0',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`orderspackage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE  `engine4_sesblog_blogs` ADD  `transaction_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE  `engine4_sesblog_blogs` ADD  `existing_package_order` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE  `engine4_sesblog_blogs` ADD  `orderspackage_id` INT(11) NOT NULL DEFAULT '0';