/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesinterest', 'sesinterest', 'SES - Interests', '', '{"route":"admin_default","module":"sesinterest","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesinterest_admin_main_settings', 'sesinterest', 'Global Settings', '', '{"route":"admin_default","module":"sesinterest","controller":"settings"}', 'sesinterest_admin_main', '', 1);
