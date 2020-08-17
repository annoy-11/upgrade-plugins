/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesadvancedheader', 'sesadvancedheader', 'SES - Advanced Header', '', '{"route":"admin_default","module":"sesadvancedheader","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesadvancedheader_admin_main_settings', 'sesadvancedheader', 'Global Settings', '', '{"route":"admin_default","module":"sesadvancedheader","controller":"settings"}', 'sesadvancedheader_admin_main', '', 1);
