 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eandroidstories
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

 
INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('sesstories', 'Stories Plugin', '', '4.10.5', 1, 'extra');

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("eandroidstories_admin_main_eandroidstories", "eandroidstories", "SNS - Stories Feature in Android Mobile Apps", "", '{"route":"admin_default","module":"eandroidstories","controller":"settings"}', "core_admin_main_plugins", "", 800),

("eandroidstories_admin_main_andset", "eandroidstories", "Android Stories Settings", "", '{"route":"admin_default","module":"eandroidstories","controller":"settings"}', "sesstories_admin_main", "", 1),
("eandroidstories_admin_main_settings", "eandroidstories", "Global Settings", "", '{"route":"admin_default","module":"eandroidstories","controller":"settings"}', "eandroidstories_admin_main_andse", "", 1);
