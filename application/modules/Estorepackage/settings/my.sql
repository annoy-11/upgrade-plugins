 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("estore_admin_packagesetting", "estorepackage", "Package Settings", "", '{"route":"admin_default","module":"estorepackage","controller":"package","action":"settings"}', "estore_admin_main", "", 2),
("estore_admin_subpackagesetting", "estorepackage", "Package Settings", "", '{"route":"admin_default","module":"estorepackage","controller":"package","action":"settings"}', "estore_admin_packagesetting", "", 1),
("estore_main_manage_package", "estore", "My Packages", "Estore_Plugin_Menus", '{"route":"estore_general","action":"package"}', "estore_main", "", 7);
