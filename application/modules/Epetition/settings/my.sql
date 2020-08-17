 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom` ,`order`) VALUES
("core_admin_main_plugins_epetition", "epetition", "SNS - Petitions", "", '{"route":"admin_default","module":"epetition","controller":"settings"}', "core_admin_main_plugins", "",1,0, 999),
("epetition_admin_main_settings", "epetition", "Global Settings", "", '{"route":"admin_default","module":"epetition","controller":"settings"}', "epetition_admin_main", "",1,0, 1);
