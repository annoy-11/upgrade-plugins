/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesuserdocverification", "sesuserdocverification", "SES - Member Verification via KYC Documents Plugin", "", '{"route":"admin_default","module":"sesuserdocverification","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesuserdocverification_admin_main_settings", "sesuserdocverification", "Global Settings", "", '{"route":"admin_default","module":"sesuserdocverification","controller":"settings"}', "sesuserdocverion_admin_main", "", 1);
