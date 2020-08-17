/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbusiness_admin_main_sesbusinessvideo", "sesbusiness", "Videos", "", '{"route":"admin_default","module":"sesbusinessvideo","controller":"settings"}', "sesbusiness_admin_main", "", 800),
("sesbusinessvideo_admin_main_settings", "sesbusinessvideo", "Global Settings", "", '{"route":"admin_default","module":"sesbusinessvideo","controller":"settings"}', "sesbusinessvideo_admin_main", "", 1);
