INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_settings_seslink', 'seslink', 'SES - External Link and Topic Sharing', '', '{"route":"admin_default","module":"seslink","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 1),

('seslink_admin_main_settings', 'seslink', 'Global Settings', '', '{"route":"admin_default","module":"seslink","controller":"settings","action":"index"}', 'seslink_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("seslink_admin_main_manage", "seslink", "Manage Links", "", '{"route":"admin_default","module":"seslink","controller":"manage"}', "seslink_admin_main", "", 2),

("seslink_admin_main_level", "seslink", "Member Level Settings", "", '{"route":"admin_default","module":"seslink","controller":"level"}', "seslink_admin_main", "", 4),

("seslink_admin_main_managepages", "seslink", "Widgetized Pages", "", '{"route":"admin_default","module":"seslink","controller":"settings", "action":"manage-widgetize-page"}', "seslink_admin_main", "", 999);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_main_seslink', 'seslink', 'Links', '', '{"route":"seslink_general","icon":"fa-link"}', 'core_main', '', 4),

('seslink_main_browse', 'seslink', 'Browse Links', 'Seslink_Plugin_Menus::canViewLinks', '{"route":"seslink_general"}', 'seslink_main', '', 1),

('seslink_main_manage', 'seslink', 'My Links', 'Seslink_Plugin_Menus::canCreateLinks', '{"route":"seslink_general","action":"manage"}', 'seslink_main', '', 2),

('seslink_main_create', 'seslink', 'Post New Link', 'Seslink_Plugin_Menus::canCreateLinks', '{"route":"seslink_general","action":"create"}', 'seslink_main', '', 3);

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
('seslink_main', 'standard', 'SES - External Link and Topic Sharing - Main Navigation Menu');

DROP TABLE IF EXISTS `engine4_seslink_links`;
CREATE TABLE `engine4_seslink_links` (
  `link_id` int(11) unsigned NOT NULL auto_increment,
  `link` VARCHAR(255) NOT NULL,
  `title` varchar(128) NOT NULL,
  `body` longtext NOT NULL,
  `owner_type` varchar(64) NOT NULL,
  `owner_id` int(11) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `view_count` int(11) unsigned NOT NULL default '0',
  `comment_count` int(11) unsigned NOT NULL default '0',
  `like_count` int(11) unsigned NOT NULL default '0',
  `photo_id` int(11) unsigned NOT NULL,
  `search` TINYINT(1) NOT NULL DEFAULT "1",
  PRIMARY KEY (`link_id`),
  KEY `owner_type` (`owner_type`, `owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
('seslink_new', 'seslink', '{item:$subject} post a new link:', 1, 5, 1, 3, 1, 1);

DROP TABLE IF EXISTS `engine4_seslink_recentlyviewitems`;
CREATE TABLE IF NOT EXISTS  `engine4_seslink_recentlyviewitems` (
  `recentlyviewed_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `resource_id` INT NOT NULL ,
  `resource_type` VARCHAR( 65 ) NOT NULL DEFAULT "seslink_link",
  `owner_id` INT NOT NULL ,
  `creation_date` DATETIME NOT NULL,
  UNIQUE KEY `uniqueKey` (`resource_id`,`resource_type`, `owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Dumping data for table `engine4_authorization_permissions`
--

-- ALL
-- auth_view, auth_comment, auth_html
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'auth_view' as `name`,
    5 as `value`,
    '["everyone","owner_network","owner_member_member","owner_member","owner"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'auth_comment' as `name`,
    5 as `value`,
    '["everyone","owner_network","owner_member_member","owner_member","owner"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');

-- ADMIN, MODERATOR
-- create, delete, edit, view, comment, css, style, max
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'delete' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'view' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'comment' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');

-- USER
-- create, delete, edit, view, comment, css, style, max
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'delete' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'comment' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
-- PUBLIC
-- view
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'seslink_link' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('public');
