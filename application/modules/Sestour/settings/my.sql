
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sestour', 'sestour', 'SES - Step by Step Webpage Introduction Tour', '', '{"route":"admin_default","module":"sestour","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sestour_admin_main_settings', 'sestour', 'Global Settings', '', '{"route":"admin_default","module":"sestour","controller":"settings"}', 'sestour_admin_main', '', 1);