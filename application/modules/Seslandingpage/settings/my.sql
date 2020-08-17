/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seslandingpage', 'seslandingpage', 'SES - Custom/Content/Members Widget Collection', '', '{"route":"admin_default","module":"seslandingpage","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('seslandingpage_admin_main_settings', 'seslandingpage', 'Global Settings', '', '{"route":"admin_default","module":"seslandingpage","controller":"settings"}', 'seslandingpage_admin_main', '', 1);
