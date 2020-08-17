/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbusiness_admin_main_sesbusinessteam", "sesbusiness", "Team", "", '{"route":"admin_default","module":"sesbusinessteam","controller":"settings"}', "sesbusiness_admin_main", "", 800),
("sesbusinessteam_admin_main_settings", "sesbusinessteam", "Global Settings", "", '{"route":"admin_default","module":"sesbusinessteam","controller":"settings"}', "sesbusinessteam_admin_main", "", 1);
