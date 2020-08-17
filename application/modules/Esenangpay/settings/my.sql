INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('esenangpay', 'Senangpay Payment Gateway', '', '4.0.0', 1, 'extra');

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_esenangpay', 'esenangpay', 'SES - SenangPay Payment Gateway Plugin', '', '{"route":"admin_default","module":"esenangpay","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('esenangpay_admin_main_settings', 'esenangpay', 'Global Settings', '', '{"route":"admin_default","module":"esenangpay","controller":"settings"}', 'esenangpay_admin_main', '', 1),
('esenangpay_admin_main_gateway', 'esenangpay', 'Manage Gateway', '', '{"route":"admin_default","module":"payment","controller":"gateway","target":"_blank"}', 'esenangpay_admin_main', '', 2);

INSERT INTO `engine4_payment_gateways` (`gateway_id`, `title`, `description`, `enabled`, `plugin`, `test_mode`) VALUES
(5, 'SenangPay', NULL, 0, 'Esenangpay_Plugin_Gateway_Senangpay', 1);