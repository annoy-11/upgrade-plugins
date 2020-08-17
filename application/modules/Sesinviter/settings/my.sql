INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesinviter', 'sesinviter', 'SES - Social Friends Inviter & Contact Importer', '', '{"route":"admin_default","module":"sesinviter","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesinviter_admin_main_settings', 'sesinviter', 'Global Settings', '', '{"route":"admin_default","module":"sesinviter","controller":"settings"}', 'sesinviter_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesinviter_admin_main_managewidgetizepage", "sesinviter", "Widgetized Pages", "", '{"route":"admin_default","module":"sesinviter","controller":"settings", "action":"manage-widgetize-page"}', "sesinviter_admin_main", "", 666);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesinviter_admin_main_manage", "sesinviter", "Manage Invites", "", '{"route":"admin_default","module":"sesinviter","controller":"manage"}', "sesinviter_admin_main", "", 2);


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_main_sesinviter', 'sesinviter', 'Invites', '', '{"route":"sesinviter_general", "action":"manage","icon":"fa-pencil"}', 'core_main', '', 999),
('sesinviter_main_inviterpage', 'sesinviter', 'Invites', '', '{"route":"sesinviter_general","action":"invite"}', 'sesinviter_main', '', 1),
('sesinviter_main_manage', 'sesinviter', 'My Invites', 'Sesinviter_Plugin_Menus::canCreateInvites', '{"route":"sesinviter_general","action":"manage"}', 'sesinviter_main', '', 2),
('sesinviter_main_managereferrals', 'sesinviter', 'My Referrals', 'Sesinviter_Plugin_Menus::canCreateInvites', '{"route":"sesinviter_general","action":"manage-referrals"}', 'sesinviter_main', '', 3);

DROP TABLE IF EXISTS `engine4_sesinviter_introduces`;
CREATE TABLE `engine4_sesinviter_introduces` (
  `introduce_id` int(11) unsigned NOT NULL auto_increment,
  `description` text NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`introduce_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

DROP TABLE IF EXISTS `engine4_sesinviter_affiliates`;
CREATE TABLE `engine4_sesinviter_affiliates` (
  `affiliate_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `affiliate` varchar(256) NOT NULL,
  `affiliates_count` INT(11) NOT NULL,
PRIMARY KEY (`affiliate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;
