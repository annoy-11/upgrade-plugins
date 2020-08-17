/**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: my.sql 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesdbslide', 'sesdbslide', 'SES - Double Banner Slideshow', '', '{"route":"admin_default","module":"sesdbslide","controller":"settings"}', 'core_admin_main_plugins', '', 1),
('sesdbslide_admin_main_settings', 'sesdbslide', 'Global Settings', '', '{"route":"admin_default","module":"sesdbslide","controller":"settings"}', 'sesdbslide_admin_main', '', 1);
