/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_emailtemplates", "emailtemplates", "SES - Ultimate Email Templates...", "", '{"route":"admin_default","module":"emailtemplates","controller":"settings"}', "core_admin_main_plugins", "", 999),
("emailtemplates_admin_main_settings", "emailtemplates", "Global Settings", "", '{"route":"admin_default","module":"emailtemplates","controller":"settings"}', "emailtemplates_admin_main", "", 1);
