INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('sesgroupalbum', 'Group Album Extension', 'Group Album Extension', '4.8.10', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesgroupalbum', 'sesgroupalbum', 'SES - Group Albums Extension', '', '{"route":"admin_default","module":"sesgroupalbum","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 999),
('sesgroupalbum_admin_main_settings', 'sesgroupalbum', 'Global Settings', '', '{"route":"admin_default","module":"sesgroupalbum","controller":"settings"}', 'sesgroupalbum_admin_main', '', 1),

("sesgroupalbum_admin_main_manage", "sesgroupalbum", "Manage Albums", "", '{"route":"admin_default","module":"sesgroupalbum","controller":"manage"}', "sesgroupalbum_admin_main", "", 2),
("sesgroupalbum_admin_main_photos", "sesgroupalbum", "Manage Photos", "", '{"route":"admin_default","module":"sesgroupalbum","controller":"manage","action":"photos"}', "sesgroupalbum_admin_main", "", 3),

("sesgroupalbum_admin_main_level", "sesgroupalbum", "Member Level Settings", "", '{"route":"admin_default","module":"sesgroupalbum","controller":"level"}', "sesgroupalbum_admin_main", "", 4);


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesgroupalbum_main_home', 'sesgroupalbum', 'Album Home', '', '{"route":"sesgroupalbum_general","action":"home"}', 'group_main', '', 90);