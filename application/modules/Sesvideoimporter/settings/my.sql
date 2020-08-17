

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_videoimporter', 'sesvideoimporter', 'SES - Video Importer & Search', '', '{"route":"admin_default","module":"sesvideoimporter","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 999),
('videoimporter_admin_main_settings', 'sesvideoimporter', 'Global Settings', '', '{"route":"admin_default","module":"sesvideoimporter","controller":"settings"}', 'videoimporter_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesvideoimporter_main_imoprtyoutube", "sesvideoimporter", "Search Youtube Videos", "Sesvideoimporter_Plugin_Menus::canShowVideos", '{"route":"sesvideoimporter_import_youtube"}', "sesvideo_main", "", 4);
