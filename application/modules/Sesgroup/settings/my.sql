/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesgroup', 'sesgroup', 'SES - Group Communities', '', '{"route":"admin_default","module":"sesgroup","controller":"settings"}', 'core_admin_main_plugins', '', 999),
("sesgroup_admin_main_setting", "sesgroup", "Global Settings", "", '{"route":"admin_default","module":"sesgroup","controller":"settings"}', "sesgroup_admin_main", "", 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesgroup_quick_create', 'sesgroup', 'Create New Group', 'Sesgroup_Plugin_Menus::canCreateGroups', '{"route":"sesgroup_general","action":"create","class":"buttonlink icon_sesgroup_new"}', 'sesgroup_quick', '', 1);
