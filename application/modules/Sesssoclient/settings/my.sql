/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoclient
 * @package    Sesssoclient
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesssoclient', 'sesssoclient', 'SES - SSO Client', '', '{"route":"admin_default","module":"sesssoclient","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesssoclient_admin_main_settings', 'sesssoclient', 'Global Settings', '', '{"route":"admin_default","module":"sesssoclient","controller":"settings"}', 'sesssoclient_admin_main', '', 1);
