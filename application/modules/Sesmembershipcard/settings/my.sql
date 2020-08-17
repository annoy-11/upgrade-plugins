/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmembershipcard_admin_main_plugin", "sesmembershipcard", "SES - Memberships Card Plugin", "", '{"route":"admin_default","module":"sesmembershipcard","controller":"settings","action":"index"}', "core_admin_main_plugins", "", 999),
("sesmembershipcard_admin_main_settings", "sesmembershipcard", "Global Settings", "", '{"route":"admin_default","module":"sesmembershipcard","controller":"settings","action":"index"}', "sesmembershipcard_admin_main", "", 1);
