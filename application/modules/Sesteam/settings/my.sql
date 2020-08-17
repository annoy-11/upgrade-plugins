
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesteam', 'sesteam', 'SES - Team Showcase & Multi-Use Team', '', '{"route":"admin_default","module":"sesteam","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesteam_admin_main_settings', 'sesteam', 'Global Settings', '', '{"route":"admin_default","module":"sesteam","controller":"settings"}', 'sesteam_admin_main', '', 1);
