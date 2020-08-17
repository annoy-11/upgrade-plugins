INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesrecipe", "sesrecipe", "SES - Recipes With Reviews & Location", "", '{"route":"admin_default","module":"sesrecipe","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesrecipe_admin_main_settings", "sesrecipe", "Global Settings", "", '{"route":"admin_default","module":"sesrecipe","controller":"settings"}', "sesrecipe_admin_main", "", 1);

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("notify_sesrecipe_subscribed_new", "sesrecipe", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]"),
("sesrecipe_recipe_owner_claim", "sesrecipe", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesrecipe_site_owner_for_claim", "sesrecipe", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesrecipe_recipe_owner_approve", "sesrecipe", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesrecipe_claim_owner_approve", "sesrecipe", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("sesrecipe_claim_owner_request_cancel", "sesrecipe", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]");

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('sesrecipe_main_import', 'sesrecipe', 'Import Recipes', 'Sesrecipe_Plugin_Menus::canCreateSesrecipes', '{"route":"sesrecipe_import"}', 'sesrecipe_main', '', 1, 0, 999),
('sesrecipe_main_rss', 'sesrecipe', 'RSS Feed', 'Sesrecipe_Plugin_Menus::canViewRssrecipes', '{"route":"sesrecipe_general", "action":"rss-feed"}', 'sesrecipe_main', '', 1, 0, 999);
