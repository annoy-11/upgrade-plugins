 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_einstaclone', 'einstaclone', 'SNS - Insta Clone', '', '{"route":"admin_default","module":"einstaclone","controller":"settings"}', 'core_admin_main', '', 888),
('einstaclone_admin_main_settings', 'einstaclone', 'Global Settings', '', '{"route":"admin_default","module":"einstaclone","controller":"settings"}', 'einstaclone_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('einstaclone_mini_explore', 'einstaclone', 'Explore', '', '{"route":"einstaclone_default","module":"einstaclone","controller":"index", "action":"explore"}', 'core_mini', '', 999);
