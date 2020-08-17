/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom` ,`order`) VALUES
('core_admin_main_plugins_emessages', 'emessages', 'SNS - Professional Messages', '', '{"route":"admin_default","module":"emessages","controller":"settings"}', 'core_admin_main_plugins', '',1,0, 999),
('emessages_admin_main_settings', 'emessages', 'Global Settings', '', '{"route":"admin_default","module":"emessages","controller":"settings"}', 'emessages_admin_main', '',1,0, 1);
