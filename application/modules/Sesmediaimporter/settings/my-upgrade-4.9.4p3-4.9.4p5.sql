INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesmediaimporter_admin_main_level', 'sesmediaimporter', 'Member Level Settings', '', '{"route":"admin_default","module":"sesmediaimporter","controller":"level"}', 'sesmediaimporter_admin_main', '', 1);

INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
  level_id as `level_id`,
  'sesmediaimporter' as `type`,
  'allow_service' as `name`,
  5 as `value`,
  '["facebook", "instagram","flickr", "google", "px500","zip"]' as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');


INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
('sesmediaimporter_import_error', 'sesmediaimporter', 'All the photos you were trying to upload are not uploaded as during the upload, the storage limit of your account got filled {var:$sesmediaLink}.', 0, '');

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
('notify_sesmediaimporter_import_error', 'sesmediaimporter', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]');