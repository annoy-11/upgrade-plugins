/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sespage_admin_main_sespagepoll', 'sespage', 'Polls', '', '{"route":"admin_default","module":"sespagepoll","controller":"settings"}', 'sespage_admin_main', '', 999),
('sespagepoll_admin_main_settings', 'sespagepoll', 'Global Settings', '', '{"route":"admin_default","module":"sespagepoll","controller":"settings"}', 'sespagepoll_admin_main', '', 1);
