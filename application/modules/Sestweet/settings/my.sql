

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sestweet', 'sestweet', 'SES - Click To Tweet', '', '{"route":"admin_default","module":"sestweet","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sestweet_admin_main_settings', 'sestweet', 'Global Settings', '', '{"route":"admin_default","module":"sestweet","controller":"settings"}', 'sestweet_admin_main', '', 1);
