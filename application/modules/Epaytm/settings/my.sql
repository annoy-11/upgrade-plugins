 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_Epaytm", "epaytm", "SNS - Paytm Payment Gateway", "", '{"route":"admin_default","module":"epaytm","controller":"settings"}', "core_admin_main_plugins", "", 999),
("epaytm_admin_main_settings", "epaytm", "Global Settings", "", '{"route":"admin_default","module":"epaytm","controller":"settings"}', "epaytm_admin_main", "", 1);
