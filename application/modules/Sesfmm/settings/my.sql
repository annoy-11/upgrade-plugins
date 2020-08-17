/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesfmm", "sesfmm", "SES - Professional File & Media Manager", "", '{"route":"admin_default","module":"sesfmm","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesfmm_admin_main_settings", "sesfmm", "Global Settings", "", '{"route":"admin_default","module":"sesfmm","controller":"settings"}', "sesfmm_admin_main", "", 1);
