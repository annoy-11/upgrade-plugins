/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesgroup_admin_main_sesbusinesspoll', 'sesbusinesspoll', 'Polls', '', '{"route":"admin_default","module":"sesbusinesspoll","controller":"settings"}', 'sesbusiness_admin_main', '', 999),
('sesbusinesspoll_admin_main_settings', 'sesbusinesspoll', 'Global Settings', '', '{"route":"admin_default","module":"sesbusinesspoll","controller":"settings"}', 'sesbusinesspoll_admin_main', '', 1);

