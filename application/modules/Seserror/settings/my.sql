/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesblog
 * @package    Sesblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seserror', 'seserror', 'SES - Advanced Error...', '', '{"route":"admin_default","module":"seserror","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('seserror_admin_main_settings', 'seserror', 'Global Settings', '', '{"route":"admin_default","module":"seserror","controller":"settings"}', 'seserror_admin_main', '', 1);
