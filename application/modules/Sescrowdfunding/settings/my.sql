/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sescrowdfunding', 'sescrowdfunding', 'SES - Crowdfunding', '', '{"route":"admin_default","module":"sescrowdfunding","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sescrowdfunding_admin_main_settings', 'sescrowdfunding', 'Global Settings', '', '{"route":"admin_default","module":"sescrowdfunding","controller":"settings"}', 'sescrowdfunding_admin_main', '', 1),
("sescrowdfunding_admin_main_currency", "sescrowdfunding", "Manage Currency", "Sescrowdfunding_Plugin_Menus::canViewMultipleCurrency", '{"route":"admin_default","module":"sesmultiplecurrency","controller":"settings","action":"currency"}', "sescrowdfunding_admin_main", "", 15);

INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
("sescrowdfunding_create", "sescrowdfunding", '{item:$subject} create crowdfunding:', 1, 5, 1, 3, 1, 1),
("comment_sescrowdfunding", "sescrowdfunding", '{item:$subject} commented on {item:$owner}''s {item:$object:crowdfunding entry}: {body:$body}', 1, 1, 1, 1, 1, 0),
("sescrowdfunding_like_crowdfunding", "sescrowdfunding", '{item:$subject} likes the crowdfunding {item:$object}:', 1, 7, 1, 1, 1, 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sescrowdfunding_quick_create', 'sescrowdfunding', 'Create Crowdfunding', 'Sescrowdfunding_Plugin_Menus::canCreateSescrowdfundings', '{"route":"sescrowdfunding_general","action":"create","class":"buttonlink icon_sescrowdfunding_new"}', 'sescrowdfunding_quick', '', 1);


