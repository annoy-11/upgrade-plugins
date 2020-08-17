/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: my.sql 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesultimateslide', 'sesultimateslide', 'SES - Ultimate Banner Slideshow', '', '{"route":"admin_default","module":"sesultimateslide","controller":"settings"}', 'core_admin_main_plugins', '', 1),
('sesultimateslide_admin_main_settings', 'sesultimateslide', 'Global Settings', '', '{"route":"admin_default","module":"sesultimateslide","controller":"settings"}', 'sesultimateslide_admin_main', '', 1);
