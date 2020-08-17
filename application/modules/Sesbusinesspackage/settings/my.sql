/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbusiness_admin_packagesetting", "sesbusinesspackage", "Package Settings", "", '{"route":"admin_default","module":"sesbusinesspackage","controller":"package","action":"settings"}', "sesbusiness_admin_main", "", 2),
("sesbusiness_admin_subpackagesetting", "sesbusinesspackage", "Package Settings", "", '{"route":"admin_default","module":"sesbusinesspackage","controller":"package","action":"settings"}', "sesbusiness_admin_packagesetting", "", 1),
("sesbusiness_main_manage_package", "sesbusiness", "My Packages", "Sesbusiness_Plugin_Menus", '{"route":"sesbusiness_general","action":"package"}', "sesbusiness_main", "", 7);


