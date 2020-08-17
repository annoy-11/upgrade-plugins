/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id:  my.sql 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_settings_sesbrowserpush', 'sesbrowserpush', 'SES - Web & Mobile...', '', '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 1),
('sesbrowserpush_admin_main_settings', 'sesbrowserpush', 'Global Settings', '', '{"route":"admin_default","module":"sesbrowserpush","controller":"settings","action":"index"}', 'sesbrowserpush_admin_main', '', 1);
