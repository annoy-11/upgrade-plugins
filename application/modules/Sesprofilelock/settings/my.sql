/**
 * SocialEngineSolutions
 *
 * @category   Application_Disaster
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesprofilelock', 'sesprofilelock', 'SES - User Accounts Privacy...', '', '{"route":"admin_default","module":"sesprofilelock","controller":"settings"}', 'core_admin_main_plugins', '', 10),
('sesprofilelock_admin_main_settings', 'sesprofilelock', 'Global Settings', '', '{"route":"admin_default","module":"sesprofilelock","controller":"settings"}', 'sesprofilelock_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
('sesprofilelock.popupinfo', 'a:5:{i:0;s:10:"site_title";i:1;s:12:"member_title";i:2;s:5:"email";i:3;s:11:"locked_text";i:4;s:12:"signout_link";}'),
('sesproflelock.levels', 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');
