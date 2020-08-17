/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesmediaimporter', 'sesmediaimporter', 'SES - Social Photo Media...', '', '{"route":"admin_default","module":"sesmediaimporter","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesmediaimporter_admin_main_settings', 'sesmediaimporter', 'Global Settings', '', '{"route":"admin_default","module":"sesmediaimporter","controller":"settings"}', 'sesmediaimporter_admin_main', '', 1);
