/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecentlogin
 * @package    Sesrecentlogin
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesrecentlogin', 'sesrecentlogin', 'SES - Recent Login...', '', '{"route":"admin_default","module":"sesrecentlogin","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesrecentlogin_admin_main_settings', 'sesrecentlogin', 'Global Settings', '', '{"route":"admin_default","module":"sesrecentlogin","controller":"settings"}', 'sesrecentlogin_admin_main', '', 1);
