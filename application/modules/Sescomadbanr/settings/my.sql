/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescomadbanr
 * @package    Sescomadbanr
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-03-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sescommunityads_admin_main_sescommunityadsbanner', 'sescommunityads', 'Banner Ads', '', '{"route":"admin_default","module":"sescomadbanr","controller":"settings"}', 'sescommunityads_admin_main', '', 999),
('sescomadbanr_admin_main_settings', 'sescomadbanr', 'Global Settings', '', '{"route":"admin_default","module":"sescomadbanr","controller":"settings"}', 'sescomadbanr_admin_main', '', 1);
