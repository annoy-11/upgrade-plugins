/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesgroup_admin_packagesetting", "sesgrouppackage", "Package Settings", "", '{"route":"admin_default","module":"sesgrouppackage","controller":"package","action":"settings"}', "sesgroup_admin_main", "", 2),
("sesgroup_admin_subpackagesetting", "sesgrouppackage", "Package Settings", "", '{"route":"admin_default","module":"sesgrouppackage","controller":"package","action":"settings"}', "sesgroup_admin_packagesetting", "", 1),
("sesgroup_main_manage_package", "sesgroup", "My Packages", "Sesgroup_Plugin_Menus", '{"route":"sesgroup_general","action":"package"}', "sesgroup_main", "", 7);




