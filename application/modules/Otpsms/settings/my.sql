/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("otpsms_admin_main_otpsms", "otpsms", "SES - (OTP) One Time Pass...", "", '{"route":"admin_default","module":"otpsms","controller":"settings"}', "core_admin_main_plugins", "", 800),
("otpsms_admin_main_settings", "otpsms", "Global Settings", "", '{"route":"admin_default","module":"otpsms","controller":"settings"}', "otpsms_admin_main", "", 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
("otpsms_settings_otp", "otpsms", "Phone Number", "Otpsms_Plugin_Menus::canView", '{"route":"optsms_general"}', "user_settings", "", 1, 0, 5);
