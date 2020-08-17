/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_seslisting", "seslisting", "SES - Advanced Listing", "", '{"route":"admin_default","module":"seslisting","controller":"settings"}', "core_admin_main_plugins", "", 999),
("seslisting_admin_main_settings", "seslisting", "Global Settings", "", '{"route":"admin_default","module":"seslisting","controller":"settings"}', "seslisting_admin_main", "", 1);
