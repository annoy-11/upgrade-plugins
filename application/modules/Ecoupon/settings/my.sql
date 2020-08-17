INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('ecoupon', 'coupon', 'Ecoupon', '4.10.5', 1, 'extra');

DELETE FROM `engine4_core_menuitems` WHERE `module` = 'ecoupon';
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_ecoupon", "ecoupon", "SNS - Advanced Discount & Coupon Plugin", "", '{"route":"admin_default","module":"ecoupon","controller":"settings"}', "core_admin_main_plugins", "", 999),
("ecoupon_admin_main_setting", "ecoupon", "Global Settings", "", '{"route":"admin_default","module":"ecoupon","controller":"settings"}', "ecoupon_admin_main", "", 1),
("ecoupon_admin_main_creation", "ecoupon", "Creation Settings", "", '{"route":"admin_default","module":"ecoupon","controller":"settings","action":"create"}', "ecoupon_admin_main", "", 2),
("ecoupon_admin_main_level", "ecoupon", "Member Level Settings", "", '{"route":"admin_default","module":"ecoupon","controller":"settings","action":"level"}', "ecoupon_admin_main", "", 3),

-- ("ecoupon_admin_main_create", "ecoupon", "Create New Coupon", "", '{"route":"admin_default","module":"ecoupon","controller":"coupon","action":"create"}', "ecoupon_admin_main", "", 4),

("ecoupon_admin_main_manage", "ecoupon", "Manage Coupon", "", '{"route":"admin_default","module":"ecoupon","controller":"manage"}', "ecoupon_admin_main", "", 4),
("ecoupon_admin_main_faqs", "ecoupon", "Coupon FAQs", "", '{"route":"admin_default","module":"ecoupon","controller":"settings","action":"coupon-faqs"}', "ecoupon_admin_main", "", 5),
("ecoupon_main_browse", "ecoupon", "Coupon", "Ecoupon_Plugin_Menus::browseCoupon", '{"route":"ecoupon_general","action":"browse"}', "core_main", "", 5);

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
("ecoupon_main", "standard", "SNS - Advanced Discount & Coupon Plugin");

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("ecoupon_main_menubrowse", "ecoupon", "Browse Coupon", "", '{"route":"ecoupon_general","action":"browse"}', "ecoupon_main", "", 1),
("ecoupon_main_manage", "ecoupon", "Manage Coupons", "", '{"route":"ecoupon_general","action":"manage"}', "ecoupon_main", "", 2),
("courses_main_couponfqa", "ecoupon", "Coupon FAQs", "", '{"route":"ecoupon_general","action":"coupon-faqs"}', "ecoupon_main", "", 4);

DROP TABLE IF EXISTS `engine4_ecoupon_coupons`;
CREATE TABLE `engine4_ecoupon_coupons` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY , 
  `owner_id` int(11) NOT NULL,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `coupon_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `photo_id` int(11) NOT NULL,
  `total_coupons` INT(8) NOT NULL DEFAULT '0',
  `discount_type` tinyint(1) NOT NULL,
  `fixed_discount_value` DECIMAL(16,2) NOT NULL DEFAULT '0',
  `percentage_discount_value` DECIMAL(16,2) NOT NULL DEFAULT '0',
  `minimum_purchase_amount` DECIMAL(16,2) NOT NULL DEFAULT '0',
  `discount_end_type` tinyint(2) NOT NULL,
  `discount_start_time` datetime NOT NULL,
  `discount_end_time` datetime NOT NULL,
  `count_per_coupon` INT(8) NOT NULL DEFAULT '0',
  `count_per_buyer` INT(8) NOT NULL DEFAULT '0',
  `remaining_coupon` INT(8) NOT NULL DEFAULT '0',
  `resource_id` VARCHAR(64) NOT NULL,
  `resource_type` VARCHAR(32) NOT NULL,
  `item_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `is_package` tinyint(1) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `comment_count` int(11) NOT NULL DEFAULT 0,
  `like_count` int(11) NOT NULL DEFAULT 0,
  `favourite_count` tinyint(11) NOT NULL DEFAULT "0",
  `creation_date` datetime NOT NULL,
  `draft` tinyint(1) unsigned NOT NULL DEFAULT "0",
  `public` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(64) NOT NULL DEFAULT "0.0.0.0",
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) NOT NULL DEFAULT 1,
  `verified` tinyint(1) NOT NULL DEFAULT "0",
  `sponsored` tinyint(1) NOT NULL DEFAULT 1,
  `hot` tinyint(1) NOT NULL DEFAULT 1,
  `offtheday` tinyint(1) NOT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Favourites Table */
DROP TABLE IF EXISTS `engine4_ecoupon_favourites`;
CREATE TABLE IF NOT EXISTS `engine4_ecoupon_favourites` (
    `favourite_id` int(11) unsigned NOT NULL auto_increment,
    `resource_type` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `resource_id` int(11) unsigned NOT NULL,
    `owner_id` int(11) unsigned NOT NULL,
    `creation_date` datetime NOT NULL,
    PRIMARY KEY  (`favourite_id`),
    KEY `resource_type` (`resource_type`, `resource_id`),
    KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `engine4_ecoupon_types`;
CREATE TABLE `engine4_ecoupon_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `title` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `item_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `is_package` tinyint(1) NOT NULL DEFAULT 0,
  `module_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `engine4_ecoupon_ordercoupons`;
CREATE TABLE `engine4_ecoupon_ordercoupons` (
  `ordercoupon_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `resource_type` varchar(32) COLLATE utf8_unicode_ci NULL DEFAULT '',
  `resource_id` int(11) NULL DEFAULT 0,
  `is_package` tinyint(1) NOT NULL DEFAULT "0",
  `package_type` varchar(32) COLLATE utf8_unicode_ci NULL DEFAULT '',
  `package_id` int(11) NULL DEFAULT 0,
  `discount_amount` int(11) NULL DEFAULT 0,
  `params` TEXT NULL DEFAULT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('All', 'all', '','');

INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Business Directories - Packages for Allowing Business Creation Extension', 'sesbusinesspackage_package', '1','sesbusinesspackage');

INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Page Directories - Packages for Allowing Page Creation Extension', 'sespagepackage_package', '1','sespagepackage');

INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Store Directories Plugin - Packages for Allowing Store Creation Extension', 'estorepackage_package', '1','estorepackage');

INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Community Advertisements Plugin', 'sescommunityads_packages', '1','sescommunityads');

INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Advanced Contests - Packages for Allowing Contest Creation Plugin', 'sescontestpackage_package', '1','sescontestpackage');

INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Group Communities - Packages for Allowing Group Creation Extension', 'sesgrouppackage_package', '1','sesgrouppackage');
INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Advanced Contests Plugin', 'contest', '0','sescontestjoinfees');
INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('Credit ', 'sescredit', '0','sescredit');
INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Advanced Events Plugin ', 'sesevent_event', '0','seseventticket');
INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('SES - Stores Marketplace Plugin ', 'stores', '0','estore');
INSERT IGNORE INTO `engine4_ecoupon_types` (`title`, `item_type`, `is_package`,`module_name`) VALUES ('Courses - Learning Management System ', 'classroom', '0','eclassroom');

ALTER TABLE `engine4_payment_transactions` ADD `ordercoupon_id` INT NULL DEFAULT '0';

ALTER TABLE `engine4_ecoupon_coupons` ADD `item_ids` VARCHAR(512) NULL;;
