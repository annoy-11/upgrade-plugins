 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my.sql 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('courses', 'Courses - Learning Management System', '', '4.10.4', 1, 'extra'),
('eclassroom', 'Courses - Learning Management System', 'Courses - Learning Management System', '4.10.4', '1', 'extra');

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_courses", "courses", "Courses - Learning Management System", "", '{"route":"admin_default","module":"courses","controller":"settings"}', "core_admin_main_plugins", "", 999),
("courses_admin_main_setting", "courses", "Global Settings", "", '{"route":"admin_default","module":"courses","controller":"settings"}', "courses_admin_main", "", 1),
("courses_admin_main_course", "courses", "Course Global Settings", "", '{"route":"admin_default","module":"courses","controller":"settings"}', "courses_admin_main_setting", "", 1),
("courses_quick_create", "courses", "Create New Courses", "Courses_Plugin_Menus::canQuickCreateCourses", '{"route":"courses_general","action":"create","class":"buttonlink icon_courses_new"}', "courses_quick", "", 12),
("courses_quick_lecture", "courses", "Create New Lecture", "Courses_Plugin_Menus::canQuickCreateLecture", '{"route":"lecture_general","action":"create","class":"buttonlink icon_courses_new"}', "courses_lecture_quick", "", 12),
("courses_admin_main_currency", "courses", "Manage Currency", "Courses_Plugin_Menus::canViewMultipleCurrency", '{"route":"admin_default","module":"sesbasic","controller":"settings","action":"currency","target":"_blank"}', "courses_admin_main_manageorde", "", 4),
("eclassroom_quick_create", "eclassroom", "Create New Classroom", "Eclassroom_Plugin_Menus::canCreateClassrooms", '{"route":"eclassroom_general","action":"create","class":"buttonlink icon_eclassroom_new"}', "eclassroom_quick","", 11),
("eclassroom_main_create", "eclassroom", "Create New Classroom", "Eclassroom_Plugin_Menus::canCreateClassrooms", '{"route":"eclassroom_general","action":"create","class":"buttonlink icon_eclassroom_new"}', "courses_main", "", 11),
("courses_main_create", "courses", "Create New Courses", "Courses_Plugin_Menus::canCreateCourses", '{"route":"courses_general","action":"create","class":"buttonlink icon_courses_new"}', "courses_main","", 12),
("courses_add_cart_dropdown", "courses", "Add To Cart", "Courses_Plugin_Menus::addtocart", '{"route":"courses_cart","module":"courses"}', "core_mini", "", "6");

INSERT INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `editable`, `is_generated`) VALUES
('eclassroom_classroom_pfphoto', 'eclassroom', '{item:$subject} has update his profile photo.', 1, 5, 1, 3, 1, 0, 1);
