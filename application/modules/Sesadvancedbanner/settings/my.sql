
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: my.sql 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesadvancedbanner', 'sesadvancedbanner', 'SES - Advanced Banner', '', '{"route":"admin_default","module":"sesadvancedbanner","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesadvancedbanner_admin_main_settings', 'sesadvancedbanner', 'Global Settings', '', '{"route":"admin_default","module":"sesadvancedbanner","controller":"settings"}', 'sesadvancedbanner_admin_main', '', 1);
