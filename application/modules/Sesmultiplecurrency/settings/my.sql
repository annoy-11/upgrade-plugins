
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmultiplecurrency
 * @package    Sesmultiplecurrency
 * @copyright  Copyright 2019-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-09-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmultiplecurrency_admin_main", "sesmultiplecurrency", "SES - Multiple Currencies...", "", '{"route":"admin_default","module":"sesmultiplecurrency","controller":"settings", "action":"index"}', "core_admin_main_plugins", "", 995),
('sesmultiplecurrency_admin_main_settings', 'sesmultiplecurrency', 'Global Settings', '', '{"route":"admin_default","module":"sesmultiplecurrency","controller":"settings","action":"index"}', 'sesmultiplecurrency_admin_main', '', 1);
