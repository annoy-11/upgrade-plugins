/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesgroup_admin_main_sesgroupvideo", "sesgroup", "Videos", "", '{"route":"admin_default","module":"sesgroupvideo","controller":"settings"}', "sesgroup_admin_main", "", 800),
("sesgroupvideo_admin_main_settings", "sesgroupvideo", "Global Settings", "", '{"route":"admin_default","module":"sesgroupvideo","controller":"settings"}', "sesgroupvideo_admin_main", "", 1);
