/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesadvpoll", "sesadvpoll", "SES - Advanced Polls", "", '{"route":"admin_default","module":"sesadvpoll","controller":"settings"}', "core_admin_main_plugins", "", 999),
('sesadvpoll_admin_main_settings', 'sesadvpoll', 'Global Settings', '', '{"route":"admin_default","module":"sesadvpoll","controller":"settings"}', 'sesadvpoll_admin_main', '', 1),
("sesadvpoll_main_pollbrowse", "sesadvpoll", "Browse Polls", "Sesadvpoll_Plugin_Menus::canViewPolls", '{"route":"sesadvpoll_general","action":"browse"}',"sesadvpoll_main","", 2),
('sesadvpoll_main_manage', 'sesadvpoll', 'My Entries', 'Sesadvpoll_Plugin_Menus::canCreatePolls', '{"route":"sesadvpoll_general","action":"manage"}', 'sesadvpoll_main', '', 3),
("sesadvpoll_main_create", "sesadvpoll", "Create Polls", "Sesadvpoll_Plugin_Menus::canCreatePolls", '{"route":"sesadvpoll_general","action":"create"}',"sesadvpoll_main","", 4);
