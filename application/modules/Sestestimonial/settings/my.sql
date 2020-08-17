/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sestestimonial', 'sestestimonial', 'SES - Testimonial Showcase', '', '{"route":"admin_default","module":"sestestimonial","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sestestimonial_admin_main_settings', 'sestestimonial', 'Global Settings', '', '{"route":"admin_default","module":"sestestimonial","controller":"settings"}', 'sestestimonial_admin_main', '', 1),
("sestestimonial_main_manage", "sestestimonial", "My Testimonials", 'Sestestimonial_Plugin_Menus::canCreateSestestimonials', '{"route":"sestestimonial_general","action":"manage"}', 'sestestimonial_main', '', 2),
('sestestimonial_main_create', 'sestestimonial', 'Write New Testimonial', 'Sestestimonial_Plugin_Menus::canCreateSestestimonials', '{"route":"sestestimonial_general","action":"create"}', 'sestestimonial_main', '', 3);
