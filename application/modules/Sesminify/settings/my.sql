
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesminify", "sesminify", "SES - JS & CSS Minify", "", '{"route":"admin_default","module":"sesminify","controller":"settings"}', "core_admin_main_plugins", "", 1),
("sesminifyadmin_admin_main_settings", "sesminify", "Global Settings", "", '{"route":"admin_default","module":"sesminify","controller":"settings"}', "sesminify_admin_main", "", 1);