/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sespage', 'sespage', 'SES - Page Directories', '', '{"route":"admin_default","module":"sespage","controller":"settings"}', 'core_admin_main_plugins', '', 999),
("sespage_admin_main_setting", "sespage", "Global Settings", "", '{"route":"admin_default","module":"sespage","controller":"settings"}', "sespage_admin_main", "", 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sespage_quick_create', 'sespage', 'Create New Page', 'Sespage_Plugin_Menus::canCreatePages', '{"route":"sespage_general","action":"create","class":"buttonlink icon_sespage_new"}', 'sespage_quick', '', 1);
