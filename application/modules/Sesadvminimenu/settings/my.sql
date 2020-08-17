/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvminimenu
 * @package    Sesadvminimenu
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesadvminimenu', 'sesadvminimenu', 'SES - Advanced Mini Navigation Menu', '', '{"route":"admin_default","module":"sesadvminimenu","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesadvminimenu_admin_main_settings', 'sesadvminimenu', 'Global Settings', '', '{"route":"admin_default","module":"sesadvminimenu","controller":"settings"}', 'sesadvminimenu_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`, `order`) VALUES
('sesadvminimenu_mini', 'standard', 'SES - Advanced Mini Navigation Menu', 999);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('sesadvminimenu_mini_admin', 'sesadvminimenu', 'Admin', 'Sesadvminimenu_Plugin_Menus', '', 'sesadvminimenu_mini', '', 1, 0, 2),
('sesadvminimenu_mini_profile', 'sesadvminimenu', 'My Profile', 'Sesadvminimenu_Plugin_Menus', '', 'sesadvminimenu_mini', '', 1, 0, 3),
('sesadvminimenu_mini_settings', 'sesadvminimenu', 'Settings', 'Sesadvminimenu_Plugin_Menus', '', 'sesadvminimenu_mini', '', 1, 0, 5),
('sesadvminimenu_mini_auth', 'sesadvminimenu', 'Auth', 'Sesadvminimenu_Plugin_Menus', '', 'sesadvminimenu_mini', '', 1, 0, 6),
('sesadvminimenu_mini_signup', 'sesadvminimenu', 'Signup', 'Sesadvminimenu_Plugin_Menus', '', 'sesadvminimenu_mini', '', 1, 0, 7),
('sesadvminimenu_mini_messages', 'sesadvminimenu', 'Message', 'Sesadvminimenu_Plugin_Menus', '', 'sesadvminimenu_mini', '', 1, 0, 4);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesadvminimenu_mini_notification", "sesadvminimenu", "Notifications", "", '{"route":"default","module":"sesadvminimenu","controller":"notifications","action":"pulldown"}', "sesadvminimenu_mini", "", 999),
("sesadvminimenu_mini_friends", "sesadvminimenu", "Friend Requests", "", '{"route":"default","module":"sesadvminimenu","controller":"index","action":"friend-request"}', "sesadvminimenu_mini", "", 999);
-- ALTER TABLE `engine4_core_menuitems` ADD `file_id` INT(11) NOT NULL;