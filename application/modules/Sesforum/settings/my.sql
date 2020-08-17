/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesforum", "sesforum", "SES - Advanced Forums", "", '{"route":"admin_default","module":"sesforum","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesforum_admin_main_settings", "sesforum", "Global Settings", "", '{"route":"admin_default","module":"sesforum","controller":"settings"}', "sesforum_admin_main", "", 1);
