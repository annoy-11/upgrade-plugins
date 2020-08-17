/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedactivity
 * @package    Sesadvancedactivity
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_settings_sesadvsitenotification', 'sesadvsitenotification', 'SES - Advanced Site Notifications...', '', '{"route":"admin_default","module":"sesadvsitenotification","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 1),
('sesadvsitenotification_admin_main_settings', 'sesadvsitenotification', 'Notification Popup Settings', '', '{"route":"admin_default","module":"sesadvsitenotification","controller":"settings","action":"index"}', 'sesadvsitenotification_admin_main', '', 1);
