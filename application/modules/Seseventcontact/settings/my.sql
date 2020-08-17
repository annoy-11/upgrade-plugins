INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('seseventcontact', 'seseventcontact', 'seseventcontact', '4.8.9', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seseventcontact', 'seseventcontact', 'SES - Advanced Events Contact Extension', '', '{"route":"admin_default","module":"seseventcontact","controller":"manage"}', 'core_admin_main_plugins', '', 1),

("seseventcontact_admin_main_manage", "seseventcontact", "Mail to Event Owner", "", '{"route":"admin_default","module":"seseventcontact","controller":"manage"}', "seseventcontact_admin_main", "", 2),

("seseventcontact_admin_main_mailhost", "seseventcontact", "Mail to Event Host", "", '{"route":"admin_default","module":"seseventcontact","controller":"manage", "action":"mailhost"}', "seseventcontact_admin_main", "", 3);

INSERT IGNORE INTO `engine4_core_mailtemplates` ( `type`, `module`, `vars`) VALUES
('SESEVENTCONTACT_EVENTOWNER_CONTACT', 'seseventcontact', '[host],[email],[recipient_title],[subject],[message]'),
('SESEVENTCONTACT_EVENTOWNER_CONTACTHOST', 'seseventcontact', '[host],[email],[recipient_title],[subject],[message]');