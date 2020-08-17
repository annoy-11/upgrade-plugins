/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesmember', 'sesmember', 'SES - Advanced Members', '', '{"route":"admin_default","module":"sesmember","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesmember_admin_main_settings', 'sesmember', 'Global Settings', '', '{"route":"admin_default","module":"sesmember","controller":"settings"}', 'sesmember_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
('sesmember_follow', 'sesmember', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]');
