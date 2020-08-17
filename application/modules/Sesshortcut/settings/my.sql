/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesshortcut', 'sesshortcut', 'SES - Add To Shortcuts...', '', '{"route":"admin_default","module":"sesshortcut","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesshortcut_admin_main_settings', 'sesshortcut', 'Global Settings', '', '{"route":"admin_default","module":"sesshortcut","controller":"settings"}', 'sesshortcut_admin_main', '', 1);
