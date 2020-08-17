/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sescrowdfunding_admin_main_sescrowdfundingvideo", "sescrowdfunding", "Videos", "", '{"route":"admin_default","module":"sescrowdfundingvideo","controller":"settings"}', "sescrowdfunding_admin_main", "", 800),
("sescrowdfundingvideo_admin_main_settings", "sescrowdfundingvideo", "Global Settings", "", '{"route":"admin_default","module":"sescrowdfundingvideo","controller":"settings"}', "sescrowdfundingvideo_admin_main", "", 1);
