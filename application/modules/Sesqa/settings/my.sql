/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesqa', 'sesqa', 'SES - Questions & Answers', '', '{"route":"admin_default","module":"sesqa","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 999),
('sesqa_admin_main_settings', 'sesqa', 'Global Settings', '', '{"route":"admin_default","module":"sesqa","controller":"settings"}', 'sesqa_admin_main', '', 1),
("sesqa_main_manage", "sesqa", "My Questions", "Sesqa_Plugin_Menus::canCreateQuestion", '{"route":"sesqa_general","action":"manage"}', "sesqa_main", "", 3),
("sesqa_main_create", "sesqa", "Ask Question", "Sesqa_Plugin_Menus::canCreateQuestion", '{"route":"sesqa_general","action":"create"}', "sesqa_main", "", 5);
