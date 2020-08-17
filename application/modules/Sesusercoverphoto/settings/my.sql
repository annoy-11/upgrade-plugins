/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('sesusercoverphoto', 'SES - Member Profiles Cover Photo & Video Plugin', '', '4.10.5', 1, 'extra'),
('sesusercovervideo', 'SES - Member Profiles Cover Photo & Video Plugin', 'SES - Member Profiles Cover Photo & Video Plugin', '4.10.5', '1', 'extra');
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES 
('core_admin_main_plugins_sesusercoverphoto', 'sesusercoverphoto', 'SES - Member Profiles Cover Photo & Video Plugin', '', '{"route":"admin_default","module":"sesusercoverphoto","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesusercoverphoto_admin_main_setting', 'sesusercoverphoto', 'Global Settings', '', '{"route":"admin_default","module":"sesusercoverphoto","controller":"settings"}', 'sesusercoverphoto_admin_main', '', 1);
