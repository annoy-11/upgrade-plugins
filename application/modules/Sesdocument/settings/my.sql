INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('sesdocument', 'SES - Documents Sharing Plugin', '', '4.10.0', 1, 'extra') ;


INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
('sesdocument_main', 'standard', 'Document Sharing Main Navigation Menu');

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesdocument_admin_main_plugin', 'sesdocument', 'SES - Documents Sharing Plugin', '', '{"route":"admin_default","module":"sesdocument","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 999),

('sesdocument_admin_main_settings', 'sesdocument', 'Global Settings', '', '{"route":"admin_default","module":"sesdocument","controller":"settings","action":"index"}', 'sesdocument_admin_main', '', 1),
('sesdocument_admin_main_level', 'sesdocument', 'Member Level Settings', '', '{"route":"admin_default","module":"sesdocument","controller":"settings","action":"level"}', 'sesdocument_admin_main', '', 2),
('sesdocument_admin_main_category', 'sesdocument', 'Browse Categories', '', '{"route":"admin_default","module":"sesdocument","controller":"categories","action":"index"}', 'sesdocument_admin_main', '', 3),
('sesdocument_admin_main_manage', 'sesdocument', 'Manage Documents', '', '{"route":"admin_default","module":"sesdocument","controller":"manage"}', 'sesdocument_admin_main', '', 4),
('sesdocument_admin_main_statistics', 'sesdocument', 'Statistics', '', '{"route":"admin_default","module":"sesdocument","controller":"settings","action":"statistics"}', 'sesdocument_admin_main', '', 5),
('sesdocument_admin_main_widget', 'sesdocument', 'Widgetize Pages', '', '{"route":"admin_default","module":"sesdocument","controller":"settings","action":"widget"}', 'sesdocument_admin_main', '', 6),
('sesdocument_admin_main_help', 'sesdocument', 'Help', '', '{"route":"admin_default","module":"sesdocument","controller":"settings","action":"help"}', 'sesdocument_admin_main', '', 7),
('sesdocument_admin_main_subcategories', 'sesdocument', 'Categories & Mapping', '', '{"route":"admin_default","module":"sesdocument","controller":"categories","action":"index"}', 'sesdocument_admin_categories', '', 1),
('sesdocument_admin_main_subfields', 'sesdocument', 'Form Questions', '', '{"route":"admin_default","module":"sesdocument","controller":"fields"}', 'sesdocument_admin_categories', '', 2),
('core_sitemap_sesdocument', 'sesdocument', 'Documents', '', '{"route":"sesdocument_general"}', 'core_sitemap', '',   4),
('core_main_sesdocument', 'sesdocument', 'Documents', '', '{"route":"sesdocument_general","action":"home"}', 'core_main', '',   4),

('sesdocument_main_home', 'sesdocument', 'Documents Home', '', '{"route":"sesdocument_general","action":"home"}', 'sesdocument_main', '',   1),
('sesdocument_main_browse', 'sesdocument', 'Browse Documents', '', '{"route":"sesdocument_general","action":"browse"}', 'sesdocument_main', '',   1),
('sesdocument_main_manage', 'sesdocument', 'My Documents', '', '{"route":"sesdocument_general","action":"manage"}', 'sesdocument_main', '',   1),
('sesdocument_main_categories', 'sesdocument', 'Categories', '', '{"route":"sesdocument_category","controller":"category","action":"browse"}', 'sesdocument_main', '',   1),
('sesdocument_main_create', 'sesdocument', 'Create Document', 'Sesdocument_Plugin_Menus', '{"route":"sesdocument_general","action":"create"}', 'sesdocument_main', '',   1),
('sesdocument_quick_create', 'sesdocument', 'Create Document', 'Sesdocument_Plugin_Menus::canCreateDocuments', '{"route":"sesdocument_general","action":"create"}', 'sesdocument_quick', '', 1);




DROP TABLE IF EXISTS `engine4_sesdocument_categories` ;
			
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_categories` (
	`category_id` int(11) unsigned NOT NULL auto_increment,
	`slug` varchar(255) NOT NULL,
	`category_name` varchar(128) NOT NULL,
	`subcat_id` int(11)  NULL DEFAULT 0,
	`subsubcat_id` int(11)  NULL DEFAULT 0,
	`title` varchar(255) DEFAULT NULL,
	`description` text ,
	`color` VARCHAR(255) ,
	`member_levels` VARCHAR(255),
	`thumbnail` int(11) NOT NULL DEFAULT 0,
	`cat_icon` int(11) NOT NULL DEFAULT 0,
	`colored_icon` int(11) NOT NULL DEFAULT 0,
	`order` int(11) NOT NULL DEFAULT 0,
	`profile_type_review` int(11) DEFAULT NULL,
	`profile_type` int(11) DEFAULT NULL,
	`creation_date` datetime NOT NULL,
	`modified_date` datetime NOT NULL,
	PRIMARY KEY (`category_id`),
	KEY `category_id` (`category_id`,`category_name`),
	KEY `category_name` (`category_name`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `engine4_sesdocument_sesdocuments`;
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_sesdocuments` (
	`sesdocument_id` int(11) unsigned NOT NULL auto_increment,
	`user_id` int(11) NOT NULL,
	`title` varchar(255) NOT NULL,
	`custom_url` varchar(255) NOT NULL,
	`description` text  NULL,
	`category_id` int(11) NOT NULL DEFAULT "0",
	`subcat_id` int(11) NOT NULL DEFAULT "0",
	`subsubcat_id` int(11) NOT NULL DEFAULT "0",
	`extension` varchar(45) DEFAULT NULL,	
	`highlight` TINYINT(1) NOT NULL DEFAULT "0",
	`attachment` TINYINT(1) NOT NULL DEFAULT "0",
	`download` TINYINT(1) NOT NULL DEFAULT "0",
	`file_id` int(11) NOT NULL DEFAULT "0",
	`photo_id` int(11) NOT NULL DEFAULT "0",
	`auth_view` varchar(45) NOT NULL ,			
	`search` TINYINT(1) NOT NULL DEFAULT "1",
	`status` tinyint(1) NOT NULL DEFAULT "0",
	`draft` tinyint(1) NOT NULL DEFAULT "0",			
	`view_count` int(10) unsigned NOT NULL,
	`like_count` int(11) unsigned NOT NULL,
	`rating` int(11) unsigned NOT NULL,
	`comment_count` int(11) unsigned NOT NULL,
	`favourite_count` int(11) unsigned NOT NULL,
	`featured` TINYINT(1) NOT NULL DEFAULT "0",
	`sponsored` TINYINT(1) NOT NULL DEFAULT "0",
	`verified` TINYINT(1) NOT NULL DEFAULT "0",
	`offtheday` tinyint(1) NOT NULL,
	`startdate` date DEFAULT NULL,
	`enddate` date DEFAULT NULL,
	`ip_address` varchar(55) NOT NULL DEFAULT "0.0.0.0",
	`is_approved` TINYINT(1) NOT NULL DEFAULT "1",
  `is_delete` TINYINT(1) NOT NULL DEFAULT "1",
	`creation_date` datetime NOT NULL,
	`modified_date` datetime NOT NULL,
	PRIMARY KEY (`sesdocument_id`),
	KEY `user_id` (`user_id`),
	KEY `search` (`search`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `engine4_sesdocument_fields_options`;
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_fields_options` (
        `option_id` int(11) NOT NULL AUTO_INCREMENT,
	`field_id` int(11) NOT NULL,
	`label` varchar(255) NOT NULL,
	`order` smallint(6) NOT NULL DEFAULT "999",
	PRIMARY KEY (`option_id`),
	KEY `field_id` (`field_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
	INSERT IGNORE INTO `engine4_sesdocument_fields_options` (`option_id`, `field_id`, `label`, `order`) VALUES (1, 1, "Document", 0);


DROP TABLE IF EXISTS `engine4_sesdocument_fields_search`;
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_fields_search` (
	`item_id` int(11) NOT NULL,
	`profile_type` smallint(11) unsigned DEFAULT NULL,
	 PRIMARY KEY (`item_id`),
	 KEY `profile_type` (`profile_type`)
	 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `engine4_sesdocument_fields_values`;
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_fields_values` (
	`item_id` int(11) NOT NULL,
	`field_id` int(11) NOT NULL,
	`index` smallint(3) NOT NULL DEFAULT "0",
	`value` text NOT NULL,
	PRIMARY KEY (`item_id`,`field_id`,`index`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `engine4_sesdocument_fields_meta`;
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_fields_meta` (
        `field_id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(24) NOT NULL,
	`label` varchar(64) NOT NULL,
	`description` varchar(255) NOT NULL DEFAULT "",
	`alias` varchar(32) NOT NULL DEFAULT "",
	`required` tinyint(1) NOT NULL DEFAULT "0",
	`display` tinyint(1) unsigned NOT NULL,
	`publish` tinyint(1) unsigned NOT NULL DEFAULT "0",
	`search` tinyint(1) unsigned NOT NULL DEFAULT "0",
	`show` tinyint(1) unsigned DEFAULT "0",
	`order` smallint(3) unsigned NOT NULL DEFAULT "999",
	`config` text NOT NULL,
	`validators` text COLLATE utf8_unicode_ci,
	`filters` text COLLATE utf8_unicode_ci,
	`style` text COLLATE utf8_unicode_ci,
	`error` text COLLATE utf8_unicode_ci,
	PRIMARY KEY (`field_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

	INSERT IGNORE INTO `engine4_sesdocument_fields_meta` (`field_id`, `type`, `label`, `description`, `alias`, `required`, `display`, `publish`, `search`, `show`, `order`,   `config`, `validators`,    `filters`, `style`, `error`) VALUES
	(1, "profile_type", "Profile Type", "", "profile_type", 1, 0, 0, 2, 0, 999, "", NULL, NULL, NULL, NULL);


DROP TABLE IF EXISTS `engine4_sesdocument_fields_maps`;
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_fields_maps` (
        `field_id` int(11) NOT NULL,
        `option_id` int(11) NOT NULL,
	`child_id` int(11) NOT NULL,
	`order` smallint(6) NOT NULL,
	PRIMARY KEY (`field_id`,`option_id`,`child_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	INSERT IGNORE INTO `engine4_sesdocument_fields_maps` (`field_id`, `option_id`, `child_id`, `order`) VALUES (0, 0, 1, 1);


		DROP TABLE IF EXISTS `engine4_sesdocument_membership`;
			CREATE TABLE IF NOT EXISTS `engine4_sesdocument_membership` (
			  `resource_id` int(11) unsigned NOT NULL,
			  `user_id` int(11) unsigned NOT NULL,
			  `active` tinyint(1) NOT NULL default "0",
			  `resource_approved` tinyint(1) NOT NULL default "0",
			  `user_approved` tinyint(1) NOT NULL default "0",
			  `message` text NULL,
			  `rsvp` tinyint(3) NOT NULL default "3",
			  `title` text NULL,
			  PRIMARY KEY  (`resource_id`, `user_id`),
			  KEY `REVERSE` (`user_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;




DROP TABLE IF EXISTS `engine4_sesdocument_favourites`;
			CREATE TABLE IF NOT EXISTS `engine4_sesdocument_favourites` (
			  `favourite_id` int(11) unsigned NOT NULL auto_increment,
			  `user_id` int(11) unsigned NOT NULL,
			  `resource_type` varchar(128) NOT NULL,
			  `resource_id` int(11) NOT NULL,
			  PRIMARY KEY (`favourite_id`),
			  KEY `user_id` (`user_id`,`resource_type`,`resource_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;




 DROP TABLE IF EXISTS `engine4_sesdocument_recentlyviewitems`;
             CREATE TABLE IF NOT EXISTS  `engine4_sesdocument_recentlyviewitems` (
      		`recentlyviewed_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
      		`resource_id` INT NOT NULL ,
      		`resource_type` VARCHAR(64) NOT NULL DEFAULT "sesdocument",
      		`owner_id` INT NOT NULL ,
      		`creation_date` DATETIME NOT NULL,
      		UNIQUE KEY `uniqueKey` (`resource_id`,`resource_type`, `owner_id`)
      		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;




INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
('sesdocument_create', 'sesdocument', '{item:$subject} created a new Document {item:$object}.', 1, 5, 1, 3, 1, 1),
('sesdocument_like', 'sesdocument', '{item:$subject}  likes a Document {item:$object}.', 1, 1, 1, 3, 3, 0),
('sesdocument_rated', 'sesdocument', '{item:$subject}  post rating on a Document {item:$object}.', 1, 1, 1, 3, 3, 0),
('sesdocument_favourite', 'sesdocument', '{item:$subject}  marks a Document {item:$object} as favourite.', 1, 1, 1, 3, 3, 0);





INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
('sesdocument_waiting_approval', 'sesdocument', 'A New Document {item:$object} is waiting for your approval.', 0, ''),
('sesdocument_adminapproved', 'sesdocument', 'Your Document {item:$object} has been approved.', 0, ''),
('sesdocument_admindisapproved', 'sesdocument', 'Your Document {item:$object} has been disapproved.', 0, ''),
('sesdocument_like_sesdocument_document', 'sesdocument', '{item:$subject}  likes your Document {item:$object}.', 0, ''),
('sesdocument_favourite_sesdocument_document', 'sesdocument', '{item:$subject} marked your Document {item:$object}  as favourite.', 0, ''),
('sesdocument_comment_document', 'sesdocument', '{item:$subject} commented on your {item:$object}.', 0, ''),
('sesdocument_rated_document', 'sesdocument', '{item:$subject}   rates on your Document  {item:$object}.', 0, '');




INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
('sesdocument_waiting_approval', 'sesdocument', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_sesdocument_document_approvedbyadmin', 'sesdocument', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_sesdocument_document_disapprovedbyadmin', 'sesdocument', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_sesdocument_document_documentliked', 'sesdocument', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('sesdocument_rated_document', 'sesdocument', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]');





ALTER TABLE `engine4_sesdocument_sesdocuments` ADD `folder_id_google` VARCHAR(255) NULL DEFAULT NULL, ADD `file_id_google` VARCHAR(255) NULL DEFAULT NULL;


DROP TABLE IF EXISTS `engine4_sesdocument_ratings`;
CREATE TABLE IF NOT EXISTS `engine4_sesdocument_ratings` (
  `sesdocument_id` int(10) unsigned NOT NULL,
  `user_id` int(9) unsigned NOT NULL,
  `rating` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`sesdocument_id`,`user_id`),
  KEY `INDEX` (`sesdocument_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;








