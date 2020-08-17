
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessiteiframe
 * @package    Sessiteiframe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-10-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sessiteiframe', 'sessiteiframe', 'SES - Embed Site in iFrame for Continuous Music', '', '{"route":"admin_default","module":"sessiteiframe","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sessiteiframe_admin_main_settings', 'sessiteiframe', 'Global Settings', '', '{"route":"admin_default","module":"sessiteiframe","controller":"settings"}', 'sessiteiframe_admin_main', '', 1);