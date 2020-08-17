/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesavatar', 'sesavatar', 'SES - Custom Avatar', '', '{"route":"admin_default","module":"sesavatar","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesavatar_admin_main_settings', 'sesavatar', 'Global Settings', '', '{"route":"admin_default","module":"sesavatar","controller":"settings"}', 'sesavatar_admin_main', '', 1);
