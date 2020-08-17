
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesletteravatar', 'sesletteravatar', 'SES - Letter Avatar of Member Name Plugin', '', '{"route":"admin_default","module":"sesletteravatar","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesletteravatar_admin_main_settings', 'sesletteravatar', 'Global Settings', '', '{"route":"admin_default","module":"sesletteravatar","controller":"settings"}', 'sesletteravatar_admin_main', '', 1);