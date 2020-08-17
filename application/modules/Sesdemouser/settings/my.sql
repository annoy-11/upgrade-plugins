/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesdemouser', 'sesdemouser', 'SES - Site Tour by Auto Logging With Test User', '', '{"route":"admin_default","module":"sesdemouser","controller":"settings"}', 'core_admin_main_plugins', '', 1),
('sesdemouser_admin_main_settings', 'sesdemouser', 'Global Settings', '', '{"route":"admin_default","module":"sesdemouser","controller":"settings"}', 'sesdemouser_admin_main', '', 1);
