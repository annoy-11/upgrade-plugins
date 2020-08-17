/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesemoji', 'sesemoji', 'SES - iOS, Android....', '', '{"route":"admin_default","module":"sesemoji","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesemoji_admin_main_settings', 'sesemoji', 'Global Settings', '', '{"route":"admin_default","module":"sesemoji","controller":"settings"}', 'sesemoji_admin_main', '', 1);
