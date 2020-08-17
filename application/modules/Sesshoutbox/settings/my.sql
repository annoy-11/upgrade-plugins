/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesshoutbox', 'sesshoutbox', 'SES - Shoutbox', '', '{"route":"admin_default","module":"sesshoutbox","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesshoutbox_admin_main_settings', 'sesshoutbox', 'Global Settings', '', '{"route":"admin_default","module":"sesshoutbox","controller":"settings"}', 'sesshoutbox_admin_main', '', 1);
