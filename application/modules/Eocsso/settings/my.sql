INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('eocsso', 'SES - SSO OC Server Plugin', '', '4.10.3p7', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
( 'core_admin_main_plugins_eocsso', 'eocsso', 'SSO OC(OpenCart) Server Plugin', '', '{\"route\":\"admin_default\",\"module\":\"eocsso\",\"controller\":\"settings\"}', 'core_admin_main_plugins', '', 1, 0, 800),
( 'eocsso_admin_main_index', 'eocsso', 'Global Settings', '', '{\"route\":\"admin_default\",\"module\":\"eocsso\",\"controller\":\"settings\", \"action\":\"index\"}', 'eocsso_admin_main', '', 1, 0, 1),
( 'eocsso_admin_main_manage', 'eocsso', 'Clients Settings', '', '{\"route\":\"admin_default\",\"module\":\"eocsso\",\"controller\":\"settings\",\"action\":\"manage\"}', 'eocsso_admin_main', '', 1, 0, 2);

DROP TABLE IF EXISTS `engine4_eocsso_clients`;

CREATE TABLE IF NOT EXISTS `engine4_eocsso_clients` (
  `client_id` int(11) UNSIGNED NOT NULL auto_increment,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_secret` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_dir` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `params` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;