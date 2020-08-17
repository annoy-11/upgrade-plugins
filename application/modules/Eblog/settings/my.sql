/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_eblog", "eblog", "SES - Advanced Blog", "", '{"route":"admin_default","module":"eblog","controller":"settings"}', "core_admin_main_plugins", "", 999),
("eblog_admin_main_settings", "eblog", "Global Settings", "", '{"route":"admin_default","module":"eblog","controller":"settings"}', "eblog_admin_main", "", 1);

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("notify_eblog_subscribed_new", "eblog", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]"),
("eblog_blog_owner_claim", "eblog", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("eblog_site_owner_for_claim", "eblog", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("eblog_blog_owner_approve", "eblog", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("eblog_claim_owner_approve", "eblog", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]"),
("eblog_claim_owner_request_cancel", "eblog", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]");

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('eblog_main_import', 'eblog', 'Import Blogs', 'Eblog_Plugin_Menus::canCreateEblogs', '{"route":"eblog_import"}', 'eblog_main', '', 1, 0, 999),
('eblog_main_rss', 'eblog', 'RSS Feed', 'Eblog_Plugin_Menus::canViewRssblogs', '{"route":"eblog_general", "action":"rss-feed"}', 'eblog_main', '', 1, 0, 999);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("eblog_admin_main_manageimport", "eblog", "Import CSV File", "", '{"route":"admin_default","module":"eblog","controller":"manage-imports", "action":"index"}', "eblog_admin_main", "", 999);
