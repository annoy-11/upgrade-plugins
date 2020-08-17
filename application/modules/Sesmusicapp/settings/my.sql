/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesmusicapp', 'sesmusicapp', 'SES - Custom Music for Mobile Apps Extension', '', '{"route":"admin_default","module":"sesmusicapp","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesmusicapp_admin_main_settings', 'sesmusicapp', 'Global Settings', '', '{"route":"admin_default","module":"sesmusicapp","controller":"settings"}', 'sesmusicapp_admin_main', '', 1);
