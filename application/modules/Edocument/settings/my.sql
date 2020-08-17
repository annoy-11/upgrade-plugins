INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES 
("edocument_new", "edocument", '{item:$subject} create a new document entry {item:$object}', 1, 5, 1, 3, 1, 1), ("comment_edocument", "edocument", '{item:$subject} commented on {item:$owner}''s {item:$object:document entry}: {body:$body}', 1, 1, 1, 1, 1, 0),
("edocument_like", "edocument", '{item:$subject} likes the document {item:$object}:', 1, 7, 1, 1, 1, 1),
("edocument_favourite", "edocument", '{item:$subject} added document {item:$object} to favorite:', 1, 7, 1, 1, 1, 1);

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("edocument_email_document", "edocument", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description],[subject],[message],[document_link]");

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
("edocument_main", "standard", "SES - Document Sharing - Main Navigation Menu"),
("edocument_quick", "standard", "SES - Document Sharing - Quick Navigation Menu"),
("edocument_gutter", "standard", "SES - Document Sharing - Gutter Navigation Menu");

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_edocument', 'edocument', 'SES - Documents Sharing', '', '{"route":"admin_default","module":"edocument","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('edocument_admin_main_settings', 'edocument', 'Global Settings', '', '{"route":"admin_default","module":"edocument","controller":"settings"}', 'edocument_admin_main', '', 1),
("edocument_admin_main_manage", "edocument", "Manage Documents", "", '{"route":"admin_default","module":"edocument","controller":"manage"}', "edocument_admin_main", "", 2),
("edocument_admin_main_level", "edocument", "Member Level Settings", "", '{"route":"admin_default","module":"edocument","controller":"level"}', "edocument_admin_main", "", 3),
("edocument_admin_main_categories", "edocument", "Categories", "", '{"route":"admin_default","module":"edocument","controller":"categories","action":"index"}', "edocument_admin_main", "", 4),
("edocument_admin_main_subcategories", "edocument", "Categories", "", '{"route":"admin_default","module":"edocument","controller":"categories","action":"index"}', "edocument_admin_categories", "", 1),
("edocument_admin_main_subfields", "edocument", "Form Questions", "", '{"route":"admin_default","module":"edocument","controller":"fields"}', "edocument_admin_categories", "", 2),
("edocument_admin_main_statistic", "edocument", "Statistics", "", '{"route":"admin_default","module":"edocument","controller":"settings","action":"statistic"}', "edocument_admin_main", "", 7),
("edocument_admin_main_managedocuments", "edocument", "Widgetized Pages", "", '{"route":"admin_default","module":"edocument","controller":"settings", "action":"manage-widgetize-page"}', "edocument_admin_main", "", 999),

("core_main_edocument", "edocument", "Documents", "", '{"route":"edocument_general", "action":"home"}', "core_main", "", 4),
("edocument_main_browsehome", "edocument", "Document Home", "", '{"route":"edocument_general","action":"home"}', "edocument_main", "", 1),
("edocument_main_browsecategory", "edocument", "Browse Categories", "", '{"route":"edocument_category"}', "edocument_main", "", 3),
("edocument_main_browse", "edocument", "Browse Documents", "Edocument_Plugin_Menus::canViewEdocuments", '{"route":"edocument_general","action":"browse"}', "edocument_main", "", 2),
("edocument_main_manage", "edocument", "Manage Documents", "", '{"route":"edocument_general","action":"manage"}', "edocument_main", "", 7),
("edocument_main_create", "edocument", "Create New Document", "Edocument_Plugin_Menus::canCreateEdocuments", '{"route":"edocument_general","action":"create"}', "edocument_main", "", 8),
("edocument_quick_create", "edocument", "Create New Document", "Edocument_Plugin_Menus::canCreateEdocuments", '{"route":"edocument_general","action":"create","class":"buttonlink icon_edocument_new"}', "edocument_quick", "", 1),

("edocument_gutter_dashboard", "edocument", "Dashboard", "Edocument_Plugin_Menus", '{"route":"edocument_dashboard","action":"edit","class":"buttonlink icon_edocument_edit"}', "edocument_gutter", "", 1),

("edocument_gutter_delete", "edocument", "Delete Document", "Edocument_Plugin_Menus", '{"route":"edocument_specific","action":"delete","class":"buttonlink smoothbox icon_edocument_delete"}', "edocument_gutter", "", 2),

("edocument_gutter_download", "edocument", "Download Document", "Edocument_Plugin_Menus", '{"route":"edocument_dashboard","action":"download","class":"buttonlink icon_edocument_download"}', "edocument_gutter", "", 3),

("edocument_gutter_email", "edocument", "Email Document", "Edocument_Plugin_Menus", '{"route":"edocument_dashboard","action":"email","class":"buttonlink icon_edocument_email"}', "edocument_gutter", "", 4),

("edocument_gutter_share", "edocument", "Share", "Edocument_Plugin_Menus", '{"route":"default","module":"activity","controller":"index","action":"share","class":"buttonlink smoothbox icon_comments"}', "edocument_gutter", "", 6),

("edocument_gutter_report", "edocument", "Report", "Edocument_Plugin_Menus", '{"route":"default","module":"core","controller":"report","action":"create","class":"buttonlink smoothbox icon_report"}', "edocument_gutter", "", 7);


DROP TABLE IF EXISTS `engine4_edocument_categories`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_categories` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `category_name` varchar(128) NOT NULL,
  `description` text,
  `order` int(11) NOT NULL DEFAULT "0",
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `subcat_id` int(11) DEFAULT "0",
  `subsubcat_id` int(11) DEFAULT "0",
  `thumbnail` int(11) NOT NULL DEFAULT "0",
  `cat_icon` int(11) NOT NULL DEFAULT "0",
  `colored_icon` int(11) NOT NULL,
  `color` varchar(16) DEFAULT NULL,
  `profile_type_review` int(11) DEFAULT NULL,
  `profile_type` int(11) DEFAULT NULL,
  `member_levels` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `engine4_edocument_fields_maps`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_fields_maps` (
  `field_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`field_id`,`option_id`,`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT IGNORE INTO `engine4_edocument_fields_maps` (`field_id`, `option_id`, `child_id`, `order`) VALUES (0, 0, 1, 1);

DROP TABLE IF EXISTS `engine4_edocument_fields_meta`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_fields_meta` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(24) NOT NULL,
  `label` varchar(64) NOT NULL,
  `description` varchar(128) NOT NULL DEFAULT "",
  `alias` varchar(32) NOT NULL DEFAULT "",
  `required` tinyint(1) NOT NULL DEFAULT "0",
  `display` tinyint(1) unsigned NOT NULL,
  `publish` tinyint(1) unsigned NOT NULL DEFAULT "0",
  `search` tinyint(1) unsigned NOT NULL DEFAULT "0",
  `show` tinyint(1) unsigned DEFAULT "0",
  `order` smallint(3) unsigned NOT NULL DEFAULT "999",
  `config` text NOT NULL,
  `validators` text,
  `filters` text,
  `style` text,
  `error` text,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

INSERT IGNORE INTO `engine4_edocument_fields_meta` (`field_id`, `type`, `label`, `description`, `alias`, `required`, `display`, `publish`, `search`, `show`, `order`, `config`, `validators`, `filters`, `style`, `error`) VALUES (1, "profile_type", "Profile Type", "", "profile_type", 1, 0, 0, 2, 0, 999, "", NULL, NULL, NULL, NULL);

DROP TABLE IF EXISTS `engine4_edocument_fields_options`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_fields_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT "999",
  PRIMARY KEY (`option_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT IGNORE INTO `engine4_edocument_fields_options` (`option_id`, `field_id`, `label`, `order`) VALUES (1, 1, "Rock Documents", 0);

DROP TABLE IF EXISTS `engine4_edocument_fields_search`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_fields_search` (
  `item_id` int(11) NOT NULL,
  `profile_type` smallint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `profile_type` (`profile_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `engine4_edocument_fields_values`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_fields_values` (
  `item_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `index` smallint(3) NOT NULL DEFAULT "0",
  `value` text NOT NULL,
  PRIMARY KEY (`item_id`,`field_id`,`index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

DROP TABLE IF EXISTS `engine4_edocument_documents`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_documents` (
  `edocument_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `body` longtext NOT NULL,
  `custom_url` varchar(255) NOT NULL,
  `photo_id` int(11) DEFAULT "0",
  `owner_type` varchar(16) NOT NULL,
  `owner_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL DEFAULT "0",
  `subcat_id` int(11) DEFAULT "0",
  `subsubcat_id` int(11) DEFAULT "0",
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `publish_date` varchar(64) NOT NULL,
  `starttime` varchar(64) NOT NULL,
  `endtime` varchar(64) NOT NULL,
  `view_count` int(11) unsigned NOT NULL DEFAULT "0",
  `comment_count` int(11) unsigned NOT NULL DEFAULT "0",
  `like_count` int(11) unsigned NOT NULL DEFAULT "0",
  `featured` tinyint(1) NOT NULL DEFAULT "0",
  `sponsored` tinyint(1) NOT NULL DEFAULT "0",
  `verified` tinyint(1) NOT NULL DEFAULT "0",
  `is_approved` tinyint(1) NOT NULL DEFAULT "1",
  `ip_address` varchar(28) NOT NULL DEFAULT "0.0.0.0",
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` text,
  `favourite_count` tinyint(11) NOT NULL DEFAULT "0",
  `offtheday` tinyint(1) NOT NULL,
  `rating` float NOT NULL,
  `search` tinyint(1) NOT NULL DEFAULT "1",
  `draft` tinyint(1) unsigned NOT NULL DEFAULT "0",
  `is_publish` tinyint(1) NOT NULL DEFAULT "0",
  `networks` VARCHAR(255) NULL,
  `levels` VARCHAR(255) NULL,
  `status` TINYINT(1) NOT NULL DEFAULT "0",
  `folder_id_google` VARCHAR(255) NULL DEFAULT NULL,
  `file_id_google` VARCHAR(255) NULL DEFAULT NULL,
  `download` TINYINT(1) NOT NULL DEFAULT "1",
  `attachment` TINYINT(1) NOT NULL DEFAULT "1",
  `file_type` VARCHAR(16) NULL,
  `file_id` INT(11) NOT NULL DEFAULT "0",
  PRIMARY KEY (`edocument_id`),
  KEY `owner_type` (`owner_type`,`owner_id`),
  KEY `search` (`search`,`creation_date`),
  KEY `owner_id` (`owner_id`,`draft`),
  KEY `draft` (`draft`,`search`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `engine4_edocument_favourites`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_favourites` (
  `favourite_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `resource_type` varchar(16) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY (`favourite_id`),
  KEY `user_id` (`user_id`,`resource_type`,`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `engine4_edocument_dashboards` ;
CREATE TABLE `engine4_edocument_dashboards` (
  `dashboard_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(64) NOT NULL,
  `title` varchar(64) NOT NULL,
  `enabled` tinyint(1) NOT NULL default "1",
  `main` tinyint(1) NOT NULL default "0",
  PRIMARY KEY (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT IGNORE INTO `engine4_edocument_dashboards` (`type`, `title`, `enabled`, `main`) VALUES
("manage_document", "Manage Document", "1", "1"),
("edit_document", "Edit Document", "1", "0"),
("edit_photo", "Edit Photo", "1", "0"),
("seo", "Seo Details", "1", "0");

DROP TABLE IF EXISTS `engine4_edocument_ratings`;
CREATE TABLE IF NOT EXISTS `engine4_edocument_ratings` (
  `edocument_id` int(10) unsigned NOT NULL,
  `user_id` int(9) unsigned NOT NULL,
  `rating` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`edocument_id`,`user_id`),
  KEY `INDEX` (`edocument_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("edocument_like", "edocument", '{item:$subject} has liked your document {item:$object}.', 0, ""),
("edocument_favourite", "edocument", '{item:$subject} has favourited your document {item:$object}.', 0, ""),
("edocument_adminapproved", "edocument", 'Your document {item:$object} has been approved.', 0, ""),
("edocument_admindisapproved", "edocument", 'Your document {item:$object} has been disapproved.', 0, ""),
("edocument_waitingadminapproval", "edocument", 'New document {item:$object} has been created and is waiting for admin approval.', 0, ""),
("edocument_waitingapproval", "edocument", 'Your document {item:$object} has been created and is waiting for admin approval.', 0, ""),
("edocument_rate", "edocument", '{item:$subject} has rated your document {item:$object}.', 0, "");


INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("notify_edocument_adminapproval", "edocument", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description],[adminmanage_link]"),
("notify_edocument_documentsentforapproval", "edocument", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description],[adminmanage_link],[document_title]"),
("notify_edocument_approvedbyadmin", "edocument", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description],[edocument_title]"),
("notify_edocument_disapprovedbyadmin", "edocument", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description],[edocument_title]");
