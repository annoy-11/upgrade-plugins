
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesmemveroth", "sesmemveroth", "SES - Members Verification...", "", '{"route":"admin_default","module":"sesmemveroth","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesmemveroth_admin_main_settings", "sesmemveroth", "Global Settings", "", '{"route":"admin_default","module":"sesmemveroth","controller":"settings"}', "sesmemveroth_admin_main", "", 1);
