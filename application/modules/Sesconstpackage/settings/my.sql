/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesconstpackage
 * @package    Sesconstpackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-09-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesconstpackage', 'sesconstpackage', 'SES - Advanced Contests Package', '', '{"route":"admin_default","module":"sesconstpackage","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesconstpackage_admin_main_settings', 'sesconstpackage', 'Plugins Included', '', '{"route":"admin_default","module":"sesconstpackage","controller":"settings"}', 'sesconstpackage_admin_main', '', 1);
