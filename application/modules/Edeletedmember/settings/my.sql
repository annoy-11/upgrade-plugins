
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("edeletedmember_admin_main_edeletedmember", "edeletedmember", "SNS - Deleted Members", "", '{"route":"admin_default","module":"edeletedmember","controller":"settings"}', "core_admin_main_plugins", "", 800),
("edeletedmember_admin_main_settings", "edeletedmember", "Global Settings", "", '{"route":"admin_default","module":"edeletedmember","controller":"settings"}', "edeletedmember_admin_main", "", 1);
