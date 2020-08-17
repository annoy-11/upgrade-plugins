INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesarticle", "sesarticle", "SES - Advanced Article", "", '{"route":"admin_default","module":"sesarticle","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesarticle_admin_main_settings", "sesarticle", "Global Settings", "", '{"route":"admin_default","module":"sesarticle","controller":"settings"}', "sesarticle_admin_main", "", 1);

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("notify_sesarticle_subscribed_new", "sesarticle", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]"),
("sesarticle_owner_claim", "sesarticle", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesarticle_site_owner_for_claim", "sesarticle", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesarticle_owner_approve", "sesarticle", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesarticle_claim_owner_approve", "sesarticle", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesarticle_claim_owner_request_cancel", "sesarticle", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]");

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('sesarticle_main_import', 'sesarticle', 'Import Articles', 'Sesarticle_Plugin_Menus::canCreateSesarticles', '{"route":"sesarticle_import"}', 'sesarticle_main', '', 1, 0, 999),
('sesarticle_main_rss', 'sesarticle', 'RSS Feed', 'Sesarticle_Plugin_Menus::canViewRssarticles', '{"route":"sesarticle_general", "action":"rss-feed","target":"_blank"}', 'sesarticle_main', '', 1, 0, 999);

