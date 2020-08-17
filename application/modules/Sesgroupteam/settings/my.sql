/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesgroup_admin_main_sesgroupteam", "sesgroup", "Team", "", '{"route":"admin_default","module":"sesgroupteam","controller":"settings"}', "sesgroup_admin_main", "", 800),
("sesgroupteam_admin_main_settings", "sesgroupteam", "Global Settings", "", '{"route":"admin_default","module":"sesgroupteam","controller":"settings"}', "sesgroupteam_admin_main", "", 1);
