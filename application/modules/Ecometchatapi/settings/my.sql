 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_ecometchatapi', 'ecometchatapi', 'SNS - Comet Chat APIs Integration', '', '{"route":"admin_default","module":"ecometchatapi","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('ecometchatapi_admin_main_settings', 'ecometchatapi', 'Global Settings', '', '{"route":"admin_default","module":"ecometchatapi","controller":"settings"}', 'ecometchatapi_admin_main', '', 1);
