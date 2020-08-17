/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_sestwitterclone', 'sestwitterclone', 'SES - Professional Twitter Clone', '', '{"route":"admin_default","module":"sestwitterclone","controller":"settings"}', 'core_admin_main', '', 888),
('sestwitterclone_admin_main_settings', 'sestwitterclone', 'Global Settings', '', '{"route":"admin_default","module":"sestwitterclone","controller":"settings"}', 'sestwitterclone_admin_main', '', 1);
