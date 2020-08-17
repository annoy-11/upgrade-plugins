INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('seseventmusic', 'Advanced Event Music Extension', 'Advanced Event Music Extension', '4.8.9', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seseventmusic', 'seseventmusic', 'SES - Advanced Events - Music Extension', '', '{"route":"admin_default","module":"seseventmusic","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('seseventmusic_admin_main_settings', 'seseventmusic', 'Settings', '', '{"route":"admin_default","module":"seseventmusic","controller":"settings"}', 'seseventmusic_admin_main', '', 1),
('seseventmusic_admin_main_subglobalsettings', 'seseventmusic', 'Global Settings', '', '{"route":"admin_default","module":"seseventmusic","controller":"settings"}', 'seseventmusic_admin_main_globalsettings', '', 1);