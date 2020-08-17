/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sescrowdfunding_admin_main_sescrowdfundingteam", "sescrowdfunding", "Team", "", '{"route":"admin_default","module":"sescrowdfundingteam","controller":"settings"}', "sescrowdfunding_admin_main", "", 800),
("sescrowdfundingteam_admin_main_settings", "sescrowdfundingteam", "Global Settings", "", '{"route":"admin_default","module":"sescrowdfundingteam","controller":"settings"}', "sescrowdfundingteam_admin_main", "", 1);
