/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslazyloadimage
 * @package    Seslazyloadimage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seslazyloadimage', 'seslazyloadimage', 'SES - Lazy Image Loading', '', '{"route":"admin_default","module":"seslazyloadimage","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('seslazyloadimage_admin_main_settings', 'seslazyloadimage', 'Global Settings', '', '{"route":"admin_default","module":"seslazyloadimage","controller":"settings"}', 'seslazyloadimage_admin_main', '', 1);
