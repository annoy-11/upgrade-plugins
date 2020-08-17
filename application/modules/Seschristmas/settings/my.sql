INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seschristmas', 'seschristmas', 'SES - Christmas & New Year Design Elements', '', '{"route":"admin_default","module":"seschristmas","controller":"settings"}', 'core_admin_main_plugins', '', 1),
('seschristmas_admin_main_settings', 'seschristmas', 'Global Settings', '', '{"route":"admin_default","module":"seschristmas","controller":"settings"}', 'seschristmas_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
('seschristmas.template1', 'a:4:{i:0;s:13:"header_before";i:1;s:12:"header_after";i:2;s:13:"footer_before";i:3;s:12:"footer_after";}'),
('seschristmas.template2', 'a:3:{i:0;s:13:"header_before";i:1;s:15:"left_right_bell";i:2;s:13:"footer_before";}');
