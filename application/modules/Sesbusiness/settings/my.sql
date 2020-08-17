/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesbusiness', 'sesbusiness', 'SES - Business Directories', '', '{"route":"admin_default","module":"sesbusiness","controller":"settings"}', 'core_admin_main_plugins', '', 999),
("sesbusiness_admin_main_setting", "sesbusiness", "Global Settings", "", '{"route":"admin_default","module":"sesbusiness","controller":"settings"}', "sesbusiness_admin_main", "", 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesbusiness_quick_create', 'sesbusiness', 'Create New Business', 'Sesbusiness_Plugin_Menus::canCreateBusinesses', '{"route":"sesbusiness_general","action":"create","class":"buttonlink icon_sesbusiness_new"}', 'sesbusiness_quick', '', 1);
