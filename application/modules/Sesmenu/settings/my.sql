/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesmenu", "sesmenu", "SES - Ultimate Menus Plugin", "", '{"route":"admin_default","module":"sesmenu","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesmenu_admin_main_settings", "sesmenu", "Global Settings", "", '{"route":"admin_default","module":"sesmenu","controller":"settings"}', "sesmenu_admin_main", "", 1);
