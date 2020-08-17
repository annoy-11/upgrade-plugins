INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('efamilytree', 'Family Tree', 'Family Tree', '4.10.5', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_efamilytree', 'efamilytree', 'SNS - Family Tree', '', '{"route":"admin_default","module":"efamilytree","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('efamilytree_admin_main_settings', 'efamilytree', 'Global Settings', '', '{"route":"admin_default","module":"efamilytree","controller":"settings"}', 'efamilytree_admin_main', '', 1);

DROP TABLE IF EXISTS `engine4_efamilytree_relations`;
CREATE TABLE `engine4_efamilytree_relations` (
  `relation_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  `order` int (11) NOT NULL,
  PRIMARY KEY (`relation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

INSERT IGNORE INTO `engine4_efamilytree_relations` ( `title`,`type`,`order`) VALUES
('Add a Child','child','1'),
('Add Spouse','spouse','2'),
('Add Parent','parent','3');

DROP TABLE IF EXISTS `engine4_efamilytree_relatives`;
CREATE TABLE `engine4_efamilytree_relatives` (
  `relative_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(128) NOT NULL,
  `type` varchar(128) NULL,
  `order` int (11) NOT NULL,
  PRIMARY KEY (`relative_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

INSERT IGNORE INTO `engine4_efamilytree_relatives` ( `title`,`type`,`order`) VALUES
('Father','','1'),
('Mother','','2'),
('Sister','','3'),
('Brother','','4'),
('Son','','5'),
('Daughter','','6');

DROP TABLE IF EXISTS `engine4_efamilytree_users`;
CREATE TABLE `engine4_efamilytree_users` (
  `user_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(128) NOT NULL,
  `owner_id` INT (11) unsigned NOT NULL,
  `parent_id` INT (11) unsigned NOT NULL,
  `spouse_id` INT (11) unsigned NOT NULL,
  `relative_id` INT (11) NOT NULL default '0',
  `site_user_id` INT (11) NOT NULL DEFAULT '0',

  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `dob` varchar (255) NULL ,
  `first_title` varchar(255) NOT NULL,
  `last_title` varchar (255) NULL,
  `gender` varchar (20) NULL,
  `photo_id` INT (11) unsigned NOT NULL default '0',

  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;
