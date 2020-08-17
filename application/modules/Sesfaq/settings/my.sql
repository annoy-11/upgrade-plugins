
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesfaq', 'sesfaq', 'SES- Multi-Use FAQs', '', '{"route":"admin_default","module":"sesfaq","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesfaq_admin_main_settings', 'sesfaq', 'Global Settings', '', '{"route":"admin_default","module":"sesfaq","controller":"settings"}', 'sesfaq_admin_main', '', 1),
('sesfaq_main_askquestion', 'sesfaq', 'Ask Question', 'Sesfaq_Plugin_Menus::askquestion', '{"class":"smoothbox", "route":"sesfaq_general","action":"askquestion"}', 'sesfaq_main', '', 6);
