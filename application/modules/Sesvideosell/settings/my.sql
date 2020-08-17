

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesvideosell', 'sesvideosell', 'SES - Advanced Videos - Sell Extension', '', '{"route":"admin_default","module":"sesvideosell","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesvideosell_admin_main_settings', 'sesvideosell', 'Global Settings', '', '{"route":"admin_default","module":"sesvideosell","controller":"settings"}', 'sesvideosell_admin_main', '', 1);
