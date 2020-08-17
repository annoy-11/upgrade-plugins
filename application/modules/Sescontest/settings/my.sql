/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sescontest', 'sescontest', 'SES - Advanced Contests', '', '{"route":"admin_default","module":"sescontest","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sescontest_admin_main_settings', 'sescontest', 'Global Settings', '', '{"route":"admin_default","module":"sescontest","controller":"settings"}', 'sescontest_admin_main', '', 1),
("sescontest_quick_create", "sescontest", "Create New Contest", "Sescontest_Plugin_Menus::canCreateContests", '{"route":"sescontest_general","action":"create","class":"buttonlink icon_sescontest_new"}', "sescontest_quick", "", 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbasic_admin_tooltip", "sesbasic", "Tooltip Settings", "", '{"route":"admin_default","module":"sesbasic","controller":"tooltip","action":"index"}', "sesbasic_admin_main", "", 4),
("sesbasic_admin_main_generaltooltip", "sesbasic", "General Settings", "", '{"route":"admin_default","module":"sesbasic","controller":"tooltip","action":"index"}', "sesbasic_admin_tooltipsettings", "", 1),
("sesbasic_admin_main_sescontest", "sesbasic", "Advanced Contests", "", '{"route":"admin_default","module":"sesbasic","controller":"tooltip","action":"index","modulename":"sescontest_contest"}', "sesbasic_admin_tooltipsettings", "", 2);
