/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my-upgrade-4.10.5p1-4.10.5p2.sql 2018-08-14 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

INSERT IGNORE INTO `engine4_sesapi_menus` (`label`, `module`, `type`, `status`, `order`, `file_id`,`class`, `device`, `is_delete`, `visibility`, `module_name`, `version`) VALUES ('Courses','courses','1','1','54','0','core_main_courses','2','0','0','courses','2.6');

INSERT IGNORE INTO `engine4_sesapi_menus` (`label`, `module`, `type`, `status`, `order`, `file_id`,`class`, `device`, `is_delete`, `visibility`, `module_name`, `version`) VALUES ('Classroom','eclassroom','1','1','54','0','core_main_eclassroom','2','0','0','eclassroom','2.6');
