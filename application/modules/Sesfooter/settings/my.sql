/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesfooter', 'sesfooter', 'SES - Advanced Footer', '', '{"route":"admin_default","module":"sesfooter","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesfooter_admin_main_settings', 'sesfooter', 'Global Settings', '', '{"route":"admin_default","module":"sesfooter","controller":"settings"}', 'sesfooter_admin_main', '', 1);