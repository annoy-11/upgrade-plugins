INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesfbstyle_admin_main_styling", "sesfbstyle", "Color Schemes", "", '{"route":"admin_default","module":"sesfbstyle","controller":"settings", "action":"styling"}', "sesfbstyle_admin_main", "", 5);

DROP TABLE IF EXISTS `engine4_sesfbstyle_customthemes`;
CREATE TABLE IF NOT EXISTS `engine4_sesfbstyle_customthemes` (
  `customtheme_id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`customtheme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14;

ALTER TABLE `engine4_sesfbstyle_customthemes` ADD `default` TINYINT(1) NOT NULL DEFAULT "1";