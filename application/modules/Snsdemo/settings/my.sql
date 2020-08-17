
DROP TABLE IF EXISTS `engine4_snsdemo_themes`;
CREATE TABLE `engine4_snsdemo_themes` (
  `theme_id` int(11) NOT NULL auto_increment,
  `theme_name` varchar(128) NOT NULL,
  `demolink` varchar(128) NOT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

DROP TABLE IF EXISTS `engine4_snsdemo_services`;
CREATE TABLE `engine4_snsdemo_services` (
  `service_id` int(11) NOT NULL auto_increment,
  `service_name` varchar(128) NOT NULL,
  `servicelink` varchar(128) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_snsdemo', 'snsdemo', 'SNS Demo', '', '{"route":"admin_default","module":"snsdemo","controller":"settings", "action":"themes"}', 'core_admin_main_plugins', '', 999),

('snsdemo_admin_main_themes', 'snsdemo', 'Manage Themes', '', '{"route":"admin_default","module":"snsdemo","controller":"settings", "action":"themes"}', 'snsdemo_admin_main', '', 4),

('snsdemo_admin_main_services', 'snsdemo', 'Manage Services', '', '{"route":"admin_default","module":"snsdemo","controller":"settings", "action":"services"}', 'snsdemo_admin_main', '', 5);
