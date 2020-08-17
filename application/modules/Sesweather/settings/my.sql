/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */	

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesweather', 'sesweather', 'SES - Weather', '', '{"route":"admin_default","module":"sesweather","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesweather_admin_main_settings', 'sesweather', 'Global Settings', '', '{"route":"admin_default","module":"sesweather","controller":"settings"}', 'sesweather_admin_main', '', 1);
