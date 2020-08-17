/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesytube', 'sesytube', 'SES - UTube Clone Theme', '', '{"route":"admin_default","module":"sesytube","controller":"settings"}', 'core_admin_main', '', 999),
('sesytube_admin_main_settings', 'sesytube', 'Global Settings', '', '{"route":"admin_default","module":"sesytube","controller":"settings"}', 'sesytube_admin_main', '', 1);
